<x-admin-layout>
    {{-- Alpine.js state for modal, user selection, and mobile view --}}
    <div x-data="{
            modalOpen: false,
            selectedSantri: null,
            isMobile: window.innerWidth < 768,
            verifModalOpen: false,
            verifActionUrl: '',
            deleteModalOpen: false,
            santriToDelete: null,
            showFilters: false,
            rejectModalOpen: false,
            rejectActionUrl: ''
         }"
         @resize.window="isMobile = window.innerWidth < 768">

        {{-- Header: Judul --}}
        <div class="flex flex-col items-start justify-between my-4 space-y-3 sm:my-6 sm:flex-row sm:items-center sm:space-y-0">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 sm:text-2xl">Pendaftaran Santri</h2>
                <p class="mt-1 text-sm text-gray-600">Kelola data pendaftar yang terdaftar di sistem.</p>
            </div>
        </div>

        {{-- Panel Konten Utama --}}
        <div class="p-3 bg-white rounded-lg shadow-md sm:p-6">
            <div class="flex flex-col items-start justify-between mb-4 space-y-3 sm:flex-row sm:items-center sm:space-y-0 sm:mb-6">
                <h3 class="text-lg font-semibold text-gray-700">Data Pendaftar</h3>
                <button @click="showFilters = !showFilters" class="flex items-center px-3 py-2 text-sm text-gray-600 border border-gray-300 rounded-md sm:hidden hover:bg-gray-50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z"></path></svg>
                    Filter & Pencarian
                </button>
            </div>

            {{-- Filter Otomatis --}}
            <div class="mb-6 transition-all duration-300" :class="{'hidden': !showFilters && isMobile, 'block': showFilters || !isMobile}">
                <form id="filter-form" action="{{ route('admin.pendaftaran') }}" method="GET">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:gap-4">
                        <div class="relative md:w-64">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </span>
                            <input id="search-input" name="search" value="{{ request('search') }}" class="w-full py-2.5 pl-10 pr-4 text-sm text-gray-800 placeholder-gray-500 bg-gray-100 border-transparent rounded-lg focus:ring-2 focus:ring-[#028579] focus:border-transparent" type="text" placeholder="Cari nama atau email..."/>
                        </div>
                        <div class="relative md:w-52">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5a2 2 0 012 2v5a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2zm0 14h.01M7 17h5a2 2 0 012 2v5a2 2 0 01-2 2H7a2 2 0 01-2-2v-5a2 2 0 012-2z"></path></svg>
                            </span>
                            <select name="type" onchange="this.form.submit()" class="w-full py-2.5 pl-10 pr-8 text-sm text-gray-800 bg-gray-100 border-transparent rounded-lg appearance-none focus:ring-2 focus:ring-[#028579] focus:border-transparent">
                                <option value="">Semua Tipe</option>
                                <option value="Reguler" {{ request('type') == 'Reguler' ? 'selected' : '' }}>Reguler</option>
                                <option value="Non-Reguler" {{ request('type') == 'Non Reguler' ? 'selected' : '' }}>Non Reguler (KIP)</option>
                            </select>
                        </div>
                        <div class="relative md:w-52">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                            <select name="status" onchange="this.form.submit()" class="w-full py-2.5 pl-10 pr-8 text-sm text-gray-800 bg-gray-100 border-transparent rounded-lg appearance-none focus:ring-2 focus:ring-[#028579] focus:border-transparent">
                                <option value="">Semua Status</option>
                                <option value="menunggu_verifikasi" {{ request('status') == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                <option value="diverifikasi" {{ request('status') == 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <a href="{{ route('admin.pendaftaran') }}" class="flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg md:w-auto hover:bg-gray-100 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h5M20 20v-5h-5"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 9a9 9 0 0114.13-5.12M20 15a9 9 0 01-14.13 5.12"></path></svg>
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            @if (session('success'))
                <div class="px-4 py-3 mb-4 text-sm text-green-700 bg-green-100 border border-green-400 rounded-lg" role="alert">
                    <p class="font-bold">Sukses!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="px-4 py-3 mb-4 text-sm text-red-700 bg-red-100 border border-red-400 rounded-lg" role="alert">
                    <p class="font-bold">Error!</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            {{-- Tampilan Kartu Mobile (Tersembunyi di Desktop) --}}
            <div class="space-y-4 md:hidden">
                 @forelse ($formulirs as $santri)
                <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-gray-900">{{ $santri->user->name ?? 'N/A' }}</h4>
                            <p class="text-xs text-gray-500">{{ $santri->user ? $santri->user->email : 'N/A' }}</p>
                            <p class="text-xs text-gray-400 mt-1">ID: {{ $santri->id }}</p>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $santri->kategori_pendaftaran == 'Reguler' ? 'text-indigo-700 bg-indigo-100' : 'text-purple-700 bg-purple-100' }}">
                                {{ $santri->kategori_pendaftaran ?? 'N/A' }}
                            </span>
                             <p class="text-xs mt-3">
                                <span class="px-2 py-1 text-xs font-semibold leading-tight rounded-full
                                    @if($santri->status_pendaftaran == 'diverifikasi') text-green-700 bg-green-100
                                    @elseif($santri->status_pendaftaran == 'menunggu_verifikasi') text-yellow-700 bg-yellow-100
                                    @elseif($santri->status_pendaftaran == 'ditolak') text-red-700 bg-red-100
                                    @else text-gray-700 bg-gray-100 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $santri->status_pendaftaran)) }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="my-3">
                        @if($santri->kipDocument)
                            <a href="{{ route('admin.formulir.download_kip', ['id' => $santri->kipDocument->id]) }}" class="inline-flex items-center px-3 py-2 text-xs font-medium text-green-700 bg-green-100 rounded-md hover:bg-green-200">
                                <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Unduh Dokumen KIP
                            </a>
                        @else
                            <span class="text-xs text-gray-400">Tidak ada KIP</span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                        <div>
                            <p class="text-xs text-gray-500">Terdaftar: {{ $santri->created_at->format('d/m/Y') }}</p>
                        </div>
                        <div class="flex space-x-2">
                            <button @click="selectedSantri = {{ json_encode($santri) }}; modalOpen = true" title="Lihat Detail" class="p-2 text-blue-600 bg-blue-100 rounded-md hover:bg-blue-200 focus:outline-none" aria-label="Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                            @if($santri->status_pendaftaran == 'menunggu_verifikasi')
                                <button @click="verifModalOpen = true; verifActionUrl = '{{ route('admin.formulir.verifikasi', ['id' => $santri->id]) }}'" title="Verifikasi Pendaftaran" class="p-2 text-green-600 bg-green-100 rounded-md hover:bg-green-200 focus:outline-none" aria-label="Verifikasi">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </button>
                                <button @click="rejectModalOpen = true; rejectActionUrl = '{{ route('admin.formulir.tolak', ['id' => $santri->id]) }}'" title="Tolak Pendaftaran" class="p-2 text-gray-500 bg-gray-100 rounded-md hover:bg-red-100 hover:text-red-600 focus:outline-none" aria-label="Tolak">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                </button>
                            @else
                                <button title="Sudah Diproses" class="p-2 text-gray-400 bg-gray-100 rounded-md cursor-not-allowed opacity-50" aria-label="Verifikasi" disabled>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </button>
                            @endif
                            <button @click="santriToDelete = {{ json_encode($santri) }}; deleteModalOpen = true" title="Hapus Pendaftar" class="p-2 text-red-600 bg-red-100 rounded-md hover:bg-red-200 focus:outline-none" aria-label="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-4 text-center text-gray-500">
                    Tidak ada data pendaftar yang ditemukan.
                </div>
                @endforelse
            </div>

            {{-- ## KODE YANG DIPERBARUI ## --}}
            {{-- Tampilan Tabel Desktop --}}
            <div class="hidden overflow-x-auto md:block">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-xs font-semibold tracking-wide text-left text-gray-500 uppercase">Nama Lengkap</th>
                            <th scope="col" class="px-4 py-3 text-xs font-semibold tracking-wide text-left text-gray-500 uppercase hidden lg:table-cell">Email</th>
                            <th scope="col" class="px-4 py-3 text-xs font-semibold tracking-wide text-left text-gray-500 uppercase">Tipe</th>
                            <th scope="col" class="px-4 py-3 text-xs font-semibold tracking-wide text-left text-gray-500 uppercase">Status Pendaftaran</th>
                            <th scope="col" class="px-4 py-3 text-xs font-semibold tracking-wide text-left text-gray-500 uppercase hidden lg:table-cell">Dokumen KIP</th>
                            <th scope="col" class="px-4 py-3 text-xs font-semibold tracking-wide text-center text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($formulirs as $santri)
                        <tr class="text-gray-700 transition-colors duration-200 hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <div class="text-sm font-medium text-gray-900">{{ $santri->user->name ?? 'N/A' }}</div>
                                <div class="text-xs text-gray-500 lg:hidden">{{ $santri->user ? $santri->user->email : 'N/A' }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm hidden lg:table-cell">{{ $santri->user ? $santri->user->email : 'N/A' }}</td>
                            <td class="px-4 py-3 text-xs whitespace-nowrap">
                                <span class="px-2 py-1 font-semibold leading-tight rounded-full {{ $santri->kategori_pendaftaran == 'Reguler' ? 'text-indigo-700 bg-indigo-100' : 'text-purple-700 bg-purple-100' }}">
                                    {{ $santri->kategori_pendaftaran ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm whitespace-nowrap">
                                <span class="px-2 py-1 font-semibold leading-tight rounded-full
                                    @if($santri->status_pendaftaran == 'diverifikasi') text-green-700 bg-green-100
                                    @elseif($santri->status_pendaftaran == 'menunggu_verifikasi') text-yellow-700 bg-yellow-100
                                    @elseif($santri->status_pendaftaran == 'ditolak') text-red-700 bg-red-100
                                    @else text-gray-700 bg-gray-100 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $santri->status_pendaftaran)) }}
                                </span>
                            </td>
                           <td class="px-4 py-3 text-sm hidden lg:table-cell whitespace-nowrap">
                                @if($santri->kipDocument)
                                    <a href="{{ route('admin.formulir.download_kip', ['id' => $santri->kipDocument->id]) }}" class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-md hover:bg-green-200">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        Unduh Dokumen
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-2">
                                    <button @click="selectedSantri = {{ json_encode($santri) }}; modalOpen = true" title="Lihat Detail" class="p-2 text-gray-500 transition-colors duration-200 rounded-lg hover:bg-gray-200 hover:text-blue-600 focus:outline-none" aria-label="Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                    @if($santri->status_pendaftaran == 'menunggu_verifikasi')
                                        <button @click="verifModalOpen = true; verifActionUrl = '{{ route('admin.formulir.verifikasi', ['id' => $santri->id]) }}'" title="Verifikasi Pendaftaran" class="p-2 text-gray-500 rounded-lg hover:bg-gray-200 hover:text-green-600 transition-colors duration-200" aria-label="Verifikasi">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </button>
                                        <button @click="rejectModalOpen = true; rejectActionUrl = '{{ route('admin.formulir.tolak', ['id' => $santri->id]) }}'" title="Tolak Pendaftaran" class="p-2 text-gray-500 rounded-lg hover:bg-gray-200 hover:text-red-600 transition-colors duration-200" aria-label="Tolak">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                        </button>
                                    @else
                                        <button title="Sudah Diproses" class="p-2 text-gray-300 rounded-lg cursor-not-allowed opacity-50" aria-label="Verifikasi" disabled>
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </button>
                                    @endif
                                    <button @click="santriToDelete = {{ json_encode($santri) }}; deleteModalOpen = true" title="Hapus Pendaftar" class="p-2 text-gray-500 rounded-lg hover:bg-gray-200 hover:text-red-600 transition-colors duration-200" aria-label="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-3 text-center text-gray-500">Tidak ada data pendaftar yang ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $formulirs->links() }}
            </div>
        </div>

        {{-- Panggil semua komponen modal di sini --}}
        <x-admin.formulir.pendaftaran-detail-modal/>
        <x-admin.formulir.pendaftaran-verifikasi-modal/>
        <x-admin.formulir.pendaftaran-tolak-modal/>
        <x-admin.formulir.pendaftaran-delete-modal/>

        <x-admin.footer />

    </div>
</x-admin-layout>

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
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search-input');
        const filterForm = document.getElementById('filter-form');
        let typingTimer;
        const doneTypingInterval = 500;

        if (searchInput) {
            searchInput.addEventListener('keyup', () => {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(() => {
                    filterForm.submit();
                }, doneTypingInterval);
            });

            searchInput.addEventListener('keydown', () => {
                clearTimeout(typingTimer);
            });
        }
    });
</script>
@endpush
