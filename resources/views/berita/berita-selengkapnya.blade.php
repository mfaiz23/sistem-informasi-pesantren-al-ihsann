@extends('layouts.public')

{{-- Judul halaman akan dinamis sesuai judul berita --}}
@section('title', $berita->judul . ' - PSB Al-Ihsan')

@section('content')
    <section class="bg-[#12BC9A]">
        <div class="container mx-auto px-6 py-10 text-white">
            <h1 class="text-3xl font-bold">Berita</h1>
            <div class="text-sm mt-1">
                <a href="/" class="hover:underline opacity-80">Home</a>
                <span class="mx-2">></span>
                <a href="{{ route('berita.index') }}" class="hover:underline opacity-80">Berita</a>
                <span class="mx-2">></span>
                <span class="truncate">{{ Str::limit($berita->judul, 30) }}</span>
            </div>
        </div>
    </section>

    <section class="container mx-auto px-6 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">

            {{-- Kolom Utama: Isi Berita --}}
            <div class="lg:col-span-2">
                <article class="prose max-w-none">
                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($berita->published_at)->isoFormat('dddd, D MMMM YYYY') }}</p>
                    <h1 class="text-3xl font-extrabold text-gray-900 mt-2 mb-4">{{ $berita->judul }}</h1>
                    <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="w-full rounded-lg shadow-lg mb-6">

                    {{-- Tampilkan isi berita dengan format HTML --}}
                    <div>
                        {!! $berita->isi !!}
                    </div>
                </article>
            </div>

           {{-- Kolom Samping: Berita Lainnya --}}
            <aside>
                {{-- Wrapper untuk seluruh komponen sidebar --}}
                <div class="sticky top-24 bg-white rounded-xl shadow-lg border border-gray-200">

                    {{-- Header Sidebar --}}
                    <div class="bg-[#12BC9A] text-white p-4 rounded-t-xl flex items-center">
                        <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3h2m0 0h2m-2 0V3m0 2v2m0 0h2"></path></svg>
                        <h3 class="text-xl font-bold">Berita Lainnya</h3>
                    </div>

                    {{-- Kontainer untuk daftar berita --}}
                    <div class="p-4 lg:p-6 space-y-6">
                        @forelse($beritaLainnya as $item)
                            {{-- Awal Kartu Berita Individual --}}
                            <div class="flex space-x-4">
                                {{-- Gambar di Kiri --}}
                                <div class="flex-shrink-0">
                                    <a href="{{ route('berita.show', $item->id) }}">
                                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="w-28 h-full sm:w-32 object-cover rounded-lg">
                                    </a>
                                </div>

                                {{-- Konten Teks di Kanan --}}
                                <div class="flex-1 flex flex-col min-w-0">
                                    {{-- Tanggal --}}
                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->published_at)->isoFormat('D MMMM YYYY') }}</p>

                                    {{-- Judul --}}
                                    <a href="{{ route('berita.show', $item->id) }}" class="group">
                                        <h4 class="text-base font-bold text-gray-900 mt-1 group-hover:text-[#028579] transition-colors truncate">
                                            {{ $item->judul }}
                                        </h4>
                                    </a>

                                    {{-- Pratinjau Teks --}}
                                    <p class="text-sm text-gray-600 mt-2 hidden sm:block">
                                        {{ Str::limit(strip_tags($item->isi), 90) }}
                                    </p>

                                    {{-- Tombol "Selengkapnya", didorong ke bawah --}}
                                    <div class="mt-auto pt-2 text-left">
                                        <a href="{{ route('berita.show', $item->id) }}" class="inline-block bg-[#12BC9A] text-white text-xs font-semibold px-4 py-1.5 rounded-full hover:bg-[#028579] transition-colors">
                                            Selengkapnya
                                        </a>
                                    </div>
                                </div>
                            </div>
                            {{-- Akhir Kartu Berita Individual --}}
                        @empty
                            <p class="text-sm text-gray-500 text-center py-4">Tidak ada berita lainnya.</p>
                        @endforelse
                    </div>
                </div>
            </aside>

        </div>
    </section>
@endsection
