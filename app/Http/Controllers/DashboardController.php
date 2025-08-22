<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        // Ambil data formulir jika ada
        $formulir = $user->formulir;

        // Ambil data pembayaran formulir terakhir
        $payment = Payment::where('user_id', $user->id)
            ->where('jenis_pembayaran', 'formulir')
            ->latest()
            ->first();

        return view('dashboard', [
            'user' => $user,
            'formulir' => $formulir,
            'payment' => $payment,
        ]);
    }
}
