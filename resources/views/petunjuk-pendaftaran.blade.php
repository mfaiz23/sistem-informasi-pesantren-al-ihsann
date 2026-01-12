@extends('layouts.public')

@section('title', 'Petunjuk Pendaftaran - PSB Al-Ihsan')

@section('content')
    <section class="bg-[#12BC9A]">
        <div class="container mx-auto px-6 py-10 text-white">
            <h1 class="text-3xl font-bold">Petunjuk Pendaftaran</h1>
            <div class="text-sm mt-1">
                <a href="/" class="hover:underline opacity-80">Home</a>
                <span class="mx-2">></span>
                <span>Petunjuk Pendaftaran</span>
            </div>
        </div>
    </section>

    <section class="container mx-auto px-6 py-12">
        <div x-data="{ tab: 'reguler' }" class="w-full max-w-4xl mx-auto">
            <div class="border-b border-gray-200">
                <nav class="flex justify-center -mb-px space-x-1">
                    <button @click="tab = 'reguler'"
                        :class="{'border-[#028579] text-[#028579]': tab === 'reguler', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'reguler'}"
                        class="whitespace-nowrap py-4 px-8 border-b-2 font-medium text-sm focus:outline-none">
                        Santri Reguler
                    </button>
                    <button @click="tab = 'non-reguler'"
                        :class="{'border-[#028579] text-[#028579]': tab === 'non-reguler', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'non-reguler'}"
                        class="whitespace-nowrap py-4 px-8 border-b-2 font-medium text-sm focus:outline-none">
                        Santri Non Reguler
                    </button>
                </nav>
            </div>

            <div class="mt-8 mb-6">
                <p class="text-gray-600">Petunjuk pendaftaran:</p>
            </div>

            <div class="mt-8">
                <div x-show="tab === 'reguler'" class="relative">
                    <div class="absolute left-6 top-0 h-full w-0.5 bg-gray-200" style="z-index: -1;"></div>
                    @php
                        $tahapanReguler = [
                            1 => ['title' => 'Cari Informasi Pendaftaran Penerimaan Santri Baru Pesantren Al-Ihsan', 'items' => ['Masuk ke website resmi Penerimaan Santri Baru (PSB) Pesantren Al-Ihsan', 'Klik "Daftar Sekarang" atau klik tombol dibawah ini.'], 'button' => ['text' => 'DAFTAR SEKARANG', 'route' => 'register']],
                            2 => ['title' => 'Membuat Akun Pendaftaran Santri Baru (PSB)', 'items' => ['Buat akun pendaftaran', 'Isi data pendaftaran akun', 'Verifikasi akun melalui email aktif', 'Login menggunakan akun yang sudah didaftarkan'], 'button' => ['text' => 'REGISTRASI AKUN', 'route' => 'register']],
                            3 => ['title' => 'Lakukan Pembayaran Formulir Pendaftaran', 'items' => ['Klik "isi formulir pendaftaran"', 'Pahami dan setujui syarat dan ketentuan yang berlaku di Pesantren Al-Ihsan', 'Lakukan pembayaran formulir pendaftaran sebesar Rp 300.000,-', 'Pilih metode pembayaran']],
                            4 => ['title' => 'Lengkapi Data Formulir Pendaftaran', 'items' => ['Lengkapi data pribadi', 'Lengkapi data asal sekolah', 'Lengkapi data alamat', 'Lengkapi data orang tua/wali']],
                            5 => ['title' => 'Menunggu Verifikasi Dokumen Selesai', 'items' => ['Cek status pembayaran formulir pendaftaran pada dashboard', 'Cek status verifikasi formulir pada dashboard']],
                            6 => ['title' => 'Formulir Pendaftaran Terverifikasi', 'items' => ['Cek status verifikasi formulir pada dashboard', 'Hubungi admin Pesantren Al-Ihsan untuk pembayaran selanjutnya (uang pangkal, infak per semester, uang makan (putri)']]
                        ];
                    @endphp
                    <div class="space-y-8">
                        @foreach ($tahapanReguler as $no => $tahap)
                            <div class="flex items-start">
                                <div
                                    class="flex-shrink-0 w-12 h-12 flex items-center justify-center bg-[#028579] rounded-full text-white font-bold text-xl z-10">
                                    ✓</div>
                                <div class="ml-6 flex-1">
                                    <div class="bg-gray-100 p-6 rounded-lg border border-gray-200">
                                        <p class="text-sm text-gray-500">Tahap {{ $no }}:</p>
                                        <h3 class="text-lg font-semibold text-gray-800">{{ $tahap['title'] }}</h3>
                                        <ul class="list-disc list-inside mt-2 text-gray-600 space-y-1 pl-2">
                                            @foreach ($tahap['items'] as $item)
                                                <li>{{ $item }}</li>
                                            @endforeach
                                        </ul>
                                        @if (isset($tahap['button']))
                                            <div class="mt-4">
                                                <a href="{{ route($tahap['button']['route']) }}"
                                                    class="inline-block bg-[#028579] text-white font-semibold py-2 px-4 rounded-md hover:bg-[#016a60] transition">
                                                    {{ $tahap['button']['text'] }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div x-show="tab === 'non-reguler'" class="relative" style="display: none;">
                    <div class="absolute left-6 top-0 h-full w-0.5 bg-gray-200" style="z-index: -1;"></div>
                    @php
                        $tahapanNonReguler = $tahapanReguler;
                        // Hapus tahap 5 dan 6 yang lama
                        unset($tahapanNonReguler[5]);
                        unset($tahapanNonReguler[6]);
                        // Tambahkan tahap baru
                        $tahapanNonReguler[5] = ['title' => 'Unggah Dokumen Beasiswa KIP', 'items' => ['Masukkan no kartu indonesia pintar (KIP) pada kategori pendaftaran', 'Unggah dokumen asli Kartu Indonesia Pintar (KIP) berupa JPG, JPEG atau PDF']];
                        $tahapanNonReguler[6] = ['title' => 'Menunggu Verifikasi Dokumen Selesai', 'items' => ['Cek status pembayaran formulir pendaftaran pada dashboard', 'Cek status verifikasi formulir pada dashboard']];
                        $tahapanNonReguler[7] = ['title' => 'Formulir Pendaftaran Terverifikasi', 'items' => ['Cek status verifikasi formulir pada dashboard', 'Hubungi admin Pesantren Al-Ihsan untuk pembayaran selanjutnya (uang pangkal, infak per semester, uang makan (putri)']];
                    @endphp
                    <div class="space-y-8">
                        @foreach ($tahapanNonReguler as $no => $tahap)
                            <div class="flex items-start">
                                <div
                                    class="flex-shrink-0 w-12 h-12 flex items-center justify-center bg-[#028579] rounded-full text-white font-bold text-xl z-10">
                                    ✓</div>
                                <div class="ml-6 flex-1">
                                    <div class="bg-gray-100 p-6 rounded-lg border border-gray-200">
                                        <p class="text-sm text-gray-500">Tahap {{ $no }}:</p>
                                        <h3 class="text-lg font-semibold text-gray-800">{{ $tahap['title'] }}</h3>
                                        <ul class="list-disc list-inside mt-2 text-gray-600 space-y-1 pl-2">
                                            @foreach ($tahap['items'] as $item)
                                                <li>{{ $item }}</li>
                                            @endforeach
                                        </ul>
                                        @if (isset($tahap['button']))
                                            <div class="mt-4">
                                                <a href="{{ route($tahap['button']['route']) }}"
                                                    class="inline-block bg-[#028579] text-white font-semibold py-2 px-4 rounded-md hover:bg-[#016a60] transition">
                                                    {{ $tahap['button']['text'] }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
