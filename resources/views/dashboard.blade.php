<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Menggunakan grid untuk membuat dua kolom --}}
                <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-3 gap-8">

                    {{-- Kolom Kiri: Status Formulir & Aksi --}}
                    <div class="md:col-span-2">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Formulir Pendaftaran</h3>

                        {{-- KONDISI 1: SUDAH BAYAR & BERHASIL --}}
                        @if ($payment && $payment->status == 'berhasil')
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h4 class="text-xl font-semibold text-gray-700">Pembayaran Berhasil!</h4>
                                <p class="text-gray-500 mt-2">
                                    Terima kasih, pembayaran formulir Anda telah kami terima.<br>
                                    Data Anda sedang dalam proses verifikasi oleh tim kami.
                                </p>
                                <div class="mt-6">
                                    <a href="{{ route('formulir.create') }}"
                                        class="text-sm text-blue-600 hover:underline">Lihat Detail Formulir</a>
                                </div>
                            </div>

                            {{-- KONDISI 2: SUDAH ISI FORMULIR, TAPI BELUM BAYAR --}}
                        @elseif ($formulir)
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 text-blue-500 mx-auto mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                    </path>
                                </svg>
                                <h4 class="text-xl font-semibold text-gray-700">Formulir Telah Diisi!</h4>
                                <p class="text-gray-500 mt-2">
                                    Langkah selanjutnya adalah menyelesaikan pembayaran biaya formulir.
                                </p>
                                <div class="mt-6">
                                    @if(Auth::user()->accepted_tnc_at)
                                        <a href="{{ route('payment.create') }}"
                                            class="inline-block bg-blue-500 text-white font-bold py-3 px-8 rounded-lg hover:bg-blue-600 transition duration-300">
                                            Lanjutkan Pembayaran
                                        </a>
                                    @else
                                        <button disabled
                                            class="inline-block bg-gray-400 text-white font-bold py-3 px-8 rounded-lg cursor-not-allowed">
                                            Lanjutkan Pembayaran
                                        </button>
                                        <p class="text-xs text-gray-500 mt-2">Anda harus menyetujui Syarat & Ketentuan terlebih
                                            dahulu.</p>
                                    @endif
                                </div>
                            </div>

                            {{-- KONDISI 3: BELUM ISI FORMULIR SAMA SEKALI --}}
                        @else
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <h4 class="text-xl font-semibold text-gray-700">Kamu belum mengisi formulir pendaftaran</h4>
                                <p class="text-gray-500 mt-2">klik tombol dibawah ini untuk mengisi formulir pendaftaran</p>
                                <div class="mt-6">
                                    @if(Auth::user()->accepted_tnc_at)
                                        <a href="{{ route('formulir.create') }}"
                                            class="inline-block bg-green-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-green-700 transition duration-300">
                                            Isi Formulir Pendaftaran
                                        </a>
                                    @else
                                        <button disabled
                                            class="inline-block bg-gray-400 text-white font-semibold py-2 px-6 rounded-lg cursor-not-allowed">
                                            Isi Formulir Pendaftaran
                                        </button>
                                        <p class="text-xs text-gray-500 mt-2">Anda harus menyetujui Syarat & Ketentuan terlebih
                                            dahulu.</p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Kolom Kanan: Keterangan Status --}}
                    <div
                        class="md:col-span-1 border-t md:border-t-0 md:border-l border-gray-200 pl-0 md:pl-8 pt-8 md:pt-0">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Keterangan</h3>
                        <ul class="space-y-4 text-sm">
                            <li class="flex justify-between items-center">
                                <span>Status Pembayaran Formulir</span>
                                @if ($payment && $payment->status == 'berhasil')
                                    <span class="font-semibold text-green-600">Lunas</span>
                                @elseif ($payment && $payment->status == 'pending')
                                    <span class="font-semibold text-yellow-600">Pending</span>
                                @elseif ($payment && $payment->status == 'gagal')
                                    <span class="font-semibold text-red-600">Gagal</span>
                                @else
                                    <span class="font-semibold text-gray-500">Belum Dibayar</span>
                                @endif
                            </li>
                            <li class="flex justify-between items-center">
                                <span>Status Verifikasi Formulir</span>
                                @if ($formulir && $formulir->status_pendaftaran == 'diverifikasi')
                                    <span class="font-semibold text-green-600">Sudah Diverifikasi</span>
                                @elseif ($formulir && $formulir->status_pendaftaran == 'menunggu_verifikasi')
                                    <span class="font-semibold text-yellow-600">Menunggu Verifikasi</span>
                                @else
                                    <span class="font-semibold text-gray-500">-</span>
                                @endif
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Tampilkan modal T&C jika user belum setuju --}}
    <x-tnc-modal :show="!Auth::user()->accepted_tnc_at" />
</x-app-layout>