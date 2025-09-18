@extends('layouts.public')

@section('title', $topic->name . ' - FAQ')

@section('content')
    {{-- Bagian Header Halaman --}}
    <section class="bg-[#12BC9A]">
        <div class="container mx-auto px-6 py-10 text-white">
            <h1 class="text-3xl font-bold">FAQ</h1>
            <div class="text-sm mt-1">
                <a href="{{ route('faq') }}" class="hover:underline opacity-80">FAQ</a>
                <span class="mx-2">></span>
                <span>{{ $topic->name }}</span>
            </div>
        </div>
    </section>

    {{-- Bagian Konten Utama --}}
    <section class="container mx-auto px-6 py-12">
        <div class="w-full max-w-5xl mx-auto">
            <div class="text-center mb-6">
                <span class="text-sm font-semibold text-gray-500 uppercase">FAQ</span>
                <h2 class="text-3xl font-bold text-gray-800 mt-1">Pertanyaan yang sering diajukan</h2>
            </div>

            {{-- 1. Form Pencarian (Sudah Fungsional) --}}
            <form action="{{ route('faq.topic.show', $topic->slug) }}" method="GET" class="mb-12">
                <div class="relative">
                    <input type="text" name="search" value="{{ $searchTerm ?? '' }}" placeholder="Cari pertanyaan di topik ini..."
                        class="w-full py-3 pl-4 pr-12 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#028579]">
                    <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-4" aria-label="Cari">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </form>

            {{-- Layout Utama: Daftar Pertanyaan & Sidebar --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Kolom Kiri: Daftar Pertanyaan --}}
                {{-- 2. Tambahkan x-data untuk state accordion --}}
                <div class="md:col-span-2 space-y-4" x-data="{ openAccordion: null }">
                    <div class="bg-green-100 p-4 rounded-lg">
                        <h3 class="font-bold text-lg text-gray-800">{{ $topic->name }}</h3>
                    </div>

                    {{-- 3. Loop menggunakan $faqs yang sudah difilter --}}
                    @forelse ($faqs as $index => $faq)
                        <div class="border-b border-gray-200">
                            <h2>
                                <button type="button"
                                    class="flex items-center justify-between w-full p-6 font-medium text-left text-gray-900 focus:outline-none"
                                    @click="openAccordion = openAccordion === {{ $index + 1 }} ? null : {{ $index + 1 }}">
                                    <span class="text-md">{{ $faq->pertanyaan }}</span>
                                    {{-- 4. Ganti ikon plus/minus dengan ikon panah --}}
                                    <svg class="w-5 h-5 transform transition-transform duration-300"
                                        :class="{ 'rotate-180': openAccordion === {{ $index + 1 }} }"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </h2>
                            {{-- 5. Tambahkan x-collapse untuk animasi smooth --}}
                            <div x-show="openAccordion === {{ $index + 1 }}" x-collapse>
                                <div class="px-6 pb-6 text-gray-700 text-sm leading-relaxed">
                                    {!! $faq->jawaban !!}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 px-6 bg-gray-50 rounded-lg">
                            <p class="text-gray-500">
                                @if($searchTerm)
                                    Tidak ada pertanyaan yang cocok dengan pencarian "{{ $searchTerm }}".
                                @else
                                    Belum ada pertanyaan untuk topik ini.
                                @endif
                            </p>
                        </div>
                    @endforelse
                </div>

                {{-- Kolom Kanan: Sidebar FAQ Lainnya --}}
                <div class="md:col-span-1">
                    <h4 class="font-bold text-lg mb-4">FAQ Lainnya</h4>
                    <div class="space-y-3">
                        @foreach ($otherTopics as $other)
                            <a href="{{ route('faq.topic.show', $other->slug) }}" class="block p-4 border rounded-lg hover:bg-gray-100 transition">
                                {{ $other->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
