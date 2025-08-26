<?php

namespace App\Http\Controllers;

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

        // Cari pembayaran yang sudah ada (baik 'berhasil' maupun 'pending')
        $payment = Payment::where('user_id', $user->id)
            ->where('jenis_pembayaran', 'formulir')
            ->first();

        // Jika sudah ada pembayaran yang berhasil, redirect
        if ($payment && $payment->status == 'berhasil') {
            return redirect()->route('dashboard')->with('info', 'Anda sudah membayar biaya formulir pendaftaran.');
        }

        // Jika BELUM ada pembayaran sama sekali, buat record baru
        if (! $payment) {
            $orderId = 'FORM-'.$user->id.'-'.time();
            $payment = Payment::create([
                'user_id' => $user->id,
                'jenis_pembayaran' => 'formulir',
                'jumlah' => 300000,
                'status' => 'pending',
                'midtrans_order_id' => $orderId,
            ]);
        }

        // Jika sudah ada pembayaran tapi statusnya BUKAN 'berhasil' (pending/gagal),
        // kita akan menggunakan record yang sama dan hanya meminta token baru.
        $orderId = $payment->midtrans_order_id;

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $payment->jumlah,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->no_telp,
            ],
            'item_details' => [
                [
                    'id' => 'FORMULIR_PSB',
                    'price' => $payment->jumlah,
                    'quantity' => 1,
                    'name' => 'Biaya Formulir Pendaftaran Santri Baru',
                ],
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            return view('payment.create', [
                'snapToken' => $snapToken,
                'payment' => $payment,
            ]);

        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Terjadi kesalahan saat membuat transaksi: '.$e->getMessage());
        }
    }

    public function notificationHandler(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');
        $notif = new Notification;

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $orderId = $notif->order_id;
        $fraud = $notif->fraud_status;

        $payment = Payment::where('midtrans_order_id', $orderId)->first();

        if (! $payment) {
            return response()->json(['message' => 'Payment not found.'], 404);
        }

        if ($transaction == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $payment->update(['status' => 'pending']);
                } else {
                    $payment->update(['status' => 'berhasil', 'paid_at' => now()]);
                }
            }
        } elseif ($transaction == 'settlement') {
            $payment->update(['status' => 'berhasil', 'paid_at' => now()]);
        } elseif ($transaction == 'pending') {
            $payment->update(['status' => 'pending']);
        } elseif ($transaction == 'deny') {
            $payment->update(['status' => 'gagal']);
        } elseif ($transaction == 'expire') {
            $payment->update(['status' => 'gagal']);
        } elseif ($transaction == 'cancel') {
            $payment->update(['status' => 'gagal']);
        }

        return response()->json(['message' => 'Notification handled.']);
    }
}
