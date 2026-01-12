<x-admin-layout>
    {{-- Alpine.js state for modal, user selection, and mobile view --}}
    {{-- PERBAIKAN 1: Menambahkan deleteModalOpen dan userToDelete --}}
    <div x-data="{
            modalOpen: false,
            selectedUser: null,
            deleteModalOpen: false,
            userToDelete: null,
            isMobile: window.innerWidth < 768,
            showFilters: false
         }"
         @resize.window="isMobile = window.innerWidth < 768">

        {{-- Header: Judul --}}
        <div class="flex flex-col items-start justify-between my-4 space-y-3 sm:my-6 sm:flex-row sm:items-center sm:space-y-0">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 sm:text-2xl">Manajemen Pengguna</h2>
                <p class="mt-1 text-sm text-gray-600">Kelola data pengguna yang terdaftar di sistem.</p>
            </div>
        </div>

        {{-- Panel Konten Utama --}}
        <div class="p-3 bg-white rounded-lg shadow-md sm:p-6 overflow-x-auto">
            <div class="flex flex-col items-start justify-between mb-4 space-y-3 sm:flex-row sm:items-center sm:space-y-0 sm:mb-6">
                <h3 class="text-lg font-semibold text-gray-700">Data Pengguna</h3>
                <button @click="showFilters = !showFilters" class="flex items-center px-3 py-2 text-sm text-gray-600 border border-gray-300 rounded-md sm:hidden hover:bg-gray-50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z"></path></svg>
                    Filter & Pencarian
                </button>
            </div>

            {{-- Filter Otomatis --}}
            <div class="mb-6 transition-all duration-300" :class="{'hidden': !showFilters && isMobile, 'block': showFilters || !isMobile}">
                <form id="filter-form" action="{{ route('admin.users.index') }}" method="GET">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:gap-4">
                        {{-- DIUBAH: kelas 'flex-grow' dihapus dan diganti 'md:w-64' --}}
                        <div class="relative md:w-64">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </span>
                            <input id="search-input" name="search" value="{{ request('search') }}" class="w-full py-2.5 pl-10 pr-4 text-sm text-gray-800 placeholder-gray-500 bg-gray-100 border-transparent rounded-lg focus:ring-2 focus:ring-[#028579] focus:border-transparent" type="text" placeholder="Cari nama atau email..."/>
                        </div>
                        <div class="relative md:w-52">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </span>
                            <select name="role" onchange="this.form.submit()" class="w-full py-2.5 pl-10 pr-8 text-sm text-gray-800 bg-gray-100 border-transparent rounded-lg appearance-none focus:ring-2 focus:ring-[#028579] focus:border-transparent">
                                <option value="">Semua Role</option>
                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="calon_mahasiswa" {{ request('role') == 'calon_mahasiswa' ? 'selected' : '' }}>Calon Santri</option>
                            </select>
                        </div>
                        <div class="relative md:w-52">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                            <select name="status" onchange="this.form.submit()" class="w-full py-2.5 pl-10 pr-8 text-sm text-gray-800 bg-gray-100 border-transparent rounded-lg appearance-none focus:ring-2 focus:ring-[#028579] focus:border-transparent">
                                <option value="">Semua Status</option>
                                <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                                <option value="unverified" {{ request('status') == 'unverified' ? 'selected' : '' }}>Belum Verifikasi</option>
                            </select>
                        </div>
                        <div class="relative md:w-52">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9M3 12h9m-9 4h13m0-4l3 3m0 0l3-3m-3 3v-6"></path></svg>
                            </span>
                            <select name="sort" onchange="this.form.submit()" class="w-full py-2.5 pl-10 pr-8 text-sm text-gray-800 bg-gray-100 border-transparent rounded-lg appearance-none focus:ring-2 focus:ring-[#028579] focus:border-transparent">
                                <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Tanggal Terbaru</option>
                                <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Tanggal Terlama</option>
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama (Z-A)</option>
                            </select>
                        </div>
                        <a href="{{ route('admin.users.index') }}" class="flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg md:w-auto hover:bg-gray-100 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
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

            {{-- Tampilan Kartu Mobile --}}
            <div class="space-y-4 md:hidden">
                 @forelse ($users as $user)
                <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-gray-900">{{ $user->name }}</h4>
                            <p class="text-xs text-gray-500">{{ $user->email }}</p>
                            <p class="text-xs text-gray-400 mt-1">ID: {{ $user->id }}</p>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $user->email_verified_at ? 'text-green-700 bg-green-100' : 'text-yellow-700 bg-yellow-100' }}">
                                {{ $user->email_verified_at ? 'Terverifikasi' : 'Belum Verifikasi' }}
                            </span>
                             <p class="text-xs text-gray-500 mt-1">{{ $user->role == 'calon_mahasiswa' ? 'Calon Santri' : 'Admin' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                        <div>
                            <p class="text-xs text-gray-500">Terdaftar: {{ $user->created_at->format('d/m/Y') }}</p>
                        </div>
                        <div class="flex space-x-2">
                            <button @click="selectedUser = {{ json_encode($user) }}; modalOpen = true" class="p-2 text-blue-600 bg-blue-100 rounded-md hover:bg-blue-200 focus:outline-none" title="Lihat Detail" aria-label="Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                            <a href="{{ route('admin.users.edit', $user) }}" class="p-2 text-green-600 bg-green-100 rounded-md hover:bg-green-200 focus:outline-none" aria-label="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L16.732 3.732z"></path></svg>
                            </a>
                            {{-- PERBAIKAN 2: Mengganti <form> dengan <button> untuk Mobile --}}
                            @if ($user->role !== 'admin')
                                <button @click="userToDelete = {{ json_encode($user) }}; deleteModalOpen = true" title="hapus pengguna"
                                        class="p-2 text-red-600 bg-red-100 rounded-md hover:bg-red-200 focus:outline-none"
                                        aria-label="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-4 text-center text-gray-500">
                    Tidak ada data pengguna ditemukan.
                </div>
                @endforelse
            </div>

            {{-- Tampilan Tabel Desktop --}}
            <div class="hidden overflow-x-auto md:block">
                <x-admin.datatable>
                    <x-slot name="header">
                        <th class="px-4 py-3 text-xs font-semibold tracking-wide text-left text-gray-500 uppercase">ID</th>
                        <th class="px-4 py-3 text-xs font-semibold tracking-wide text-left text-gray-500 uppercase">Nama Lengkap</th>
                        <th class="px-4 py-3 text-xs font-semibold tracking-wide text-left text-gray-500 uppercase">Email</th>
                        <th class="px-4 py-3 text-xs font-semibold tracking-wide text-left text-gray-500 uppercase">Role</th>
                        <th class="px-4 py-3 text-xs font-semibold tracking-wide text-left text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-xs font-semibold tracking-wide text-left text-gray-500 uppercase hidden lg:table-cell">Tanggal Daftar</th>
                        <th class="px-4 py-3 text-xs font-semibold tracking-wide text-center text-gray-500 uppercase">Aksi</th>
                    </x-slot>
                    @forelse ($users as $user)
                    <tr class="text-gray-700 transition-colors duration-200 hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm font-semibold">{{ $user->id }}</td>
                        <td class="px-4 py-3 text-sm font-medium">{{ $user->name }}</td>
                        <td class="px-4 py-3 text-sm">{{ $user->email }}</td>
                        <td class="px-4 py-3 text-sm whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $user->role == 'admin' ? 'text-purple-700 bg-purple-100' : 'text-blue-700 bg-blue-100' }}">
                                {{ $user->role == 'calon_mahasiswa' ? 'Calon Santri' : 'Admin' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-xs">
                             <span class="px-2 py-1 font-semibold leading-tight rounded-full {{ $user->email_verified_at ? 'text-green-700 bg-green-100' : 'text-yellow-700 bg-yellow-100' }}">
                                {{ $user->email_verified_at ? 'Terverifikasi' : 'Belum Verifikasi' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm hidden lg:table-cell">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex items-center justify-center space-x-2">
                                <button @click="selectedUser = {{ json_encode($user) }}; modalOpen = true" class="p-2 text-gray-500 transition-colors duration-200 rounded-lg hover:bg-gray-200 hover:text-blue-600 focus:outline-none" title="Lihat Detail" aria-label="Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>

                               {{-- PERBAIKAN 3: Mengganti <form> dengan <button> untuk Desktop --}}
                                @if ($user->role !== 'admin')
                                    <button @click="userToDelete = {{ json_encode($user) }}; deleteModalOpen = true" title="Hapus Pengguna"
                                            class="p-2 text-gray-500 transition-colors duration-200 rounded-lg hover:bg-gray-200 hover:text-red-600 focus:outline-none"
                                            aria-label="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-3 text-center text-gray-500">Tidak ada data pengguna ditemukan.</td>
                    </tr>
                    @endforelse
                </x-admin.datatable>
            </div>

            <div class="mt-6">
                {{ $users->links() }}
            </div>
        </div>

        <x-admin.footer />
        <x-admin.users.users-detail-modal />
        <x-admin.users.users-delete-modal />
    </div>
</x-admin-layout>

@push('styles')
<style>
    /* Style tidak berubah */
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        // Logika Alpine.js
    });

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
