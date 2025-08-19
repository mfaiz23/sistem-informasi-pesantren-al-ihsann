{{-- Responsive User Management Dashboard --}}
<div x-data="{ modalOpen: false, selectedUser: null, isMobile: window.innerWidth < 768, showFilters: false }"
     @resize.window="isMobile = window.innerWidth < 768">
    <x-admin-layout>
        {{-- Header Section - Mobile Optimized --}}
        <div class="flex flex-col items-start justify-between my-4 space-y-3 sm:my-6 sm:flex-row sm:items-center sm:space-y-0">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 sm:text-2xl">Manajemen Pengguna</h2>
                <p class="mt-1 text-sm text-gray-600 sm:hidden">Kelola data pengguna sistem</p>
            </div>
            <a href="#" class="w-full sm:w-auto flex items-center justify-center px-4 py-3 text-sm font-medium text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg shadow-md min-h-[48px] active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">
                <svg class="w-4 h-4 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                </svg>
                <span>Tambah Pengguna</span>
            </a>
        </div>


        {{-- Main Content Panel --}}
        <div class="p-3 bg-white rounded-lg shadow-md sm:p-6">
            <div class="flex flex-col items-start justify-between mb-4 space-y-3 sm:flex-row sm:items-center sm:space-y-0 sm:mb-6">
                <h3 class="text-lg font-semibold text-gray-700">Data Pengguna</h3>

                {{-- Mobile Filter Toggle --}}
                <button @click="showFilters = !showFilters"
                        class="flex items-center px-3 py-2 text-sm text-gray-600 border border-gray-300 rounded-md sm:hidden hover:bg-gray-50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z"></path>
                    </svg>
                    Filter & Pencarian
                </button>
            </div>

            {{-- Responsive Filters --}}
            <div class="mb-6 transition-all duration-300"
                 :class="{'hidden': !showFilters && isMobile, 'block': showFilters || !isMobile}">
                <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center sm:gap-4">
                    {{-- Search Input --}}
                    <div class="relative flex-grow w-full sm:max-w-xs">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                        <input class="w-full h-12 pl-10 pr-4 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md focus:placeholder-gray-500 focus:bg-white focus:border-green-300 focus:outline-none focus:shadow-outline-green form-input"
                               type="text" placeholder="Cari nama atau email..."/>
                    </div>

                    {{-- Role Filter --}}
                    <select class="w-full h-12 text-sm text-gray-700 bg-gray-100 border-0 rounded-md sm:w-auto focus:bg-white focus:border-green-300 focus:outline-none focus:shadow-outline-green form-select">
                        <option value="">Semua Role</option>
                        <option value="admin">Admin</option>
                        <option value="calon_santri">Calon Santri</option>
                    </select>

                    {{-- Status Filter --}}
                    <select class="w-full h-12 text-sm text-gray-700 bg-gray-100 border-0 rounded-md sm:w-auto focus:bg-white focus:border-green-300 focus:outline-none focus:shadow-outline-green form-select">
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>
            </div>

            {{-- Data Dummy --}}
            @php
            $users = [
                ['id' => '001', 'name' => 'Fathan Qowiyun', 'email' => 'faqowid@example.com', 'role' => 'Admin', 'status' => 'Aktif', 'date' => '04/08/2025', 'last_login' => '12/08/2025 10:30'],
                ['id' => '002', 'name' => 'Hendy Juniawan', 'email' => 'hendy@example.com', 'role' => 'Calon Santri', 'status' => 'Aktif', 'date' => '04/08/2025', 'last_login' => '11/08/2025 15:45'],
                ['id' => '003', 'name' => 'Muhammad Ibadurrohman', 'email' => 'ibad@example.com', 'role' => 'Calon Santri', 'status' => 'Aktif', 'date' => '03/08/2025', 'last_login' => '10/08/2025 09:20'],
                ['id' => '004', 'name' => 'Muhammad Faiz R', 'email' => 'faiz@example.com', 'role' => 'Calon Santri', 'status' => 'Aktif', 'date' => '02/08/2025', 'last_login' => '09/08/2025 14:15'],
                ['id' => '005', 'name' => 'Adila Amelia', 'email' => 'adilamella@example.com', 'role' => 'Calon Santri', 'status' => 'Nonaktif', 'date' => '01/08/2025', 'last_login' => '05/08/2025 11:30'],
            ];
            @endphp

            {{-- Mobile Card View --}}
            <div class="space-y-4 md:hidden">
                @foreach ($users as $user)
                <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-gray-900">{{ $user['name'] }}</h4>
                            <p class="text-xs text-gray-500">{{ $user['email'] }}</p>
                            <p class="text-xs text-gray-400 mt-1">ID: {{ $user['id'] }}</p>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $user['status'] == 'Aktif' ? 'text-green-700 bg-green-100' : 'text-yellow-700 bg-yellow-100' }}">
                                {{ $user['status'] }}
                            </span>
                            <p class="text-xs text-gray-500 mt-1">{{ $user['role'] }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                        <div>
                            <p class="text-xs text-gray-500">Terdaftar: {{ $user['date'] }}</p>
                            <p class="text-xs text-gray-400">Login: {{ $user['last_login'] }}</p>
                        </div>

                        <div class="flex space-x-2">
                            <button @click="selectedUser = {{ json_encode($user) }}; modalOpen = true"
                                    class="p-2 text-blue-600 bg-blue-100 rounded-md hover:bg-blue-200 focus:outline-none min-h-[44px] min-w-[44px]"
                                    aria-label="Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                            <button class="p-2 text-green-600 bg-green-100 rounded-md hover:bg-green-200 focus:outline-none min-h-[44px] min-w-[44px]"
                                    aria-label="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L16.732 3.732z"></path>
                                </svg>
                            </button>
                            <button class="p-2 text-red-600 bg-red-100 rounded-md hover:bg-red-200 focus:outline-none min-h-[44px] min-w-[44px]"
                                    aria-label="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Desktop Table View --}}
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

                    @foreach ($users as $user)
                    <tr class="text-gray-700 transition-colors duration-200 hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm font-semibold">{{ $user['id'] }}</td>
                        <td class="px-4 py-3 text-sm font-medium">{{ $user['name'] }}</td>
                        <td class="px-4 py-3 text-sm">{{ $user['email'] }}</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $user['role'] == 'Admin' ? 'text-purple-700 bg-purple-100' : 'text-blue-700 bg-blue-100' }}">
                                {{ $user['role'] }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-xs">
                            <span class="px-2 py-1 font-semibold leading-tight rounded-full {{ $user['status'] == 'Aktif' ? 'text-green-700 bg-green-100' : 'text-yellow-700 bg-yellow-100' }}">
                                {{ $user['status'] }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm hidden lg:table-cell">{{ $user['date'] }}</td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex items-center justify-center space-x-2">
                                <button @click="selectedUser = {{ json_encode($user) }}; modalOpen = true"
                                        class="p-2 text-gray-500 transition-colors duration-200 rounded-lg hover:bg-gray-200 hover:text-blue-600 focus:outline-none min-h-[44px] min-w-[44px]"
                                        aria-label="Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>

                                <a href="#" class="p-2 text-gray-500 transition-colors duration-200 rounded-lg hover:bg-gray-200 hover:text-green-600 focus:outline-none min-h-[44px] min-w-[44px]" aria-label="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L16.732 3.732z"></path>
                                    </svg>
                                </a>

                                <button class="p-2 text-gray-500 transition-colors duration-200 rounded-lg hover:bg-gray-200 hover:text-red-600 focus:outline-none min-h-[44px] min-w-[44px]" aria-label="Delete">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </x-admin.datatable>
            </div>

            {{-- Pagination - Mobile Optimized --}}
            <div class="flex flex-col items-center justify-between mt-6 space-y-3 sm:flex-row sm:space-y-0">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium">1</span> sampai <span class="font-medium">5</span> dari <span class="font-medium">5</span> hasil
                </div>
                <nav aria-label="Pagination" class="relative z-0 inline-flex -space-x-px rounded-md shadow-sm">
                    <button class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50 min-h-[40px]">
                        <span class="sr-only">Previous</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <button class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-green-600 min-h-[40px]">1</button>
                    <button class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50 min-h-[40px]">
                        <span class="sr-only">Next</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </nav>
            </div>
        </div>
        <x-admin.footer />
    </x-admin-layout>

    {{-- Modal Component --}}
    <x-admin.users-detail-modal />


</div>

@push('styles')
<style>
    /* Mobile-specific adjustments */
    @media (max-width: 640px) {
        .form-input, .form-select {
            min-height: 48px;
        }

        /* Improve readability on mobile */
        .text-xs {
            font-size: 0.75rem;
            line-height: 1rem;
        }

        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem;
        }

        /* Card spacing optimization */
        .space-y-4 > * + * {
            margin-top: 1rem;
        }
    }

    /* Tablet optimizations */
    @media (min-width: 641px) and (max-width: 1024px) {
        .sm\:grid-cols-2 {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Touch-friendly interactions */
    @media (hover: none) {
        button:hover, a:hover {
            background-color: initial;
        }

        button:active, a:active {
            transform: scale(0.98);
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function initUserManagement() {
        // Handle responsive table switching
        const handleResize = () => {
            const isMobile = window.innerWidth < 768;
            const event = new CustomEvent('resize-update', { detail: { isMobile } });
            window.dispatchEvent(event);
        };

        // Debounce resize handler for better performance
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(handleResize, 150);
        });

        // Initial call
        handleResize();

        // Handle filter toggle on mobile
        document.addEventListener('click', (e) => {
            if (e.target.closest('[data-filter-toggle]')) {
                const filtersContainer = document.querySelector('[data-filters]');
                if (filtersContainer) {
                    filtersContainer.classList.toggle('hidden');
                }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', initUserManagement);
</script>
@endpush
