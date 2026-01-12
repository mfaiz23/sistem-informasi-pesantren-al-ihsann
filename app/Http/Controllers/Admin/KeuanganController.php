<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Memulai query builder untuk Invoice
        $query = Invoice::query();

        // Mengambil data user terkait secara efisien untuk menghindari N+1 problem.
        // Ini penting agar performa tetap cepat saat data semakin banyak.
        $query->with('user', 'payment');

        // --- LOGIKA PENCARIAN ---
        // Jika ada input 'search', filter berdasarkan nomor invoice atau nama user.
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('invoice_number', 'like', '%'.$searchTerm.'%') // <-- Baris ini sudah benar
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('name', 'like', '%'.$searchTerm.'%');
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // --- LOGIKA FILTER PERIODE ---
        // Contoh sederhana untuk filter periode, bisa dikembangkan lebih lanjut.
        if ($request->filled('periode')) {
            $periode = $request->input('periode');
            // Hanya filter invoice yang sudah lunas (memiliki tanggal completed_at)
            $query->whereNotNull('completed_at');

            if ($periode == 'today') {
                $query->whereDate('completed_at', now());
            } elseif ($periode == 'week') {
                $query->whereBetween('completed_at', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($periode == 'month') {
                $query->whereMonth('completed_at', now()->month)
                    ->whereYear('completed_at', now()->year);
            }
        }

        // Mengurutkan data berdasarkan yang terbaru dan melakukan paginasi.
        // Paginasi penting untuk menangani data dalam jumlah besar.
        $invoices = $query->latest()->paginate(10);

        // Mengirim data invoices yang sudah difilter dan dipaginasi ke view.
        return view('admin.keuangan', [
            'invoices' => $invoices,
        ]);
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

    public function cetakPdf(Request $request)
    {
        // 1. DUPLIKAT LOGIKA QUERY DARI METHOD INDEX
        $query = Invoice::query()->with('user');

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('invoice_number', 'like', '%'.$searchTerm.'%')
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('name', 'like', '%'.$searchTerm.'%');
                    });
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->filled('periode')) {
            $periode = $request->input('periode');
            $query->whereNotNull('completed_at');
            if ($periode == 'today') {
                $query->whereDate('completed_at', now());
            } elseif ($periode == 'week') {
                $query->whereBetween('completed_at', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($periode == 'month') {
                $query->whereMonth('completed_at', now()->month)
                    ->whereYear('completed_at', now()->year);
            }
        }

        // 2. AMBIL SEMUA DATA (BUKAN PAGINASI)
        $invoices = $query->latest()->get();

        // 3. SIAPKAN DATA TAMBAHAN UNTUK VIEW PDF
        $tanggalCetak = now()->format('d F Y');

        // 4. LOAD VIEW PDF DAN PASSING DATA
        $pdf = PDF::loadView('components.admin.keuangan.laporan_pdf', compact('invoices', 'tanggalCetak'));

        // 5. STREAM PDF KE BROWSER
        return $pdf->stream('laporan-keuangan-'.now()->format('Y-m-d').'.pdf');
    }
}
