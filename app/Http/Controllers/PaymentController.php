<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }

    public function create()
    {
        $user = Auth::user();

        $alreadyPaid = $user->invoices()
            ->where('type', 'formulir')
            ->where('status', 'paid')
            ->exists();

        if ($alreadyPaid) {
            return redirect()->route('dashboard')
                ->with('info', 'Anda sudah membayar biaya formulir. Silakan lanjut ke pengisian formulir.');
        }

        $invoice = null;

        try {
            $lock = Cache::lock('invoice:formulir:user:'.$user->id, 10);
            $invoice = $lock->block(5, function () use ($user) {
                $existing = Invoice::where('user_id', $user->id)
                    ->where('type', 'formulir')
                    ->where('status', 'pending')
                    ->latest('id')
                    ->first();

                if ($existing && $existing->created_at->addHours(24)->isPast()) {
                    $existing->update(['status' => 'expired']);
                    $existing = null;
                }

                if ($existing) {
                    return $existing;
                }

                if (Invoice::where('user_id', $user->id)->where('type', 'formulir')->where('status', 'paid')->exists()) {
                    throw new \RuntimeException('FORMULIR_ALREADY_PAID');
                }

                return Invoice::create([
                    'user_id' => $user->id,
                    'type' => 'formulir',
                    'invoice_number' => 'INV-FORM-'.$user->id.'-'.time(),
                    'amount' => 300000,
                    'status' => 'pending',
                ]);
            });
            optional($lock)->release();
        } catch (\Throwable $e) {
            DB::transaction(function () use ($user, &$invoice) {
                $pending = Invoice::where('user_id', $user->id)
                    ->where('type', 'formulir')
                    ->where('status', 'pending')
                    ->lockForUpdate()
                    ->latest('id')
                    ->first();

                if ($pending && $pending->created_at->addHours(24)->isPast()) {
                    $pending->update(['status' => 'expired']);
                    $pending = null;
                }

                if ($pending) {
                    $invoice = $pending;

                    return;
                }

                $invoice = Invoice::create([
                    'user_id' => $user->id,
                    'type' => 'formulir',
                    'invoice_number' => 'INV-FORM-'.$user->id.'-'.time(),
                    'amount' => 300000,
                    'status' => 'pending',
                ]);
            });
        }

        if ($invoice->status == 'paid') {
            return redirect()->route('dashboard')->with('info', 'Anda sudah membayar biaya formulir pendaftaran.');
        }

        // Siapkan parameter untuk Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $invoice->invoice_number,
                'gross_amount' => $invoice->amount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->no_telp,
            ],
            'item_details' => [
                [
                    'id' => 'FORMULIR_PSB',
                    'price' => $invoice->amount,
                    'quantity' => 1,
                    'name' => 'Biaya Formulir Pendaftaran Santri Baru',
                ],
            ],
        ];

        try {
            if ($invoice->wasRecentlyCreated || empty($invoice->snap_token) || $invoice->status === 'expired') {
                $invoice->snap_token = null;

                $snapToken = Snap::getSnapToken($params);
                $invoice->update(['snap_token' => $snapToken]);
            } else {
                $snapToken = $invoice->snap_token;
            }

            return view('payment.create', [
                'snapToken' => $snapToken,
                'payment' => null,
                'invoice' => $invoice,
            ]);

        } catch (\Exception $e) {
            if (str_contains($e->getMessage(), 'order_id has already been taken') ||
                str_contains($e->getMessage(), 'order_id sudah digunakan')) {

                try {
                    $resp = \Midtrans\Transaction::status($invoice->invoice_number);
                    $ts = $resp->transaction_status ?? null;

                    if ($ts === 'pending' && ! empty($invoice->snap_token)) {
                        return view('payment.create', [
                            'snapToken' => $invoice->snap_token,
                            'payment' => null,
                            'invoice' => $invoice,
                        ]);
                    }

                    if ($ts === 'settlement' ||
                    ($ts === 'capture' && ($resp->payment_type ?? null) === 'credit_card' && ($resp->fraud_status ?? null) === 'accept')) {
                        return redirect()->route('dashboard')->with('info', 'Pembayaran sudah terselesaikan.');
                    }
                } catch (\Throwable $ignored) {
                }
            }

            return redirect()->route('dashboard')->with('error', 'Terjadi kesalahan saat membuat transaksi: '.$e->getMessage());
        }

    }

    /**
     * Handle notifikasi dari Midtrans.
     */
    public function notificationHandler(Request $request)
    {
        $notif = new Notification;
        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $orderId = $notif->order_id;
        $fraud = $notif->fraud_status;
        $invoice = Invoice::where('invoice_number', $orderId)->first();

        if (! $invoice) {
            return response()->json(['message' => 'Invoice not found.'], 404);
        }

        if ($invoice->status === 'paid') {
            return response()->json(['message' => 'Invoice already paid.']);
        }

        if ($transaction == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $invoice->update(['status' => 'pending']);
                } else {
                    $this->setInvoiceSuccess($invoice, $notif);
                }
            }
        } elseif ($transaction == 'settlement') {
            $this->setInvoiceSuccess($invoice, $notif);
        } elseif ($transaction == 'pending') {
            $invoice->update(['status' => 'pending']);
        } elseif ($transaction == 'deny' || $transaction == 'expire' || $transaction == 'cancel') {
            $invoice->update(['status' => 'failed']);
        }

        return response()->json(['message' => 'Notification handled successfully.']);
    }

    /**
     * Helper function untuk menandai invoice sebagai lunas dan membuat record payment.
     */
    private function setInvoiceSuccess(Invoice $invoice, Notification $notif)
    {
        $invoice->update([
            'status' => 'paid',
            'completed_at' => now(),
        ]);

        Payment::updateOrCreate(
            ['invoice_id' => $invoice->id],
            [
                'amount' => $invoice->amount,
                'payment_method' => $notif->payment_type,
                'status' => 'success',
                'midtrans_order_id' => $notif->order_id,
                'midtrans_transaction_id' => $notif->transaction_id,
                'raw_response' => json_encode($notif->getResponse()),
            ]
        );
    }
}
