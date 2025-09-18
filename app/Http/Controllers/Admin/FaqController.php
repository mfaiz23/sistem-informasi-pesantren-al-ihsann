<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Mulai query builder untuk Faq dengan relasi topic
        $query = Faq::with('topic');

        // 1. Terapkan Filter Pencarian (Search)
        if ($request->has('search') && $request->search != '') {
            $searchTerm = '%'.$request->search.'%';
            // Cari di kolom pertanyaan ATAU jawaban
            $query->where(function ($q) use ($searchTerm) {
                $q->where('pertanyaan', 'like', $searchTerm)
                    ->orWhere('jawaban', 'like', $searchTerm);
            });
        }

        // 2. Terapkan Filter Topik
        if ($request->has('topic') && $request->topic != '') {
            $query->where('faq_topic_id', $request->topic);
        }

        // 3. Terapkan Pengurutan (Sort)
        $sort = $request->get('sort', 'date_desc'); // Default: terbaru
        switch ($sort) {
            case 'date_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'question_asc':
                $query->orderBy('pertanyaan', 'asc');
                break;
            case 'question_desc':
                $query->orderBy('pertanyaan', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc'); // date_desc
                break;
        }

        // Eksekusi query dengan paginasi
        // withQueryString() penting agar parameter filter tetap ada saat pindah halaman
        $faqs = $query->paginate(10)->withQueryString();

        // Ambil semua topik untuk dropdown filter
        $topics = FaqTopic::all();

        // Kirim data ke view
        return view('admin.faq', compact('faqs', 'topics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil semua topik untuk ditampilkan di form dropdown
        $topics = FaqTopic::all();

        return view('admin.faq.create', compact('topics'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'jawaban' => 'required|string',
            'faq_topic_id' => 'required|exists:faq_topics,id',
        ]);

        // Simpan data baru
        Faq::create([
            'pertanyaan' => $request->pertanyaan,
            'jawaban' => $request->jawaban,
            'faq_topic_id' => $request->faq_topic_id,
            'users_id' => Auth::id(), // Ambil ID admin yang sedang login
        ]);

        return redirect()->route('admin.faq.index')
            ->with('success', 'FAQ berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        // Redirect ke halaman edit saja
        return redirect()->route('admin.faq.edit', $faq);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        $topics = FaqTopic::all();

        return view('admin.faq.edit', compact('faq', 'topics'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faq $faq)
    {
        // Validasi input
        $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'jawaban' => 'required|string',
            'faq_topic_id' => 'required|exists:faq_topics,id',
        ]);

        // Update data FAQ
        $faq->update([
            'pertanyaan' => $request->pertanyaan,
            'jawaban' => $request->jawaban,
            'faq_topic_id' => $request->faq_topic_id,
        ]);

        return redirect()->route('admin.faq.index')
            ->with('success', 'FAQ berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('admin.faq.index')
            ->with('success', 'FAQ berhasil dihapus.');
    }
}
