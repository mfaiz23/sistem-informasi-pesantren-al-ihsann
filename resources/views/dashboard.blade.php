<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Menampilkan pesan error jika ada --}}
            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                    <p class="font-bold">Akses Ditolak</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Menggunakan grid untuk membuat dua kolom sesuai desain --}}
                <div class="grid grid-cols-1 md:grid-cols-3">

                    {{-- Kolom Kiri: Status & Aksi Utama --}}
                    <div class="md:col-span-2 p-6 md:p-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Formulir Pendaftaran</h3>

                        <div class="border-t border-gray-200 mt-4 pt-4">
                            {{-- KONDISI 1: SUDAH LUNAS & SUDAH ISI FORMULIR --}}
                            @if ($payment && $payment->status == 'success' && $formulir)
                                <div class="text-center py-8">
                                    <svg class="w-16 h-16 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <h4 class="text-xl font-semibold text-gray-700">Pendaftaran Selesai!</h4>
                                    <p class="text-gray-500 mt-2">
                                        Terima kasih, formulir dan pembayaran Anda telah kami terima.<br>
                                        Data Anda sedang dalam proses verifikasi oleh tim kami.
                                    </p>
                                    <div class="mt-6">
                                        <a href="{{ route('formulir.create') }}"
                                            class="text-sm text-blue-600 hover:underline">Lihat Detail Formulir</a>
                                    </div>
                                </div>

                                {{-- KONDISI 2: SUDAH LUNAS TAPI BELUM ISI FORMULIR --}}
                            @elseif ($payment && $payment->status == 'success')
                                <div class="text-center py-8">
                                    <svg class="w-16 h-16 text-blue-500 mx-auto mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <h4 class="text-xl font-semibold text-gray-700">Pembayaran Berhasil!</h4>
                                    <p class="text-gray-500 mt-2">Langkah selanjutnya adalah mengisi formulir pendaftaran
                                        secara lengkap.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('formulir.create') }}"
                                            class="inline-block bg-green-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-green-700 transition duration-300">
                                            Isi Formulir Sekarang
                                        </a>
                                    </div>
                                </div>

                                {{-- KONDISI 3: BELUM BAYAR (ATAU GAGAL) --}}
                            @else
                                <div class="text-center py-8">
                                    {{-- Ikon Tanda Tanya Sesuai Desain --}}
                                    <div
                                        class="w-16 h-16 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.546-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h4 class="text-xl font-semibold text-gray-700">Anda belum mengisi formulir pendaftaran
                                    </h4>
                                    <p class="text-gray-500 mt-2">
                                        Klik tombol di bawah ini untuk melanjutkan proses pendaftaran.
                                    </p>
                                    <div class="mt-6">
                                        {{-- Tombol akan aktif jika T&C sudah disetujui --}}
                                        @if(Auth::user()->accepted_tnc_at)
                                            <a href="{{ route('payment.create') }}"
                                                class="inline-block bg-green-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-green-700 transition duration-300">
                                                Lanjutkan Pendaftaran
                                            </a>
                                        @else
                                            <button disabled
                                                class="inline-block bg-gray-400 text-white font-semibold py-2 px-6 rounded-lg cursor-not-allowed">
                                                Lanjutkan Pendaftaran
                                            </button>
                                            <p class="text-xs text-gray-500 mt-2">Anda harus menyetujui Syarat & Ketentuan
                                                terlebih dahulu.</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Kolom Kanan: Keterangan Status --}}
                    <div class="md:col-span-1 border-t md:border-t-0 md:border-l border-gray-200 p-6 md:p-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Keterangan</h3>
                        <div class="border-t border-gray-200 mt-4 pt-4">
                            <ul class="space-y-4 text-sm">
                                {{-- Status Verifikasi Dokumen --}}
                                <li class="flex justify-between items-center">
                                    <span>Sudah diverifikasi</span>
                                    <span
                                        class="font-semibold {{ $formulir && $formulir->status_pendaftaran == 'diverifikasi' ? 'text-green-600' : 'text-gray-400' }}">
                                        {{ $formulir && $formulir->status_pendaftaran == 'diverifikasi' ? '✓' : '-' }}
                                    </span>
                                </li>
                                <li class="flex justify-between items-center">
                                    <span>Menunggu diverifikasi</span>
                                    <span
                                        class="font-semibold {{ $formulir && $formulir->status_pendaftaran == 'menunggu_verifikasi' ? 'text-yellow-600' : 'text-gray-400' }}">
                                        {{ $formulir && $formulir->status_pendaftaran == 'menunggu_verifikasi' ? '...' : '-' }}
                                    </span>
                                </li>
                                <li class="flex justify-between items-center">
                                    <span>Dokumen ditolak</span>
                                    <span
                                        class="font-semibold {{ $formulir && $formulir->status_pendaftaran == 'ditolak' ? 'text-red-600' : 'text-gray-400' }}">
                                        {{ $formulir && $formulir->status_pendaftaran == 'ditolak' ? '✗' : '-' }}
                                    </span>
                                </li>

                                {{-- Status Pembayaran Formulir --}}
                                <li class="flex justify-between items-center pt-2 border-t border-gray-100">
                                    <span>Status Pembayaran Formulir</span>
                                    @if ($payment && $payment->status == 'success')
                                        <span class="font-semibold text-green-600">Lunas</span>
                                    @elseif ($invoice && $invoice->status == 'pending')
                                        <span class="font-semibold text-yellow-600">Pending</span>
                                    @else
                                        <span class="font-semibold text-red-600">Belum Dibayar</span>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal T&C tetap sama, akan muncul jika user belum setuju --}}
    <x-tnc-modal :show="!Auth::user()->accepted_tnc_at" />
</x-app-layout>