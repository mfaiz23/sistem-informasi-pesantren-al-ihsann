<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Pesan error atau notifikasi --}}
            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                    <p class="font-bold">Akses Ditolak</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            {{-- Alert jika Formulir Utama Ditolak --}}
            @if ($formulir && $formulir->status_pendaftaran == 'ditolak')
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                    <p class="font-bold">Perhatian!</p>
                    <p>Formulir Anda ditolak. Silakan periksa detail di bawah dan perbarui data Anda melalui halaman Profil Akun.</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-3">

                    {{-- Kolom Kiri: Status & Aksi Utama --}}
                    <div class="md:col-span-2 p-6 md:p-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Formulir Pendaftaran</h3>
                        <div class="border-t border-gray-200 mt-4 pt-4">

                            {{-- KONDISI 1: SETELAH MENGISI FORMULIR --}}
                            @if ($payment && $payment->status == 'success' && $formulir)
                                <div class="text-center py-8">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="text-xl font-semibold text-gray-700">Kamu sudah mengisi formulir pendaftaran</h4>
                                    <p class="text-gray-500 mt-2">Klik tombol di bawah ini untuk melihat atau mengubah data formulir.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('profile.edit') }}" class="inline-block bg-[#028579] text-white font-semibold py-3 px-8 rounded-lg hover:bg-[#016a60] transition duration-300">
                                            Profil Akun
                                        </a>
                                    </div>
                                </div>

                            {{-- KONDISI 2: SUDAH LUNAS TAPI BELUM ISI FORMULIR --}}
                            @elseif ($payment && $payment->status == 'success')
                                <div class="text-center py-8">
                                     <div class="w-16 h-16 bg-gray-800 rounded-full mx-auto mb-4 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.546-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="text-xl font-semibold text-gray-700">Kamu belum mengisi formulir pendaftaran</h4>
                                    <p class="text-gray-500 mt-2">Klik tombol di bawah ini untuk mengisi formulir pendaftaran.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('formulir.create') }}" class="inline-block bg-[#028579] text-white font-semibold py-3 px-8 rounded-lg hover:bg-[#016a60] transition duration-300">
                                            Isi Formulir Pendaftaran
                                        </a>
                                    </div>
                                </div>

                            {{-- KONDISI 3: BELUM BAYAR --}}
                            @else
                                <div class="text-center py-8">
                                    <div class="w-16 h-16 bg-gray-800 rounded-full mx-auto mb-4 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.546-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="text-xl font-semibold text-gray-700">Selamat Datang, {{ strtok(Auth::user()->name, ' ') }}!</h4>
                                    <p class="text-gray-500 mt-2 max-w-sm mx-auto">
                                        Langkah pertama untuk mendaftar adalah menyelesaikan pembayaran biaya formulir.
                                    </p>
                                    <div class="mt-6">
                                        <a href="{{ route('payment.create') }}" class="inline-block bg-blue-500 text-white font-semibold py-3 px-8 rounded-lg hover:bg-blue-600 transition duration-300">
                                            Lanjutkan ke Pembayaran
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Kolom Kanan: Keterangan Status & Dokumen --}}
                    <div class="md:col-span-1 border-t md:border-t-0 md:border-l border-gray-200 p-6 md:p-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Keterangan Pendaftaran</h3>
                        <div class="border-t border-gray-200 mt-4 pt-4">
                            <ul class="space-y-4 text-sm">
                                {{-- Status Verifikasi (Statis) --}}
                                <li class="flex justify-between items-center">
                                    <span class="text-gray-600">Sudah diverifikasi</span>
                                    @if ($formulir && $formulir->status_pendaftaran == 'diverifikasi')
                                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    @else
                                        <span class="text-gray-400 font-semibold">-</span>
                                    @endif
                                </li>
                                <li class="flex justify-between items-center">
                                    <span class="text-gray-600">Menunggu diverifikasi</span>
                                    @if ($formulir && $formulir->status_pendaftaran == 'menunggu_verifikasi')
                                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    @else
                                        <span class="text-gray-400 font-semibold">-</span>
                                    @endif
                                </li>
                                <li class="flex justify-between items-center">
                                    <span class="text-gray-600">Formulir ditolak</span>
                                    @if ($formulir && $formulir->status_pendaftaran == 'ditolak')
                                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    @else
                                        <span class="text-gray-400 font-semibold">-</span>
                                    @endif
                                </li>

                                {{-- === NEW: STATUS DOKUMEN (DROPDOWN) === --}}
                                @if($formulir)
                                <li x-data="{ open: false }" class="pt-3 border-t border-gray-100">
                                    <button @click="open = !open" class="w-full flex justify-between items-center text-left text-gray-700 font-semibold focus:outline-none">
                                        <span>Status Dokumen</span>
                                        <svg class="w-4 h-4 transform transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>

                                    <div x-show="open" x-collapse class="pt-3 mt-2 space-y-3">
                                        {{-- Loop KTP, KK, Ijazah --}}
                                        @foreach([
                                            ['label' => 'KTP', 'status' => $formulir->status_dokumen_ktp, 'reason' => $formulir->alasan_tolak_ktp],
                                            ['label' => 'KK', 'status' => $formulir->status_dokumen_kk, 'reason' => $formulir->alasan_tolak_kk],
                                            ['label' => 'Ijazah', 'status' => $formulir->status_dokumen_ijazah, 'reason' => $formulir->alasan_tolak_ijazah],
                                        ] as $doc)
                                        <div class="bg-gray-50 p-2 rounded border border-gray-100">
                                            <div class="flex justify-between items-center">
                                                <span class="text-gray-600 font-medium">{{ $doc['label'] }}</span>
                                                @if($doc['status'] == 'valid')
                                                    <span class="text-[10px] font-bold text-green-600 bg-green-100 px-2 py-0.5 rounded">VALID</span>
                                                @elseif($doc['status'] == 'invalid')
                                                    <span class="text-[10px] font-bold text-red-600 bg-red-100 px-2 py-0.5 rounded">DITOLAK</span>
                                                @else
                                                    <span class="text-[10px] font-bold text-yellow-600 bg-yellow-100 px-2 py-0.5 rounded">PENDING</span>
                                                @endif
                                            </div>
                                            {{-- Alasan Penolakan --}}
                                            @if($doc['status'] == 'invalid' && $doc['reason'])
                                                <div class="mt-2 text-xs text-red-600 border-t border-red-100 pt-1">
                                                    <span class="font-bold">Alasan:</span> {{ $doc['reason'] }}
                                                </div>
                                            @endif
                                        </div>
                                        @endforeach

                                        {{-- KIP (Khusus Non-Reguler) --}}
                                        @if($formulir->kategori_pendaftaran == 'Non-Reguler' && $formulir->kipDocument)
                                            @php
                                                $kipStatus = $formulir->kipDocument->status_verifikasi;
                                                $kipBadge = $kipStatus == 'valid' ? 'VALID' : ($kipStatus == 'tidak_valid' ? 'DITOLAK' : 'PENDING');
                                                $kipColor = $kipStatus == 'valid' ? 'green' : ($kipStatus == 'tidak_valid' ? 'red' : 'yellow');
                                                $kipReason = $formulir->kipDocument->alasan_penolakan;
                                            @endphp
                                            <div class="bg-gray-50 p-2 rounded border border-gray-100">
                                                <div class="flex justify-between items-center">
                                                    <span class="text-gray-600 font-medium">KIP</span>
                                                    <span class="text-[10px] font-bold text-{{ $kipColor }}-600 bg-{{ $kipColor }}-100 px-2 py-0.5 rounded">{{ $kipBadge }}</span>
                                                </div>
                                                @if($kipStatus == 'tidak_valid' && $kipReason)
                                                    <div class="mt-2 text-xs text-red-600 border-t border-red-100 pt-1">
                                                        <span class="font-bold">Alasan:</span> {{ $kipReason }}
                                                    </div>
                                                @endif
                                            </div>
                                        @endif

                                        {{-- Tombol Perbaiki (Muncul jika ada dokumen yang Invalid) --}}
                                        @if(in_array('invalid', [$formulir->status_dokumen_ktp, $formulir->status_dokumen_kk, $formulir->status_dokumen_ijazah]) ||
                                           ($formulir->kipDocument && $formulir->kipDocument->status_verifikasi == 'tidak_valid'))
                                            <div class="pt-2">
                                                <a href="{{ route('profile.edit') }}" class="block w-full text-center bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-2 px-4 rounded transition">
                                                    Perbaiki Dokumen
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </li>
                                @endif

                                {{-- Status Pembayaran Formulir --}}
                                <li x-data="{ open: false }" class="pt-3 border-t border-gray-100">
                                    <button @click="open = !open" class="w-full flex justify-between items-center text-left text-gray-700 font-semibold focus:outline-none">
                                        <span>Status Pembayaran Formulir</span>
                                        <svg class="w-4 h-4 transform transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div x-show="open" x-collapse class="pt-3 mt-3 border-t border-gray-200">
                                        @if ($invoice)
                                            <dl class="space-y-2 text-xs">
                                                <div class="flex justify-between">
                                                    <dt class="text-gray-500">Tanggal:</dt>
                                                    <dd class="text-gray-800 font-medium">{{ $invoice->completed_at ? $invoice->completed_at->format('d/m/Y') : '-' }}</dd>
                                                </div>
                                                <div class="flex justify-between">
                                                    <dt class="text-gray-500">Nominal:</dt>
                                                    <dd class="text-gray-800 font-medium">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</dd>
                                                </div>
                                                @if ($payment)
                                                    <div class="flex justify-between">
                                                        <dt class="text-gray-500">Metode:</dt>
                                                        <dd class="text-gray-800 font-medium capitalize">{{ str_replace('_', ' ', $payment->payment_method) }}</dd>
                                                    </div>
                                                @endif
                                                <div class="flex justify-between items-center">
                                                    <dt class="text-gray-500">Status:</dt>
                                                    <dd>
                                                        <span class="px-2 py-1 font-semibold leading-tight rounded-full
                                                            @if($invoice->status == 'paid') text-green-700 bg-green-100
                                                            @elseif($invoice->status == 'pending') text-yellow-700 bg-yellow-100
                                                            @else text-red-700 bg-red-100 @endif">
                                                            {{ $invoice->status == 'paid' ? 'Lunas' : ucfirst($invoice->status) }}
                                                        </span>
                                                    </dd>
                                                </div>
                                            </dl>
                                        @else
                                            <p class="text-gray-500">Belum ada transaksi.</p>
                                        @endif
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <x-tnc-modal :show="!Auth::user()->accepted_tnc_at" />
</x-app-layout>
