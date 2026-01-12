<x-admin-layout>
    {{-- State Management dengan Alpine.js untuk semua modal --}}
    <div x-data="{
            isMobile: window.innerWidth < 768,
            showFilters: false,

            // State untuk modal
            editModalOpen: false,
            deleteModalOpen: false,

            // Data yang akan dikirim ke modal
            beritaToEdit: null,
            beritaToDelete: null
         }"
         @resize.window="isMobile = window.innerWidth < 768">

        {{-- Header: Judul Halaman & Tombol Aksi --}}
        <div class="flex flex-col items-start justify-between my-4 space-y-3 sm:my-6 sm:flex-row sm:items-center sm:space-y-0">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 sm:text-2xl">Manajemen Berita</h2>
                <p class="mt-1 text-sm text-gray-600">Kelola artikel berita dan publikasi untuk ditampilkan di halaman depan.</p>
            </div>
            <div>
                {{-- Tombol ini mengirim event untuk membuka modal create --}}
                <button @click="$dispatch('open-create-berita-modal')" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-[#028579] rounded-lg shadow-sm hover:bg-[#026c61] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#028579]">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Berita Baru
                </button>
            </div>
        </div>

        {{-- Panel Konten Utama --}}
        <div class="p-3 bg-white rounded-lg shadow-md sm:p-6 overflow-x-auto">
            <div class="flex flex-col items-start justify-between mb-4 space-y-3 sm:flex-row sm:items-center sm:space-y-0 sm:mb-6">
                <h3 class="text-lg font-semibold text-gray-700">Data Berita</h3>
                <button @click="showFilters = !showFilters" class="flex items-center px-3 py-2 text-sm text-gray-600 border border-gray-300 rounded-md sm:hidden hover:bg-gray-50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z"></path></svg>
                    Filter & Pencarian
                </button>
            </div>

            {{-- Form filter dan pencarian --}}
            <div class="mb-6 transition-all duration-300" :class="{'hidden': !showFilters && isMobile, 'block': showFilters || !isMobile}">
                <form id="filter-berita-form" action="{{ route('admin.berita.index') }}" method="GET">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:gap-4">
                        <div class="relative md:w-64">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </span>
                            <input id="search-berita-input" name="search" value="{{ request('search') }}" class="w-full py-2.5 pl-10 pr-4 text-sm text-gray-800 placeholder-gray-500 bg-gray-100 border-transparent rounded-lg focus:ring-2 focus:ring-[#028579] focus:border-transparent" type="text" placeholder="Cari judul berita..."/>
                        </div>
                        <div class="relative md:w-52">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                            <select name="status" onchange="this.form.submit()" class="w-full py-2.5 pl-10 pr-8 text-sm text-gray-800 bg-gray-100 border-transparent rounded-lg appearance-none focus:ring-2 focus:ring-[#028579] focus:border-transparent">
                                <option value="">Semua Status</option>
                                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                        <a href="{{ route('admin.berita.index') }}" class="flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg md:w-auto hover:bg-gray-100 hover:text-gray-800">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h5M20 20v-5h-5"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 9a9 9 0 0114.13-5.12M20 15a9 9 0 01-14.13 5.12"></path></svg>
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- Notifikasi --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="px-4 py-3 mb-4 text-sm text-green-700 bg-green-100 border border-green-400 rounded-lg" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if (session('error'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)" class="px-4 py-3 mb-4 text-sm text-red-700 bg-red-100 border border-red-400 rounded-lg" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            {{-- Tampilan Kartu Mobile --}}
            <div class="space-y-4 md:hidden">
                @forelse ($beritas as $item)
                    <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <div class="flex items-start space-x-4">
                            <img src="{{ asset('storage/'. $item->gambar) }}" alt="{{ $item->judul }}" class="w-20 h-20 object-cover rounded-md flex-shrink-0">
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-gray-900">{{ $item->judul }}</h4>
                                <p class="text-xs text-gray-500 mt-1">Oleh: {{ $item->user->name ?? 'N/A' }}</p>
                                <div class="mt-2">
                                    <form action="{{ route('admin.berita.updateStatus', $item) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="{{ $item->status == 'published' ? 'draft' : 'published' }}">
                                        <div class="flex items-center space-x-2">
                                            <button type="button" onclick="this.closest('form').submit()" role="switch" aria-checked="{{ $item->status == 'published' ? 'true' : 'false' }}"
                                                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-[#028579] focus:ring-offset-2 {{ $item->status == 'published' ? 'bg-[#028579] border-transparent hover:bg-[#026c61]' : 'bg-gray-200 border-gray-300 hover:border-gray-400' }}">
                                                <span class="sr-only">Ubah Status</span>
                                                <span aria-hidden="true" class="{{ $item->status == 'published' ? 'translate-x-5' : 'translate-x-0' }} pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                            </button>
                                            <label class="text-xs font-medium {{ $item->status == 'published' ? 'text-green-700' : 'text-gray-500' }}">{{ ucfirst($item->status) }}</label>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-3 mt-3 border-t border-gray-200">
                            <p class="text-xs text-gray-500">{{ $item->created_at->isoFormat('D MMM YYYY') }}</p>
                            <div class="flex items-center justify-center space-x-2">
                                <button @click="$dispatch('open-detail-berita-modal', {{ json_encode($item) }})" title="Lihat Detail" class="p-2 text-blue-600 bg-blue-100 rounded-md hover:bg-blue-200"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></button>
                                <button @click="beritaToEdit = {{ json_encode($item) }}; editModalOpen = true" title="Edit Berita" class="p-2 text-yellow-600 bg-yellow-100 rounded-md hover:bg-yellow-200"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L16.732 3.732z"></path></svg></button>
                                <button @click="beritaToDelete = {{ json_encode($item) }}; deleteModalOpen = true" title="Hapus Berita" class="p-2 text-red-600 bg-red-100 rounded-md hover:bg-red-200"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-gray-500">Tidak ada data berita yang ditemukan.</div>
                @endforelse
            </div>

            {{-- Tampilan Tabel Desktop --}}
            <div class="hidden overflow-x-auto md:block">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-xs font-semibold tracking-wide text-left text-gray-500 uppercase">Gambar</th>
                            <th class="px-4 py-3 text-xs font-semibold tracking-wide text-left text-gray-500 uppercase">Judul</th>
                            <th class="px-4 py-3 text-xs font-semibold tracking-wide text-left text-gray-500 uppercase">Penulis</th>
                            <th class="px-4 py-3 text-xs font-semibold tracking-wide text-left text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-xs font-semibold tracking-wide text-left text-gray-500 uppercase">Tanggal Dibuat</th>
                            <th class="px-4 py-3 text-xs font-semibold tracking-wide text-center text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($beritas as $item)
                            <tr class="text-gray-700 transition-colors duration-200 hover:bg-gray-50">
                                <td class="px-4 py-3"><img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="h-16 w-24 object-cover rounded-md"></td>
                                <td class="w-2/5 px-4 py-3 text-sm font-medium text-gray-900">{{ Str::limit($item->judul, 70) }}</td>
                                <td class="px-4 py-3 text-sm whitespace-nowrap">{{ $item->user->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm whitespace-nowrap">
                                    <form action="{{ route('admin.berita.updateStatus', $item) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="{{ $item->status == 'published' ? 'draft' : 'published' }}">
                                        <div class="flex items-center space-x-2">
                                            <button type="button" onclick="this.closest('form').submit()" role="switch" aria-checked="{{ $item->status == 'published' ? 'true' : 'false' }}"
                                                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-[#028579] focus:ring-offset-2 {{ $item->status == 'published' ? 'bg-[#028579] border-transparent hover:bg-[#026c61]' : 'bg-gray-200 border-gray-300 hover:border-gray-400' }}">
                                                <span class="sr-only">Ubah Status</span>
                                                <span aria-hidden="true" class="{{ $item->status == 'published' ? 'translate-x-5' : 'translate-x-0' }} pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                            </button>
                                            <label class="text-sm font-medium {{ $item->status == 'published' ? 'text-green-700' : 'text-gray-500' }}">{{ ucfirst($item->status) }}</label>
                                        </div>
                                    </form>
                                </td>
                                <td class="px-4 py-3 text-sm whitespace-nowrap">{{ $item->created_at->isoFormat('D MMMM YYYY') }}</td>
                                <td class="px-4 py-3 text-sm whitespace-nowrap">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button @click="$dispatch('open-detail-berita-modal', {{ json_encode($item) }})" title="Lihat Detail" class="p-2 text-gray-500 rounded-lg hover:bg-gray-200 hover:text-blue-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></button>
                                        <button @click="beritaToEdit = {{ json_encode($item) }}; editModalOpen = true" title="Edit Berita" class="p-2 text-gray-500 rounded-lg hover:bg-gray-200 hover:text-yellow-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L16.732 3.732z"></path></svg></button>
                                        <button @click="beritaToDelete = {{ json_encode($item) }}; deleteModalOpen = true" title="Hapus Berita" class="p-2 text-gray-500 rounded-lg hover:bg-gray-200 hover:text-red-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-3 text-center text-gray-500">Tidak ada data berita ditemukan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginasi --}}
            <div class="mt-6">{{ $beritas->appends(request()->query())->links() }}</div>
        </div>

        {{-- Panggil Semua Komponen Modal Berita Di Sini --}}
        <x-admin.berita.create-berita-modal :errors="$errors" x-cloak />
        <x-admin.berita.detail-berita-modal x-cloak />
        <x-admin.berita.edit-berita-modal x-cloak />
        <x-admin.berita.delete-berita-modal x-cloak />

        <x-admin.footer />
    </div>
</x-admin-layout>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search-berita-input');
        const filterForm = document.getElementById('filter-berita-form');
        if (!searchInput || !filterForm) return;
        let typingTimer;
        const doneTypingInterval = 500;
        searchInput.addEventListener('keyup', () => {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => filterForm.submit(), doneTypingInterval);
        });
        searchInput.addEventListener('keydown', () => clearTimeout(typingTimer));
    });
</script>
@endpush
