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
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h5 class="font-semibold text-gray-800 mb-3 text-sm">Ada pertanyaan lainnya?</h5>
                        <a href="https://wa.me/6281904364257"
                           target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center justify-center w-full md:w-auto px-4 py-2.5 bg-[#25D366] hover:bg-[#1EBE5A] text-white font-bold rounded-lg transition-colors duration-200 shadow-sm">

                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007-.133 0-.35.05-.53.247-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.05-.087-.182-.133-.38-.232z"/>
                            </svg>
                            <span>Kontak kami</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
