{{-- Responsive Financial Dashboard --}}
<div x-data="{ modalOpen: false, selectedPayment: null,
               isMobile: window.innerWidth < 768,
               showFilters: false }"
     @resize.window="isMobile = window.innerWidth < 768">
    <x-admin-layout>
        {{-- Header Halaman - Mobile Optimized --}}
        <div class="flex flex-col items-start justify-between my-4 space-y-3 sm:my-6 sm:flex-row sm:items-center sm:space-y-0">
            <h2 class="text-xl font-semibold text-gray-800 sm:text-2xl">Keuangan</h2>
            <a href="{{ route('admin.keuangan.cetak', request()->query()) }}" target="_blank" class="w-full sm:w-auto flex items-center justify-center px-4 py-3 text-sm font-medium text-white transition-colors duration-150 bg-[#028579] hover:bg-[#016a60] border border-transparent rounded-lg shadow-md min-h-[48px] active:bg-green-600 focus:outline-none focus:shadow-outline-green">
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
            {{-- keuangan.blade.php --}}
            <form action="{{ route('admin.keuangan') }}" method="GET">
                <div class="flex flex-col gap-3 md:flex-row md:items-center md:gap-4">
                    {{-- DIUBAH: kelas 'flex-grow' dihapus dan diganti 'md:w-64' --}}
                    <div class="relative md:w-64">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input name="search" value="{{ request('search') }}" class="w-full py-2.5 pl-10 pr-4 text-sm text-gray-800 placeholder-gray-500 bg-gray-100 border-transparent rounded-lg focus:ring-2 focus:ring-[#028579] focus:border-transparent" type="text" placeholder="Cari invoice atau nama..."/>
                    </div>
                    {{-- ... sisa dropdown dan tombol reset tetap sama ... --}}
                    <div class="relative md:w-52">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </span>
                        <select name="status" onchange="this.form.submit()" class="w-full py-2.5 pl-10 pr-8 text-sm text-gray-800 bg-gray-100 border-transparent rounded-lg appearance-none focus:ring-2 focus:ring-[#028579] focus:border-transparent">
                            <option value="">Semua Status</option>
                            <option value="paid" @selected(request('status') == 'paid')>Sudah Lunas</option>
                            <option value="pending" @selected(request('status') == 'pending')>Menunggu Pembayaran</option>
                            <option value="expired" @selected(request('status') == 'expired')>Kadaluarsa</option>
                            <option value="failed" @selected(request('status') == 'failed')>Gagal</option>
                        </select>
                    </div>
                    <div class="relative md:w-52">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </span>
                        <select name="periode" onchange="this.form.submit()" class="w-full py-2.5 pl-10 pr-8 text-sm text-gray-800 bg-gray-100 border-transparent rounded-lg appearance-none focus:ring-2 focus:ring-[#028579] focus:border-transparent">
                            <option value="">Semua Periode</option>
                            <option value="today" @selected(request('periode') == 'today')>Hari Ini</option>
                            <option value="week" @selected(request('periode') == 'week')>Minggu Ini</option>
                            <option value="month" @selected(request('periode') == 'month')>Bulan Ini</option>
                        </select>
                    </div>
                    <a href="{{ route('admin.keuangan') }}" class="flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg md:w-auto hover:bg-gray-100 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h5M20 20v-5h-5"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 9a9 9 0 0114.13-5.12M20 15a9 9 0 01-14.13 5.12"></path></svg>
                        Reset
                    </a>
                </div>
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
                            <button @click="selectedPayment = {{ json_encode($invoice) }}; modalOpen = true" title="Lihat Detail"
                                    class="p-2 text-blue-600 bg-blue-100 rounded-md hover:bg-blue-200 focus:outline-none min-h-[44px] min-w-[44px]"
                                    aria-label="Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
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
                                <button @click="selectedPayment = {{ json_encode($invoice) }}; modalOpen = true" title="Lihat Detail"
                                        class="p-2 text-gray-500 transition-colors duration-200 rounded-lg hover:bg-gray-200 hover:text-blue-600 focus:outline-none min-h-[44px] min-w-[44px]"
                                        aria-label="Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
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
