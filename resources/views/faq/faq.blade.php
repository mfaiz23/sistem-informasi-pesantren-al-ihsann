@extends('layouts.public')

@section('title', 'FAQ - PSB Al-Ihsan')

@section('content')
    {{-- Bagian Header Halaman --}}
    <section class="bg-[#12BC9A]">
        <div class="container mx-auto px-6 py-10 text-white">
            <h1 class="text-3xl font-bold">FAQ</h1>
            <div class="text-sm mt-1">
                <a href="/" class="hover:underline opacity-80">Home</a>
                <span class="mx-2">></span>
                <span>FAQ</span>
            </div>
        </div>
    </section>

    {{-- Bagian Konten Utama --}}
    <section class="container mx-auto px-6 py-12">
        <div class="w-full max-w-5xl mx-auto">
            <div class="text-center mb-6">
                <span class="text-sm font-semibold text-gray-500 uppercase">FAQ</span>
                <h2 class="text-3xl font-bold text-gray-800 mt-1">Frequently Asked Questions</h2>
            </div>

            {{-- Form Pencarian (Sudah Fungsional) --}}
            <form action="{{ route('faq') }}" method="GET" class="mb-12">
                <div class="relative">
                    <input type="text" name="search" value="{{ $searchTerm ?? '' }}" placeholder="Cari pertanyaan atau topik..."
                        class="w-full py-3 pl-4 pr-12 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#028579]">
                    <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-4" aria-label="Cari">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </form>

            {{-- Grid untuk Topik FAQ --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($topics as $topic)
                    {{-- Hanya tampilkan topik yang memiliki pertanyaan --}}
                    @if($topic->faqs_count > 0)
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 flex flex-col">
                            <h3 class="text-lg font-bold text-gray-900">{{ $topic->name }}</h3>

                            {{-- PERBAIKAN: Menampilkan jumlah pertanyaan dari faqs_count --}}
                            <p class="text-sm text-[#028579] font-semibold mt-1">{{ $topic->faqs_count }} Pertanyaan</p>

                            @if($topic->faqs->first())
                                <p class="text-sm text-gray-600 mt-4 flex-grow">
                                    "{{ Str::limit($topic->faqs->first()->pertanyaan, 70) }}"
                                </p>
                            @endif

                            <a href="{{ route('faq.topic.show', $topic->slug) }}"
                                class="inline-block mt-6 bg-[#028579] text-white font-semibold text-center py-2 px-4 rounded-lg hover:bg-[#016a60] transition duration-300">
                                Selengkapnya
                            </a>
                        </div>
                    @endif
                @empty
                    <div class="md:col-span-3 text-center py-12">
                        <p class="text-gray-500">
                            @if($searchTerm)
                                Tidak ada pertanyaan yang cocok dengan pencarian "{{ $searchTerm }}".
                            @else
                                Belum ada pertanyaan yang tersedia.
                            @endif
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
