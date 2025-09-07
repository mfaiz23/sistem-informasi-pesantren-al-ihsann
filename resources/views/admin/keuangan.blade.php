{{-- Responsive Financial Dashboard --}}
<div x-data="{ modalOpen: false, selectedPayment: null,
               isMobile: window.innerWidth < 768,
               showFilters: false }"
     @resize.window="isMobile = window.innerWidth < 768">
    <x-admin-layout>
        {{-- Header Halaman - Mobile Optimized --}}
        <div class="flex flex-col items-start justify-between my-4 space-y-3 sm:my-6 sm:flex-row sm:items-center sm:space-y-0">
            <h2 class="text-xl font-semibold text-gray-800 sm:text-2xl">Keuangan</h2>
            <a href="{{ route('admin.keuangan.cetak', request()->query()) }}" target="_blank" class="w-full sm:w-auto flex items-center justify-center px-4 py-3 text-sm font-medium text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg shadow-md min-h-[48px] active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">
                <svg class="w-4 h-4 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M5 4a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2H5zm0 2h10v6H5V6zm2 10h6v2H7v-2z" />
                </svg>
                <span class="text-center">Cetak Laporan Keuangan</span>
            </a>
        </div>

        {{-- Main Content Panel - Responsive Table --}}
        <div class="p-3 bg-white rounded-lg shadow-md sm:p-6">
            {{-- START: MODIFIED SECTION --}}
            <div class="flex flex-col items-start justify-between mb-4 space-y-3 sm:flex-row sm:items-center sm:space-y-0 sm:mb-6">
                <h3 class="text-lg font-semibold text-gray-700">Data Pembayaran</h3>
                {{-- This button will only appear on mobile screens (sm:hidden) to toggle the filters --}}
                <button @click="showFilters = !showFilters" class="flex items-center px-3 py-2 text-sm text-gray-600 border border-gray-300 rounded-md sm:hidden hover:bg-gray-50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293.707L3.293 7.707A1 1 0 013 7V4z"></path></svg>
                    Filter & Pencarian
                </button>
            </div>
            {{-- END: MODIFIED SECTION --}}


            {{-- Responsive Filters --}}
            {{-- The :class binding will conditionally hide/show this form on mobile based on the showFilters state --}}
            <form action="{{ route('admin.keuangan') }}" method="GET" class="flex flex-col gap-3 mb-6 sm:flex-row sm:flex-wrap sm:items-center sm:gap-4 transition-all duration-300" :class="{'hidden': !showFilters && isMobile, 'block': showFilters || !isMobile}">
                {{-- Search Input --}}
                <div class="relative flex-grow w-full sm:max-w-xs">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <input class="w-full h-12 pl-10 pr-4 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md focus:placeholder-gray-500 focus:bg-white focus:border-green-300 focus:outline-none focus:shadow-outline-green form-input"
                           type="text" name="search" placeholder="Cari invoice atau nama..." value="{{ request('search') }}"/>
                </div>

                {{-- Filter Dropdowns --}}
                <select name="status" onchange="this.form.submit()" class="w-full h-12 text-sm text-gray-700 bg-gray-100 border-0 rounded-md sm:w-auto focus:bg-white focus:border-green-300 focus:outline-none focus:shadow-outline-green form-select">
                    <option value="">Semua Status</option>
                    <option value="paid" @selected(request('status') == 'paid')>Sudah Lunas</option>
                    <option value="pending" @selected(request('status') == 'pending')>Menunggu Pembayaran</option>
                    <option value="expired" @selected(request('status') == 'expired')>Kadaluarsa</option>
                    <option value="failed" @selected(request('status') == 'failed')>Gagal</option>
                </select>

                <select name="periode" onchange="this.form.submit()" class="w-full h-12 text-sm text-gray-700 bg-gray-100 border-0 rounded-md sm:w-auto focus:bg-white focus:border-green-300 focus:outline-none focus:shadow-outline-green form-select">
                    <option value="">Semua Periode</option>
                    <option value="today" @selected(request('periode') == 'today')>Hari Ini</option>
                    <option value="week" @selected(request('periode') == 'week')>Minggu Ini</option>
                    <option value="month" @selected(request('periode') == 'month')>Bulan Ini</option>
                </select>

                <a href="{{ route('admin.keuangan') }}" class="flex items-center justify-center w-full px-4 text-sm font-medium text-gray-600 bg-gray-200 rounded-lg sm:w-auto h-12 hover:bg-gray-300">Reset</a>
            </form>

            {{-- Mobile Card View (Hidden on Desktop) --}}
            <div class="space-y-4 md:hidden">
                @forelse ($invoices as $invoice)
                <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900">{{ $invoice->user->name ?? 'User Dihapus' }}</h4>
                            <p class="text-xs text-gray-500">{{ $invoice->invoice_number }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-gray-900">{{ 'Rp ' . number_format($invoice->amount, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500">{{ $invoice->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                         <span class="px-2 py-1 text-xs font-semibold rounded-full capitalize
                            @if($invoice->status == 'paid') text-green-700 bg-green-100
                            @elseif($invoice->status == 'pending') text-yellow-700 bg-yellow-100
                            @else text-red-700 bg-red-100 @endif">
                            {{ $invoice->status }}
                        </span>

                        <div class="flex space-x-2">
                            <button @click="selectedPayment = {{ json_encode($invoice) }}; modalOpen = true"
                                    class="p-2 text-blue-600 bg-blue-100 rounded-md hover:bg-blue-200 focus:outline-none min-h-[44px] min-w-[44px]"
                                    aria-label="Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                            {{-- <button class="p-2 text-red-600 bg-red-100 rounded-md hover:bg-red-200 focus:outline-none min-h-[44px] min-w-[44px]"
                                    aria-label="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button> --}}
                        </div>
                    </div>
                </div>
                @empty
                    <p class="text-center text-gray-500">Tidak ada data pembayaran yang ditemukan.</p>
                @endforelse
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

                    @forelse ($invoices as $invoice)
                    <tr class="text-gray-700 transition-colors duration-200 hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $invoice->invoice_number }}</td>
                        <td class="px-4 py-3 text-sm font-medium">{{ $invoice->user->name ?? 'User Dihapus' }}</td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-800">
                            {{ 'Rp ' . number_format($invoice->amount, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-sm hidden lg:table-cell">{{ $invoice->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full capitalize
                                @if($invoice->status == 'paid') text-green-700 bg-green-100
                                @elseif($invoice->status == 'pending') text-yellow-700 bg-yellow-100
                                @else text-red-700 bg-red-100 @endif">
                                {{ $invoice->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex items-center justify-center space-x-2">
                                <button @click="selectedPayment = {{ json_encode($invoice) }}; modalOpen = true"
                                        class="p-2 text-gray-500 transition-colors duration-200 rounded-lg hover:bg-gray-200 hover:text-blue-600 focus:outline-none min-h-[44px] min-w-[44px]"
                                        aria-label="Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                                {{-- <button class="p-2 text-gray-500 transition-colors duration-200 rounded-lg hover:bg-gray-200 hover:text-red-600 focus:outline-none min-h-[44px] min-w-[44px]"
                                        aria-label="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button> --}}
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-gray-500">
                            Tidak ada data pembayaran yang ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </x-admin.datatable>
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $invoices->withQueryString()->links() }}
            </div>
        </div>

        <x-admin.footer />
    </x-admin-layout>

    {{-- Modal Component --}}
    <x-admin.keuangan.keuangan-detail-modal />

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
