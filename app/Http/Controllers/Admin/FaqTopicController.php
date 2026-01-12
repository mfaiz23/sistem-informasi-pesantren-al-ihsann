<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqTopic;
use Illuminate\Http\Request;

class FaqTopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Mulai query dengan withCount untuk bisa mengurutkan berdasarkan jumlah pertanyaan
        $query = FaqTopic::withCount('faqs');

        // 1. Terapkan filter PENCARIAN jika ada input 'search'
        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        // 2. Terapkan PENGURUTAN berdasarkan input 'sort', defaultnya 'date_desc'
        switch ($request->input('sort', 'date_desc')) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'faqs_count_desc':
                $query->orderBy('faqs_count', 'desc');
                break;
            case 'faqs_count_asc':
                $query->orderBy('faqs_count', 'asc');
                break;
            case 'date_asc':
                $query->orderBy('created_at', 'asc');
                break;
            default: // case 'date_desc'
                $query->orderBy('created_at', 'desc');
                break;
        }

        $topics = $query->paginate(10)->appends($request->query());

        return view('admin.faq-topics', compact('topics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('components.admin.faq.topics.create-topics-modal');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100|unique:faq_topics']);
        FaqTopic::create($request->only('name'));

        return redirect()->route('admin.faq-topics.index')->with('success', 'Topik berhasil ditambahkan.');
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
    public function edit(FaqTopic $faqTopic)
    {
        // return view('comnponents.admin.faq.topics.edit-topics-modal', compact('faqTopic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FaqTopic $faqTopic)
    {
        $request->validate(['name' => 'required|string|max:100|unique:faq_topics,name,'.$faqTopic->id]);
        $faqTopic->update($request->only('name'));

        return redirect()->route('admin.faq-topics.index')->with('success', 'Topik berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FaqTopic $faqTopic)
    {
        $faqTopic->delete();

        return redirect()->route('admin.faq-topics.index')->with('success', 'Topik berhasil dihapus.');
    }
}
