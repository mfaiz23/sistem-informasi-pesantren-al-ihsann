<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        // Cari atau buat Invoice terlebih dahulu
        $invoice = Invoice::firstOrCreate(
            [
                'user_id' => $user->id,
                'type' => 'formulir',
            ],
            [
                'invoice_number' => 'INV-FORM-'.$user->id.'-'.time(),
                'amount' => 300000,
                'status' => 'pending',
            ]
        );

        // Cek apakah invoice ini sudah lunas
        if ($invoice->status == 'paid') {
            return redirect()->route('dashboard')->with('info', 'Anda sudah membayar biaya formulir pendaftaran.');
        }

        // Siapkan parameter untuk Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $invoice->invoice_number, // Gunakan invoice_number sebagai order_id
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
            $snapToken = Snap::getSnapToken($params);

            return view('payment.create', [
                'snapToken' => $snapToken,
                'payment' => null,
                'invoice' => $invoice,
            ]);

        } catch (\Exception $e) {
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

        // Cari invoice berdasarkan invoice_number yang dikirim sebagai order_id
        $invoice = Invoice::where('invoice_number', $orderId)->first();

        if (! $invoice) {
            return response()->json(['message' => 'Invoice not found.'], 404);
        }

        // Jangan proses notifikasi untuk invoice yang sudah lunas
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
        // Update status invoice menjadi 'paid'
        $invoice->update([
            'status' => 'paid',
            'completed_at' => now(),
        ]);

        // Buat atau perbarui record di tabel payments
        Payment::updateOrCreate(
            ['invoice_id' => $invoice->id],
            [
                'amount' => $invoice->amount,
                'payment_method' => $notif->payment_type,
                'status' => 'success', // Status internal aplikasi
                'midtrans_order_id' => $notif->order_id,
                'midtrans_transaction_id' => $notif->transaction_id,
                'raw_response' => json_encode($notif->getResponse()),
            ]
        );
    }
}
