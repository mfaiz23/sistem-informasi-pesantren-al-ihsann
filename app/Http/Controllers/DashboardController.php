<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $formulir = $user->formulir;

        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = (bool) config('services.midtrans.is_production', false);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $pendings = $user->invoices()
            ->where('type', 'formulir')
            ->where('status', 'pending')
            ->orderByDesc('id')
            ->get();

        foreach ($pendings as $inv) {
            try {
                $resp = \Midtrans\Transaction::status($inv->invoice_number);
                $ts = $resp->transaction_status ?? null;
                $type = $resp->payment_type ?? null;
                $fraud = $resp->fraud_status ?? null;

                if ($ts === 'settlement' || ($ts === 'capture' && $type === 'credit_card' && $fraud === 'accept')) {
                    \DB::transaction(function () use ($inv, $resp) {
                        \App\Models\Payment::updateOrCreate(
                            ['invoice_id' => $inv->id],
                            [
                                'amount' => $inv->amount,
                                'status' => 'success',
                                'payment_method' => $resp->payment_type ?? null,
                                'midtrans_order_id' => $inv->invoice_number,
                                'midtrans_transaction_id' => (string) ($resp->transaction_id ?? \Illuminate\Support\Str::uuid()),
                                'raw_response' => json_encode($resp),
                            ]
                        );

                        $inv->update(['status' => 'paid', 'completed_at' => now()]);
                    });

                    \App\Models\Invoice::where('user_id', $user->id)
                        ->where('type', 'formulir')
                        ->where('status', 'pending')
                        ->where('id', '!=', $inv->id)
                        ->update(['status' => 'failed']);

                } elseif (in_array($ts, ['expire', 'cancel', 'deny'])) {
                    $inv->update(['status' => 'failed']);
                }
            } catch (\Throwable $e) {
                \Log::warning('Midtrans polling gagal', [
                    'invoice_id' => $inv->id,
                    'order_id' => $inv->invoice_number,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $invoice = $user->invoices()
            ->where('type', 'formulir')
            ->with('payment')
            ->orderByRaw("CASE WHEN status = 'paid' THEN 0 ELSE 1 END")
            ->orderByDesc('id')
            ->first();

        $payment = $invoice ? $invoice->payment : null;

        return view('dashboard', [
            'user' => $user,
            'formulir' => $formulir,
            'payment' => $payment,
            'invoice' => $invoice,
        ]);
    }
}
