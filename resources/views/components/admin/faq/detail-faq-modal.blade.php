{{-- File: resources/views/components/admin/faq/detail-faq-modal.blade.php --}}

<div
    {{-- State lokal: modal tertutup secara default dan objek 'faq' kosong --}}
    x-data="{ isOpen: false, faq: null }"
    {{-- Mendengarkan event global 'open-detail-modal' --}}
    {{-- Saat event diterima, buka modal dan isi data 'faq' dari detail event --}}
    @open-detail-modal.window="isOpen = true; faq = $event.detail"
    @keydown.escape.window="isOpen = false"
    x-show="isOpen"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto bg-gray-800 bg-opacity-75"
>
    {{-- Panel Modal --}}
    <div
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        @click.outside="isOpen = false"
        class="w-full max-w-2xl bg-white rounded-lg shadow-2xl"
    >
        {{-- Header Modal --}}
        <div class="flex items-center justify-between p-5 border-b">
            <h3 class="text-xl font-semibold text-gray-800">Detail Pertanyaan (FAQ)</h3>
            <button @click="isOpen = false" class="p-1 text-gray-500 rounded-full hover:bg-gray-200 hover:text-gray-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        {{-- Konten Detail --}}
        <div class="p-6 space-y-5" x-if="faq">

            {{-- Tampilan Topik dengan Badge --}}
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-2">Topik</label>
                <div>
                    {{-- Badge ini akan tampil JIKA faq.topic ADA --}}
                    <span x-show="faq.topic"
                          x-text="faq.topic ? faq.topic.name : ''"
                          class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-teal-100 text-teal-800 shadow-sm">
                    </span>

                    {{-- Badge ini akan tampil JIKA faq.topic TIDAK ADA (null) --}}
                    <span x-show="!faq.topic"
                          class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 shadow-sm">
                          Tidak Dikategorikan
                    </span>
                </div>
            </div>

            {{-- Tampilan Pertanyaan --}}
           <div>
                <label class="block text-sm font-medium text-gray-500">Pertanyaan</label>
                <div class="p-4 mt-1 text-base font-semibold text-gray-900 bg-gray-50 border border-gray-200 rounded-md" x-text="faq.pertanyaan"></div>
            </div>

            {{-- Tampilan Jawaban --}}
            <div>
                <label class="block text-sm font-medium text-gray-500">Jawaban</label>
                <div class="p-4 mt-1 text-base text-gray-800 bg-gray-50 border border-gray-200 rounded-md prose max-w-none" x-html="faq.jawaban"></div>
            </div>

            {{-- Tampilan Informasi Tambahan (Tanggal) --}}
            <div class="pt-4 border-t border-gray-200">
                <label class="block text-sm font-medium text-gray-500">Informasi Tambahan</label>
                <div class="grid grid-cols-1 gap-2 mt-2 text-sm text-gray-700 sm:grid-cols-2">
                    <p><strong>Dibuat pada:</strong> <span x-text="new Date(faq.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' })"></span></p>
                    <p><strong>Diperbarui:</strong> <span x-text="new Date(faq.updated_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' })"></span></p>
                </div>
            </div>
        </div>

        {{-- Footer Modal --}}
        <div class="flex items-center justify-end p-5 border-t bg-gray-50 rounded-b-lg">
            <button type="button" @click="isOpen = false" class="px-5 py-2 text-sm font-medium text-white bg-[#028579] rounded-lg shadow-sm hover:bg-[#026c61] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#028579]">
                Tutup
            </button>
        </div>
    </div>
</div>
