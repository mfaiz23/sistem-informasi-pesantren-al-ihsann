@extends('layouts.public')

@section('title', 'Informasi Fasilitas - PSB Al-Ihsan')

@section('content')
    <section class="bg-[#12BC9A]">
        <div class="container mx-auto px-6 py-10 text-white">
            <h1 class="text-3xl font-bold">Informasi Fasilitas</h1>
            <div class="text-sm mt-1">
                <a href="/" class="hover:underline opacity-80">Home</a>
                <span class="mx-2">></span>
                <span>Informasi Fasilitas</span>
            </div>
        </div>
    </section>

    <section class="container mx-auto px-6 py-12">
        <div class="w-full max-w-5xl mx-auto">
            <div class="text-center mb-8">
                <span>Informasi Fasilitas</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @php
                    $fasilitas = [
                        'Masjid Al-Mubarak' => 'masjid.png',
                        'Lapangan Upacara' => 'lapangan.png',
                        'Aula' => 'aula.png',
                        'Asrama' => 'asrama.png',
                        'Sarana Olahraga' => 'olahraga.png',
                        'Lahan Parkiran' => 'parkiran.png',
                    ];
                @endphp

                @foreach ($fasilitas as $nama => $gambar)
                    <div class="relative rounded-lg overflow-hidden shadow-lg group">
                        <img src="{{ asset('assets/images/fasilitas/' . $gambar) }}" alt="{{ $nama }}"
                            class="w-full h-64 object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-end p-4">
                            <h3 class="text-white text-xl font-bold">{{ $nama }}</h3>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
