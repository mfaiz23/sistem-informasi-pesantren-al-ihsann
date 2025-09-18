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
                <span>Berita</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                    $beritaItems = [
                        [
                            'gambar' => 'berita1.png',
                            'judul' => 'Program Kerja Baru Pondok Pesantren Mulai Terealisasikan',
                            'tanggal' => '11 September 2025',
                            'ringkasan' => 'Pondok Pesantren Al-Ihsan resmi meluncurkan program kerja baru bertajuk One Day One Juz (ODOJ) sebagai...'
                        ],
                        [
                            'gambar' => 'berita2.png',
                            'judul' => 'Fakta/Mitos Membaca 15 Menit Sehari Merupakan Kunci Untuk Mencerdaskan Wawasan',
                            'tanggal' => '10 September 2025',
                            'ringkasan' => 'Belakangan ini, banyak kampanye literasi yang mendorong masyarakat untuk membiasakan membaca buku setiap hari...'
                        ],
                        [
                            'gambar' => 'berita3.png',
                            'judul' => 'Teknologi Semakin Canggih, Pondok Pesantren Al-Ihsan Menerapkan Penerimaan Santri Baru (PSB) Berbasis Web',
                            'tanggal' => '9 September 2025',
                            'ringkasan' => 'Dalam upaya meningkatkan pemerataan dan efisiensi administrasi, Pondok Pesantren Al-Ihsan resmi mengumumkan...'
                        ],
                        [
                            'gambar' => 'berita1.png',
                            'judul' => 'Program Kerja Baru Pondok Pesantren Mulai Terealisasikan',
                            'tanggal' => '8 September 2025',
                            'ringkasan' => 'Pondok Pesantren Al-Ihsan resmi meluncurkan program kerja baru bertajuk One Day One Juz (ODOJ) sebagai...'
                        ],
                        [
                            'gambar' => 'berita2.png',
                            'judul' => 'Fakta/Mitos Membaca 15 Menit Sehari Merupakan Kunci Untuk Mencerdaskan Wawasan',
                            'tanggal' => '7 September 2025',
                            'ringkasan' => 'Belakangan ini, banyak kampanye literasi yang mendorong masyarakat untuk membiasakan membaca buku setiap hari...'
                        ],
                        [
                            'gambar' => 'berita3.png',
                            'judul' => 'Teknologi Semakin Canggih, Pondok Pesantren Al-Ihsan Menerapkan Penerimaan Santri Baru (PSB) Berbasis Web',
                            'tanggal' => '6 September 2025',
                            'ringkasan' => 'Dalam upaya meningkatkan pemerataan dan efisiensi administrasi, Pondok Pesantren Al-Ihsan resmi mengumumkan...'
                        ],
                    ];
                @endphp

                @foreach ($beritaItems as $item)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col transition hover:shadow-xl">
                        <img src="{{ asset('assets/images/berita/' . $item['gambar']) }}" alt="{{ $item['judul'] }}"
                            class="w-full h-48 object-cover">
                        <div class="p-6 flex flex-col flex-grow">
                            <p class="text-xs text-gray-500 mb-2">{{ $item['tanggal'] }}</p>
                            <h3 class="text-md font-bold text-gray-800 mb-2 flex-grow">{{ $item['judul'] }}</h3>
                            <p class="text-sm text-gray-600 mb-4">{{ $item['ringkasan'] }}</p>
                            <a href="#"
                                class="mt-auto inline-flex items-center justify-center w-[125px] h-[30px] bg-[#028579] text-white font-semibold text-sm rounded-lg hover:bg-[#016a60] transition">
                                Selengkapnya
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12 flex justify-center items-center space-x-2">
                <a href="#" class="px-4 py-2 bg-[#028579] text-white rounded-md">1</a>
                <a href="#" class="px-4 py-2 text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-md">2</a>
                <span class="text-gray-500">...</span>
                <a href="#" class="px-4 py-2 text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-md">5</a>
            </div>

        </div>
    </section>
@endsection
