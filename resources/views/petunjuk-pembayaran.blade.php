@extends('layouts.public')

@section('title', 'Petunjuk Pembayaran - PSB Al-Ihsan')

@section('content')
    <section class="bg-[#12BC9A]">
        <div class="container mx-auto px-6 py-10 text-white">
            <h1 class="text-3xl font-bold">Petunjuk Pembayaran</h1>
            <div class="text-sm mt-1">
                <a href="/" class="hover:underline opacity-80">Home</a>
                <span class="mx-2">></span>
                <span>Petunjuk Pembayaran</span>
            </div>
        </div>
    </section>

    <section class="container mx-auto px-6 py-12">
        <div x-data="{ tab: 'formulir' }" class="w-full max-w-4xl mx-auto">
            <div class="border-b border-gray-200">
                <nav class="flex justify-center -mb-px space-x-1">
                    <button @click="tab = 'formulir'"
                        :class="{'border-[#028579] text-[#028579]': tab === 'formulir', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'formulir'}"
                        class="whitespace-nowrap py-4 px-8 border-b-2 font-medium text-sm focus:outline-none">
                        Pembayaran Formulir Pendaftaran
                    </button>
                    <button @click="tab = 'uang-pangkal'"
                        :class="{'border-[#028579] text-[#028579]': tab === 'uang-pangkal', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'uang-pangkal'}"
                        class="whitespace-nowrap py-4 px-8 border-b-2 font-medium text-sm focus:outline-none">
                        Pembayaran Uang Pangkal
                    </button>
                </nav>
            </div>

            <div class="mt-8 mb-6">
                <p class="text-gray-600">Petunjuk pembayaran:</p>
            </div>

            <div class="mt-8">
                <div x-show="tab === 'formulir'" class="relative">
                    <div class="absolute left-6 top-0 h-full w-0.5 bg-gray-200" style="z-index: -1;"></div>
                    @php
                        $tahapanFormulir = [
                            1 => ['title' => 'Akses Website Resmi Penerimaan Santri Baru (PSB) Pesantren Al-Ihsan', 'items' => ['Masuk ke website resmi Penerimaan Santri Baru (PSB) Pesantren Al-Ihsan', 'Klik "Daftar Sekarang" atau klik tombol dibawah ini:'], 'button' => ['text' => 'DAFTAR SEKARANG', 'route' => 'register']],
                            2 => ['title' => 'Membuat Akun Pendaftaran Santri Baru (PSB)', 'items' => ['Buat akun pendaftaran', 'Isi data pendaftaran akun', 'Verifikasi akun melalui email aktif'], 'button' => ['text' => 'REGISTRASI AKUN', 'route' => 'register']],
                            3 => ['title' => 'Login menggunakan akun yang telah didaftarkan', 'items' => ['Masukkan email dan password', 'Klik "Login"']],
                            4 => ['title' => 'Lakukan Pembayaran Formulir Pendaftaran', 'items' => ['Klik "isi formulir pendaftaran"', 'Baca, pahami dan setujui syarat dan ketentuan yang berlaku di Pesantren Al-Ihsan', 'Lakukan pembayaran formulir pendaftaran sebesar Rp 300.000,-', 'Pilih metode pembayaran']],
                            5 => ['title' => 'Menunggu Verifikasi Pembayaran Formulir Pendaftaran', 'items' => ['Cek status pembayaran formulir pendaftaran pada dashboard', 'Tunggu status pembayaran formulir pendaftaran dari "Menunggu Verifikasi" menjadi "Lunas"']]
                        ];
                    @endphp
                    <div class="space-y-8">
                        @foreach ($tahapanFormulir as $no => $tahap)
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

                <div x-show="tab === 'uang-pangkal'" class="relative" style="display: none;">
                    <div class="absolute left-6 top-0 h-full w-0.5 bg-gray-200" style="z-index: -1;"></div>
                    @php
                        $tahapanUangPangkal = [
                            1 => ['title' => 'Login menggunakan akun yang telah didaftarkan', 'items' => ['Masukkan email dan password', 'Klik "Login"']],
                            2 => ['title' => 'Sudah Melakukan Pembayaran Formulir Pendaftaran', 'items' => ['Klik "status pembayaran formulir pendaftaran"', 'Jika sudah "Lunas", cek status dokumen apakah sudah terverifikasi', 'Jika "Sudah Diverifikasi" pada dashboard', 'Jika semua dokumen sudah terverifikasi lanjut tahap selanjutnya']],
                            3 => ['title' => 'Sudah Melengkapi Data Formulir Pendaftaran Dengan Benar', 'items' => ['Klik icon profil di pojok kanan pada dashboard', 'Klik "profil"', 'Cek kembali data formulir pendaftaran apakah sudah benar dan lengkap', 'Jika mengambil kategori non reguler, cek kembali no kartu indonesia pintar (KIP)', 'Jika mengambil kategori non reguler, cek kembali dokumen KIP yang sudah diunggah']],
                            4 => ['title' => 'Hubungi Admin Untuk Pembayaran Lebih Lanjut', 'items' => ['Pembayaran lebih lanjut menggunakan no rekening resmi Yayasan Pondok Pesantren Al-Ihsan', 'Hubungi admin pesantren Al-Ihsan untuk pembayaran selanjutnya (uang pangkal, infaq per semester, uang makan (putri))']]
                        ];
                    @endphp
                    <div class="space-y-8">
                        @foreach ($tahapanUangPangkal as $no => $tahap)
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
