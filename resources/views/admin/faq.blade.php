<x-admin-layout>
    {{-- DIUBAH: State modal (createModalOpen) dan x-init dihapus dari sini agar tidak konflik. --}}
    {{-- Modal akan mengelola dirinya sendiri. --}}
    <div x-data="{
            detailModalOpen: false,
            editModalOpen: false,
            deleteModalOpen: false,
            selectedFaq: null,
            faqToEdit: null,
            faqToDelete: null,
            isMobile: window.innerWidth < 768,
            showFilters: false
         }"
         @resize.window="isMobile = window.innerWidth < 768">

        {{-- Header: Judul Halaman --}}
        <div class="flex flex-col items-start justify-between my-4 space-y-3 sm:my-6 sm:flex-row sm:items-center sm:space-y-0">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 sm:text-2xl">Manajemen FAQ</h2>
                <p class="mt-1 text-sm text-gray-600">Kelola pertanyaan dan jawaban yang sering diajukan.</p>
            </div>
            <div>
                {{-- DIUBAH: Tombol ini sekarang mengirim event global 'open-create-modal' --}}
                <button @click="$dispatch('open-create-modal')" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-[#028579] rounded-lg shadow-sm hover:bg-[#026c61] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#028579]">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah FAQ Baru
                </button>
            </div>
        </div>

        {{-- Panel Konten Utama --}}
        <div class="p-3 bg-white rounded-lg shadow-md sm:p-6">
            <div class="flex flex-col items-start justify-between mb-4 space-y-3 sm:flex-row sm:items-center sm:space-y-0 sm:mb-6">
                <h3 class="text-lg font-semibold text-gray-700">Data Pertanyaan (FAQ)</h3>
                <button @click="showFilters = !showFilters" class="flex items-center px-3 py-2 text-sm text-gray-600 border border-gray-300 rounded-md sm:hidden hover:bg-gray-50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293.707L3.293 7.707A1 1 0 013 7V4z"></path></svg>
                    Filter & Pencarian
                </button>
            </div>

            {{-- Form filter dan pencarian --}}
            <div class="mb-6 transition-all duration-300" :class="{'hidden': !showFilters && isMobile, 'block': showFilters || !isMobile}">
                    <form id="filter-faq-form" action="{{ route('admin.faq.index') }}" method="GET">
                        {{-- Menggunakan Flexbox untuk layout yang rapat ke kiri dan responsif --}}
                        <div class="flex flex-col gap-3 md:flex-row md:items-center md:gap-4">

                            {{-- Input Pencarian (dengan lebar tetap) --}}
                            <div class="relative md:w-64">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                                <input id="search-faq-input" name="search" value="{{ request('search') }}" class="w-full py-2.5 pl-10 pr-4 text-sm text-gray-800 placeholder-gray-500 bg-gray-100 border-transparent rounded-lg focus:ring-2 focus:ring-[#028579] focus:border-transparent" type="text" placeholder="Cari pertanyaan..."/>
                            </div>

                            {{-- Dropdown Topik (dengan ikon) --}}
                            <div class="relative md:w-52">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5a2 2 0 012 2v5a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2zm0 14h.01M7 17h5a2 2 0 012 2v5a2 2 0 01-2 2H7a2 2 0 01-2-2v-5a2 2 0 012-2zm10-14h.01M17 3h5a2 2 0 012 2v5a2 2 0 01-2 2h-5a2 2 0 01-2-2V5a2 2 0 012-2zm0 14h.01M17 17h5a2 2 0 012 2v5a2 2 0 01-2 2h-5a2 2 0 01-2-2v-5a2 2 0 012-2z"></path></svg>
                                </span>
                                <select name="topic" onchange="this.form.submit()" class="w-full py-2.5 pl-10 pr-8 text-sm text-gray-800 bg-gray-100 border-transparent rounded-lg appearance-none focus:ring-2 focus:ring-[#028579] focus:border-transparent">
                                    <option value="">Semua Topik</option>
                                    @foreach($topics as $topic)
                                        <option value="{{ $topic->id }}" {{ request('topic') == $topic->id ? 'selected' : '' }}>{{ $topic->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Dropdown Urutkan (dengan ikon) --}}
                            <div class="relative md:w-52">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9M3 12h9m-9 4h13m0-4l3 3m0 0l3-3m-3 3v-6"></path></svg>
                                </span>
                                <select name="sort" onchange="this.form.submit()" class="w-full py-2.5 pl-10 pr-8 text-sm text-gray-800 bg-gray-100 border-transparent rounded-lg appearance-none focus:ring-2 focus:ring-[#028579] focus:border-transparent">
                                    <option value="date_desc" {{ request('sort', 'date_desc') == 'date_desc' ? 'selected' : '' }}>Terbaru</option>
                                    <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Terlama</option>
                                    <option value="question_asc" {{ request('sort') == 'question_asc' ? 'selected' : '' }}>Pertanyaan (A-Z)</option>
                                    <option value="question_desc" {{ request('sort') == 'question_desc' ? 'selected' : '' }}>Pertanyaan (Z-A)</option>
                                </select>
                            </div>

                            {{-- Tombol Reset (desain baru) --}}
                            <a href="{{ route('admin.faq.index') }}" class="flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg md:w-auto hover:bg-gray-100 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h5M20 20v-5h-5"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 9a9 9 0 0114.13-5.12M20 15a9 9 0 01-14.13 5.12"></path></svg>
                                Reset
                            </a>
                        </div>
                    </form>
                </div>

            {{-- DITAMBAHKAN: Blok untuk menampilkan notifikasi sukses/error --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                     class="px-4 py-3 mb-4 text-sm text-green-700 bg-green-100 border border-green-400 rounded-lg" role="alert">
                    <p class="font-bold">Sukses!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if ($errors->any())
                <div class="px-4 py-3 mb-4 text-sm text-red-700 bg-red-100 border border-red-400 rounded-lg" role="alert">
                    <p class="font-bold">Terjadi Kesalahan!</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>- {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Tampilan Kartu Mobile (Kode Anda dipertahankan) --}}
            <div class="space-y-4 md:hidden">
                @forelse ($faqs as $faq)
                    <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-gray-900">{{ $faq->pertanyaan }}</h4>
                                <p class="text-xs text-gray-500 mt-1">
                                    <span class="font-medium">Topik:</span> {{ $faq->topic->name ?? 'N/A' }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                            <p class="text-xs text-gray-500">Dibuat: {{ $faq->created_at->isoFormat('D MMM YYYY') }}</p>
                            <div class="flex space-x-2">
                                <button @click="$dispatch('open-detail-modal', {{ json_encode($faq) }})" class="p-2 text-blue-600 bg-blue-100 rounded-md hover:bg-blue-200 focus:outline-none" title="Lihat Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                                <button @click="faqToEdit = {{ json_encode($faq) }}; editModalOpen = true" class="p-2 text-yellow-600 bg-yellow-100 rounded-md hover:bg-yellow-200 focus:outline-none" title="Edit FAQ">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L16.732 3.732z"></path></svg>
                                </button>
                                <button @click="faqToDelete = {{ json_encode($faq) }}; deleteModalOpen = true" class="p-2 text-red-600 bg-red-100 rounded-md hover:bg-red-200 focus:outline-none" title="Hapus FAQ">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-gray-500">Tidak ada data FAQ yang ditemukan.</div>
                @endforelse
            </div>

            {{-- Tampilan Tabel Desktop (Kode Anda dipertahankan) --}}
            <div class="hidden overflow-x-auto md:block">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-xs font-semibold tracking-wide text-left text-gray-500 uppercase">Pertanyaan</th>
                            <th scope="col" class="px-4 py-3 text-xs font-semibold tracking-wide text-left text-gray-500 uppercase">Topik</th>
                            <th scope="col" class="px-4 py-3 text-xs font-semibold tracking-wide text-left text-gray-500 uppercase">Tanggal Dibuat</th>
                            <th scope="col" class="px-4 py-3 text-xs font-semibold tracking-wide text-center text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($faqs as $faq)
                            <tr class="text-gray-700 transition-colors duration-200 hover:bg-gray-50">
                                <td class="w-2/5 px-4 py-3 text-sm font-medium text-gray-900">{{ Str::limit($faq->pertanyaan, 70) }}</td>
                                <td class="px-4 py-3 text-sm whitespace-nowrap">{{ $faq->topic->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm whitespace-nowrap">{{ $faq->created_at->isoFormat('D MMMM YYYY') }}</td>
                                <td class="px-4 py-3 text-sm whitespace-nowrap">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button @click="$dispatch('open-detail-modal', {{ json_encode($faq) }})" title="Lihat Detail" class="p-2 text-gray-500 rounded-lg hover:bg-gray-200 hover:text-blue-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                        <button @click="faqToEdit = {{ json_encode($faq) }}; editModalOpen = true" title="Edit FAQ" class="p-2 text-gray-500 rounded-lg hover:bg-gray-200 hover:text-yellow-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L16.732 3.732z"></path></svg>
                                        </button>
                                        <button @click="faqToDelete = {{ json_encode($faq) }}; deleteModalOpen = true" title="Hapus FAQ" class="p-2 text-gray-500 rounded-lg hover:bg-gray-200 hover:text-red-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-3 text-center text-gray-500">Tidak ada data FAQ yang ditemukan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginasi --}}
            <div class="mt-6">{{ $faqs->appends(request()->query())->links() }}</div>
        </div>

        <x-admin.faq.create-faq-modal :topics="$topics" x-cloak/>
        <x-admin.faq.detail-faq-modal x-cloak/>
        <x-admin.faq.edit-faq-modal :topics="$topics" x-cloak/>
        <x-admin.faq.delete-faq-modal x-cloak/>


        <x-admin.footer />
    </div>
</x-admin-layout>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search-faq-input');
        const filterForm = document.getElementById('filter-faq-form');
        if (!searchInput || !filterForm) return;

        let typingTimer;
        const doneTypingInterval = 500; // 0.5 detik

        searchInput.addEventListener('keyup', () => {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => filterForm.submit(), doneTypingInterval);
        });

        searchInput.addEventListener('keydown', () => clearTimeout(typingTimer));
    });
</script>
@endpush
