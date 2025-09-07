<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Formulir;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Number;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1. MENGAMBIL TOTAL PENGGUNA
        $totalPengguna = User::count();

        // 2. MENGAMBIL TOTAL PENDAPATAN (dari invoice yang sudah lunas)
        $totalPendapatanValue = Invoice::where('status', 'paid')->sum('amount');
        // Format angka menjadi lebih ringkas (misal: 15700000 -> "Rp 15.7 Jt")
        $totalPendapatan = 'Rp '.Number::abbreviate($totalPendapatanValue, maxPrecision: 1);

        // 3. MENGAMBIL 5 PENGGUNA TERBARU
        $penggunaTerbaru = User::latest()->take(5)->get();

        // 4. MENGAMBIL AKTIVITAS TERBARU (gabungan dari beberapa model)
        // Ambil 5 pendaftaran formulir terbaru
        $aktivitasPendaftaran = Formulir::with('user')->latest()->take(5)->get()->map(function ($item) {
            return [
                'type' => 'user',
                'title' => 'Pendaftar baru \''.($item->user->name ?? 'N/A').'\' mengisi formulir.',
                'time' => $item->created_at,
            ];
        });

        // Ambil 5 pembayaran terbaru yang berhasil
        $aktivitasPembayaran = Invoice::with('user')->where('status', 'paid')->latest('completed_at')->take(5)->get()->map(function ($item) {
            return [
                'type' => 'payment',
                'title' => 'Pembayaran lunas dari \''.($item->user->name ?? 'N/A').'\'.',
                'time' => $item->completed_at,
            ];
        });

        // Gabungkan semua aktivitas, urutkan berdasarkan waktu, dan ambil 5 teratas
        $aktivitasTerbaru = collect($aktivitasPendaftaran)
            ->merge($aktivitasPembayaran)
            ->sortByDesc('time')
            ->take(5);

        // Kirim semua data ke view
        return view('admin.dashboard', compact(
            'totalPengguna',
            'totalPendapatan',
            'penggunaTerbaru',
            'aktivitasTerbaru'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
