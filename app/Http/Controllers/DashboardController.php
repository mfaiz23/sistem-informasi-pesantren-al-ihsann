<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $formulir = $user->formulir;

        // Ambil invoice untuk formulir pendaftaran
        $invoice = $user->invoices()
            ->where('type', 'formulir')
            ->with('payment')
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
