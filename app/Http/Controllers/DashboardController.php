<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        // Ambil data formulir jika ada
        $formulir = $user->formulir;

        // Di sini kita akan menambahkan logika untuk status pembayaran nanti
        // Untuk sekarang, kita fokus pada status formulir dulu

        return view('dashboard', [
            'user' => $user,
            'formulir' => $formulir,
        ]);
    }
}