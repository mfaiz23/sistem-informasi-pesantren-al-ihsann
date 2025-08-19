{{-- Inisialisasi state Alpine.js untuk modal dan deteksi mobile --}}
<div x-data="{ modalOpen: false, selectedSantri: null, isMobile: window.innerWidth < 768 }"
     @resize.window="isMobile = window.innerWidth < 768">
    <x-admin-layout>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            {{-- Judul Halaman --}}
            <div class="my-4 sm:my-6">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-800">Pendaftaran Santri</h2>
            </div>

            {{-- Konten Utama: Panel --}}
            <div class="bg-white shadow-md rounded-lg p-3 sm:p-6">
                <h3 class="mb-4 sm:mb-6 text-lg font-semibold text-gray-700">Data Pendaftar</h3>

                {{-- Filter Responsif --}}
                <div class="flex flex-col gap-3 mb-6 sm:flex-row sm:flex-wrap sm:items-center sm:gap-4">
                    {{-- Input Pencarian --}}
                    <div class="relative flex-grow w-full sm:max-w-xs">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                        <input class="w-full h-12 pl-10 pr-4 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md focus:placeholder-gray-500 focus:bg-white focus:border-indigo-300 focus:outline-none focus:shadow-outline-indigo form-input"
                               type="text" placeholder="Cari nama atau email..."/>
                    </div>

                    {{-- Filter Dropdown --}}
                    <select class="w-full h-12 text-sm text-gray-700 bg-gray-100 border-0 rounded-md sm:w-auto focus:bg-white focus:border-indigo-300 focus:outline-none focus:shadow-outline-indigo form-select">
                        <option value="">Semua Tipe</option>
                        <option value="Reguler">Reguler</option>
                        <option value="Non Reguler">Non Reguler (KIP)</option>
                    </select>
                </div>


                {{-- Data Dummy --}}
                @php
                $pendaftar = [
                    ['reg_id' => 'PSB-2025-001', 'name' => 'Fathan Qowiyun', 'email' => 'faqowid@example.com', 'date' => '04/08/2025', 'type' => 'Reguler', 'address' => 'Jl. Merdeka No. 1, Jakarta', 'kip_document' => null],
                    ['reg_id' => 'PSB-2025-002', 'name' => 'Hendy Juniawan', 'email' => 'hendy@example.com', 'date' => '04/08/2025', 'type' => 'Non Reguler', 'address' => 'Jl. Asia Afrika No. 10, Bandung', 'kip_document' => 'dokumen_kip_hendy.pdf'],
                    ['reg_id' => 'PSB-2025-003', 'name' => 'Muhammad Ibadurrohman', 'email' => 'ibad@example.com', 'date' => '03/08/2025', 'type' => 'Reguler', 'address' => 'Jl. Pahlawan No. 20, Surabaya', 'kip_document' => null],
                    ['reg_id' => 'PSB-2025-004', 'name' => 'Muhammad Faiz R', 'email' => 'faiz@example.com', 'date' => '02/08/2025', 'type' => 'Reguler', 'address' => 'Jl. Sudirman No. 5, Yogyakarta', 'kip_document' => null],
                    ['reg_id' => 'PSB-2025-005', 'name' => 'Adila Amelia', 'email' => 'adilamella@example.com', 'date' => '01/08/2025', 'type' => 'Non Reguler', 'address' => 'Jl. Gatot Subroto No. 15, Medan', 'kip_document' => 'KIP_Adila_Amelia_2025.pdf'],
                ];
                @endphp

                {{-- Tampilan Kartu Mobile (Tersembunyi di Desktop) --}}
                <div class="space-y-4 md:hidden">
                    @foreach ($pendaftar as $santri)
                    <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900">{{ $santri['name'] }}</h4>
                                <p class="text-xs text-gray-500">{{ $santri['email'] }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold leading-tight rounded-full {{ $santri['type'] == 'Reguler' ? 'text-indigo-700 bg-indigo-100' : 'text-purple-700 bg-purple-100' }}">
                                {{ $santri['type'] }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                @if($santri['type'] == 'Non Reguler')
                                    <a href="#" class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-md hover:bg-green-200">
                                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                        Lihat KIP
                                    </a>
                                @else
                                    <span class="text-xs text-gray-400">Tidak ada KIP</span>
                                @endif
                            </div>
                            <div class="flex space-x-2">
                                <button @click="selectedSantri = {{ json_encode($santri) }}; modalOpen = true" class="p-2 text-blue-600 bg-blue-100 rounded-md hover:bg-blue-200" aria-label="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                                <button class="p-2 text-green-600 bg-green-100 rounded-md hover:bg-green-200" aria-label="Verifikasi">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Tampilan Tabel Desktop (Tersembunyi di Mobile) --}}
                <div class="hidden overflow-x-auto md:block">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Lengkap
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                                    Email
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tipe
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                                    Dokumen KIP
                                </th>
                                <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($pendaftar as $santri)
                            <tr class="text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $santri['name'] }}</div>
                                    <div class="text-xs text-gray-500 lg:hidden">{{ $santri['email'] }}</div>
                                </td>
                                <td class="px-4 py-3 text-sm hidden lg:table-cell whitespace-nowrap">{{ $santri['email'] }}</td>
                                <td class="px-4 py-3 text-xs whitespace-nowrap">
                                    <span class="px-2 py-1 font-semibold leading-tight rounded-full {{ $santri['type'] == 'Reguler' ? 'text-indigo-700 bg-indigo-100' : 'text-purple-700 bg-purple-100' }}">
                                        {{ $santri['type'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm hidden lg:table-cell whitespace-nowrap">
                                    @if($santri['kip_document'])
                                        <a href="#" class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-md hover:bg-green-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                            </svg>
                                            Unduh Dokumen
                                        </a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm whitespace-nowrap">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button @click="selectedSantri = {{ json_encode($santri) }}; modalOpen = true" class="p-2 text-gray-500 rounded-lg hover:bg-gray-200 hover:text-blue-600 transition-colors duration-200" aria-label="Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                        <button class="p-2 text-gray-500 rounded-lg hover:bg-gray-200 hover:text-green-600 transition-colors duration-200" aria-label="Verifikasi">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </button>
                                        <button class="p-2 text-gray-500 rounded-lg hover:bg-gray-200 hover:text-red-600 transition-colors duration-200" aria-label="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                 <div class="flex flex-col items-center justify-between mt-6 space-y-3 sm:flex-row sm:space-y-0">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium">1</span> sampai <span class="font-medium">5</span> dari <span class="font-medium">5</span> hasil
                    </div>
                    <nav aria-label="Pagination" class="relative z-0 inline-flex -space-x-px rounded-md shadow-sm">
                        {{-- Tombol Previous --}}
                        <button class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50">
                            <span class="sr-only">Previous</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        {{-- Tombol Halaman Aktif --}}
                        <button class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-green-600">1</button>
                        {{-- Tombol Next --}}
                        <button class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50">
                            <span class="sr-only">Next</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </nav>
                </div>
            </div>
        </div>
            </div>

       <x-admin.pendaftaran-detail-modal/>
       <x-admin.footer />

    </x-admin-layout>
</div>

@push('styles')
<style>
    /* Penyesuaian responsif kustom */
    @media (max-width: 640px) {
        .form-input, .form-select {
            min-height: 48px;
        }

        .md\\:hidden button, .md\\:hidden a {
            min-height: 44px;
            min-width: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .text-2xl { font-size: 1.5rem; }
        .text-lg { font-size: 1.125rem; }
    }
</style>
@endpush

@push('scripts')
<script>
    // Fungsi ini secara teknis tidak lagi diperlukan jika Anda hanya mengandalkan
    // kelas responsif Tailwind (`md:hidden`, `hidden md:block`).
    // Namun, untuk menyamai file `keuangan.blade.php`, fungsi ini disertakan.
    function initResponsiveTable() {
        const handleResize = () => {
            const isMobile = window.innerWidth < 768;
            const mobileView = document.querySelector('.space-y-4.md\\:hidden');
            const desktopView = document.querySelector('.hidden.overflow-x-auto.md\\:block');

            if (isMobile) {
                mobileView?.classList.remove('hidden');
                desktopView?.classList.add('hidden');
            } else {
                mobileView?.classList.add('hidden');
                desktopView?.classList.remove('hidden');
            }
        };

        window.addEventListener('resize', handleResize);
        handleResize(); // Panggil saat awal untuk mengatur state
    }

    document.addEventListener('DOMContentLoaded', initResponsiveTable);
</script>
@endpush
