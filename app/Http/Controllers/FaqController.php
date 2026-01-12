<?php

namespace App\Http\Controllers;

use App\Models\FaqTopic;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(Request $request): View
    {

        $query = FaqTopic::query();

        $query->when($request->filled('search'), function ($q) use ($request) {
            $searchTerm = '%'.$request->search.'%';
            $q->where(function ($subQuery) use ($searchTerm) {
                $subQuery->where('name', 'like', $searchTerm)
                    ->orWhereHas('faqs', function ($faqQuery) use ($searchTerm) {
                        $faqQuery->where('pertanyaan', 'like', $searchTerm);
                    });
            });
        });

        $topics = $query->with('faqs')->withCount('faqs')->get();

        return view('faq.faq', [
            'topics' => $topics,
            'searchTerm' => $request->search,
        ]);
    }

    public function show(Request $request, FaqTopic $topic): View
    {
        $searchTerm = $request->input('search');

        $faqsQuery = $topic->faqs();

        $faqsQuery->when($searchTerm, function ($query) use ($searchTerm) {
            $search = '%'.$searchTerm.'%';
            $query->where('pertanyaan', 'like', $search)
                ->orWhere('jawaban', 'like', $search);
        });

        $faqs = $faqsQuery->get();

        $otherTopics = FaqTopic::where('id', '!=', $topic->id)->has('faqs')->get();

        return view('faq.detail-topics', [
            'topic' => $topic,
            'faqs' => $faqs,
            'otherTopics' => $otherTopics,
            'searchTerm' => $searchTerm,
        ]);
    }
}
