{{-- Responsive Financial Dashboard --}}
<div x-data="{ modalOpen: false, selectedPayment: null, isMobile: window.innerWidth < 768 }"
     @resize.window="isMobile = window.innerWidth < 768">
    <x-admin-layout>
        {{-- Header Halaman - Mobile Optimized --}}
        <div class="flex flex-col items-start justify-between my-4 space-y-3 sm:my-6 sm:flex-row sm:items-center sm:space-y-0">
            <h2 class="text-xl font-semibold text-gray-800 sm:text-2xl">Keuangan</h2>
            <a href="#" class="w-full sm:w-auto flex items-center justify-center px-4 py-3 text-sm font-medium text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg shadow-md min-h-[48px] active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">
                <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-center">Cetak Laporan Keuangan</span>
            </a>
        </div>



        {{-- Main Content Panel - Responsive Table --}}
        <div class="p-3 bg-white rounded-lg shadow-md sm:p-6">
            <h3 class="mb-4 text-lg font-semibold text-gray-700 sm:mb-6">Data Pembayaran</h3>

            {{-- Responsive Filters --}}
            <div class="flex flex-col gap-3 mb-6 sm:flex-row sm:flex-wrap sm:items-center sm:gap-4">
                {{-- Search Input - Full width on mobile --}}
                <div class="relative flex-grow w-full sm:max-w-xs">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <input class="w-full h-12 pl-10 pr-4 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md focus:placeholder-gray-500 focus:bg-white focus:border-green-300 focus:outline-none focus:shadow-outline-green form-input"
                           type="text" placeholder="Cari invoice atau nama..."/>
                </div>

                {{-- Filter Dropdowns - Full width on mobile, inline on larger screens --}}
                <select class="w-full h-12 text-sm text-gray-700 bg-gray-100 border-0 rounded-md sm:w-auto focus:bg-white focus:border-green-300 focus:outline-none focus:shadow-outline-green form-select">
                    <option value="">Status Pembayaran</option>
                    <option value="lunas">Sudah Lunas</option>
                    <option value="pending">Menunggu Verifikasi</option>
                    <option value="unpaid">Belum Bayar</option>
                </select>

                <select class="w-full h-12 text-sm text-gray-700 bg-gray-100 border-0 rounded-md sm:w-auto focus:bg-white focus:border-green-300 focus:outline-none focus:shadow-outline-green form-select">
                    <option value="">Periode</option>
                    <option value="today">Hari Ini</option>
                    <option value="week">Minggu Ini</option>
                    <option value="month">Bulan Ini</option>
                </select>
            </div>

            {{-- Data Dummy --}}
            @php
            $pembayaran = [
                ['invoice_id' => 'INV-2025-08-001', 'name' => 'Fathan Qowiyun', 'email' => 'faqowid@example.com', 'date' => '04/08/2025', 'status' => 'Menunggu Verifikasi', 'nominal' => 5000000, 'payment_method' => 'Transfer Bank'],
                ['invoice_id' => 'INV-2025-08-002', 'name' => 'Hendy Juniawan', 'email' => 'hendy@example.com', 'date' => '04/08/2025', 'status' => 'Menunggu Pembayaran', 'nominal' => 5000000, 'payment_method' => '-'],
                ['invoice_id' => 'INV-2025-08-003', 'name' => 'Muhammad Ibadurrohman', 'email' => 'ibad@example.com', 'date' => '03/08/2025', 'status' => 'Sudah Lunas', 'nominal' => 5000000, 'payment_method' => 'Virtual Account'],
                ['invoice_id' => 'INV-2025-08-004', 'name' => 'Muhammad Faiz R', 'email' => 'faiz@example.com', 'date' => '02/08/2025', 'status' => 'Sudah Lunas', 'nominal' => 5000000, 'payment_method' => 'Transfer Bank'],
                ['invoice_id' => 'INV-2025-08-005', 'name' => 'Adila Amelia', 'email' => 'adilamella@example.com', 'date' => '01/08/2025', 'status' => 'Sudah Lunas', 'nominal' => 5500000, 'payment_method' => 'Virtual Account'],
            ];
            @endphp

            {{-- Mobile Card View (Hidden on Desktop) --}}
            <div class="space-y-4 md:hidden">
                @foreach ($pembayaran as $index => $bayar)
                <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900">{{ $bayar['name'] }}</h4>
                            <p class="text-xs text-gray-500">{{ $bayar['invoice_id'] }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-gray-900">{{ 'Rp ' . number_format($bayar['nominal'], 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500">{{ $bayar['date'] }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold
                            @if($bayar['status'] == 'Sudah Lunas') text-green-600
                            @elseif($bayar['status'] == 'Menunggu Pembayaran') text-red-600
                            @else text-yellow-600 @endif">
                            {{ $bayar['status'] }}
                        </span>

                        <div class="flex space-x-2">
                            <button @click="selectedPayment = {{ json_encode($bayar) }}; modalOpen = true"
                                    class="p-2 text-blue-600 bg-blue-100 rounded-md hover:bg-blue-200 focus:outline-none min-h-[44px] min-w-[44px]"
                                    aria-label="Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                            <button class="p-2 text-red-600 bg-red-100 rounded-md hover:bg-red-200 focus:outline-none min-h-[44px] min-w-[44px]"
                                    aria-label="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Desktop Table View (Hidden on Mobile) --}}
            <div class="hidden overflow-x-auto md:block">
                <x-admin.datatable>
                    <x-slot name="header">
                        <th class="px-4 py-3 text-xs font-semibold tracking-wide text-left text-gray-500 uppercase">No. Invoice</th>
                        <th class="px-4 py-3 text-xs font-semibold tracking-wide text-left text-gray-500 uppercase">Nama Lengkap</th>
                        <th class="px-4 py-3 text-xs font-semibold tracking-wide text-left text-gray-500 uppercase">Nominal</th>
                        <th class="px-4 py-3 text-xs font-semibold tracking-wide text-left text-gray-500 uppercase hidden lg:table-cell">Tanggal</th>
                        <th class="px-4 py-3 text-xs font-semibold tracking-wide text-left text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-xs font-semibold tracking-wide text-center text-gray-500 uppercase">Aksi</th>
                    </x-slot>

                    @foreach ($pembayaran as $bayar)
                    <tr class="text-gray-700 transition-colors duration-200 hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $bayar['invoice_id'] }}</td>
                        <td class="px-4 py-3 text-sm font-medium">{{ $bayar['name'] }}</td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-800">
                            {{ 'Rp ' . number_format($bayar['nominal'], 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-sm hidden lg:table-cell">{{ $bayar['date'] }}</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                @if($bayar['status'] == 'Sudah Lunas') text-green-700 bg-green-100
                                @elseif($bayar['status'] == 'Menunggu Pembayaran') text-red-700 bg-red-100
                                @else text-yellow-700 bg-yellow-100 @endif">
                                {{ $bayar['status'] }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex items-center justify-center space-x-2">
                                <button @click="selectedPayment = {{ json_encode($bayar) }}; modalOpen = true"
                                        class="p-2 text-gray-500 transition-colors duration-200 rounded-lg hover:bg-gray-200 hover:text-blue-600 focus:outline-none min-h-[44px] min-w-[44px]"
                                        aria-label="Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                                <button class="p-2 text-gray-500 transition-colors duration-200 rounded-lg hover:bg-gray-200 hover:text-red-600 focus:outline-none min-h-[44px] min-w-[44px]"
                                        aria-label="Hapus">
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
                    <button class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50">
                        <span class="sr-only">Previous</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <button class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-green-600">1</button>
                    <button class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50">
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
    <x-admin.keuangan-detail-modal />


</div>

@push('styles')
<style>
    /* Custom responsive adjustments */
    @media (max-width: 640px) {
        .form-input, .form-select {
            min-height: 48px;
        }

        /* Improve touch targets on mobile */
        button, a {
            min-height: 44px;
            min-width: 44px;
        }

        /* Better text scaling */
        .text-2xl {
            font-size: 1.5rem;
        }

        .text-lg {
            font-size: 1.125rem;
        }
    }

    /* Smooth transitions for responsive elements */
    .transition-all {
        transition: all 0.3s ease;
    }
</style>
@endpush

@push('scripts')
<script>
    // Mobile detection and responsive behavior
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
        handleResize(); // Initial call
    }

    document.addEventListener('DOMContentLoaded', initResponsiveTable);
</script>
@endpush
