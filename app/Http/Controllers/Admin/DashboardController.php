<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Faq;
use App\Models\FaqTopic;
use App\Models\Formulir;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Number;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $totalPengguna = User::count();

        $totalPendapatanValue = Invoice::where('status', 'paid')->sum('amount');
        $totalPendapatan = 'Rp '.Number::abbreviate($totalPendapatanValue, maxPrecision: 1);

        $penggunaTerbaru = User::latest()->take(5)->get();

        $aktivitasPendaftaran = Formulir::with('user')->latest()->take(5)->get()->map(function ($item) {
            return ['type' => 'user', 'title' => 'Pendaftar baru \''.($item->user->name ?? 'N/A').'\' mengisi formulir.', 'time' => $item->created_at];
        });

        $aktivitasPembayaran = Invoice::with('user')->where('status', 'paid')->latest('completed_at')->take(5)->get()->map(function ($item) {
            return ['type' => 'payment', 'title' => 'Pembayaran lunas dari \''.($item->user->name ?? 'N/A').'\'.', 'time' => $item->completed_at];
        });

        $aktivitasBerita = Berita::with('user')->latest('created_at')->take(5)->get()->map(function ($item) {
            return [
                'type' => 'berita_created',
                'title' => ($item->user->name ?? 'Admin')." membuat berita baru: '".Str::limit($item->judul, 25)."'",
                'time' => $item->created_at,
            ];
        });

        // DITAMBAHKAN: Mengambil 5 FAQ terbaru yang dibuat
        $aktivitasFaq = Faq::with('user')->latest('created_at')->take(5)->get()->map(function ($item) {
            return [
                'type' => 'faq_created',
                'title' => ($item->user->name ?? 'Admin')." membuat FAQ baru: '".Str::limit($item->pertanyaan, 25)."'",
                'time' => $item->created_at,
            ];
        });

        // DITAMBAHKAN: Mengambil 5 Topik FAQ terbaru yang dibuat
        $aktivitasFaqTopic = FaqTopic::latest('created_at')->take(5)->get()->map(function ($item) {
            return [
                'type' => 'topic_created',
                'title' => "Seorang admin membuat topik baru: '{$item->name}'",
                'time' => $item->created_at,
            ];
        });

        // Gabungkan SEMUA aktivitas, urutkan, dan ambil 5 yang paling baru
        $aktivitasTerbaru = collect($aktivitasPendaftaran)
            ->merge($aktivitasPembayaran)
            ->merge($aktivitasBerita)       // DITAMBAHKAN
            ->merge($aktivitasFaq)          // DITAMBAHKAN
            ->merge($aktivitasFaqTopic)     // DITAMBAHKAN
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
