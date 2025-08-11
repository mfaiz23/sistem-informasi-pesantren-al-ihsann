<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-3 gap-8">

                    {{-- Kolom Kiri: Status Formulir --}}
                    <div class="md:col-span-2">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Formulir Pendaftaran</h3>

                        @if ($formulir)
                            {{-- TAMPILAN JIKA SUDAH MENGISI FORMULIR --}}
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h4 class="text-xl font-semibold text-gray-700">Terima Kasih!</h4>
                                <p class="text-gray-500 mt-2">
                                    Anda telah melengkapi formulir pendaftaran. <br>
                                    Silakan periksa status pendaftaran Anda di kolom keterangan.
                                </p>
                                <div class="mt-6">
                                    <a href="{{ route('formulir.create') }}"
                                        class="text-sm text-blue-600 hover:underline">Lihat Detail Formulir</a>
                                </div>
                            </div>
                        @else
                            {{-- TAMPILAN JIKA BELUM MENGISI FORMULIR (SESUAI DESAIN) --}}
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <h4 class="text-xl font-semibold text-gray-700">Kamu belum mengisi formulir pendaftaran</h4>
                                <p class="text-gray-500 mt-2">klik tombol dibawah ini untuk mengisi formulir pendaftaran</p>
                                <div class="mt-6">
                                    <a href="{{ route('formulir.create') }}"
                                        class="inline-block bg-green-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-green-700 transition duration-300">
                                        Isi Formulir Pendaftaran
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Kolom Kanan: Keterangan Status --}}
                    <div
                        class="md:col-span-1 border-t md:border-t-0 md:border-l border-gray-200 pl-0 md:pl-8 pt-8 md:pt-0">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Keterangan</h3>
                        <ul class="space-y-4 text-sm">
                            <li class="flex justify-between items-center text-green-600">
                                <span>Sudah diverifikasi</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </li>
                            <li class="flex justify-between items-center text-yellow-600">
                                <span>Menunggu diverifikasi</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </li>
                            <li class="flex justify-between items-center text-red-600">
                                <span>Dokumen ditolak</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </li>
                            <li class="flex justify-between items-center text-gray-700">
                                <span>Belum upload persyaratan</span>
                                {{-- Icon bisa ditambahkan nanti --}}
                            </li>
                            <li class="flex justify-between items-center text-gray-700">
                                <span>Status Pembayaran Formulir</span>
                                {{-- Status pembayaran akan kita buat dinamis nanti --}}
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>