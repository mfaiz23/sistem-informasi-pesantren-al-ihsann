@extends('layouts.public')

@section('title', 'Berita - PSB Al-Ihsan')

@section('content')
    <section class="bg-[#12BC9A]">
        <div class="container mx-auto px-6 py-10 text-white">
            <h1 class="text-3xl font-bold">Berita</h1>
            <div class="text-sm mt-1">
                <a href="/" class="hover:underline opacity-80">Home</a>
                <span class="mx-2">></span>
                <span>Berita</span>
            </div>
        </div>
    </section>

    <section class="container mx-auto px-6 py-12">
        <div class="w-full max-w-5xl mx-auto">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800">Berita & Informasi Terbaru</h2>
                <p class="text-gray-500">Ikuti perkembangan dan kegiatan terbaru dari Pondok Pesantren Al-Ihsan.</p>
            </div>

            @if($beritas->isEmpty())
                <p class="text-center text-gray-500">Belum ada berita yang dipublikasikan.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($beritas as $item)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col transition hover:shadow-xl">
                            <a href="{{ route('berita.show', $item->id) }}">
                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-48 object-cover">
                            </a>
                            <div class="p-6 flex flex-col flex-grow">
                                <p class="text-xs text-gray-500 mb-2">{{ \Carbon\Carbon::parse($item->published_at)->isoFormat('D MMMM YYYY') }}</p>
                                <h3 class="text-md font-bold text-gray-800 mb-2 flex-grow">
                                    <a href="{{ route('berita.show', $item->id) }}" class="hover:text-[#028579]">{{ $item->judul }}</a>
                                </h3>
                                <p class="text-sm text-gray-600 mb-4">{{ Str::limit(strip_tags($item->isi), 100) }}</p>
                                <a href="{{ route('berita.show', $item->id) }}" class="mt-auto inline-flex items-center justify-center w-[125px] h-[30px] bg-[#028579] text-white font-semibold text-sm rounded-lg hover:bg-[#016a60] transition">
                                    Selengkapnya
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Paginasi --}}
                <div class="mt-12">
                    {{ $beritas->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
