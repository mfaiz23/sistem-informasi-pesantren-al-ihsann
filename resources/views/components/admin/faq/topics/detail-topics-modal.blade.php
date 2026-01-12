{{-- Kode Lengkap untuk detail-topics-modal.blade.php --}}
<style>[x-cloak] { display: none !important; }</style>

<div {{ $attributes->merge(['class' => 'fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50 sm:p-0']) }}
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     style="display: none;">

    {{-- Konten Modal --}}
    <div @click.away="$dispatch('close')"
         class="relative w-full max-w-lg overflow-hidden bg-white rounded-lg shadow-xl sm:my-8">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b">
            {{-- DITAMBAHKAN: Grup judul dengan ikon --}}
            <div class="flex items-center space-x-3">
                {{-- DITAMBAHKAN: Ikon di sebelah judul --}}
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-[#e6f3f2]">
                    <svg class="w-5 h-5 text-[#028579]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Detail Topik FAQ</h3>
            </div>
            <button @click="$dispatch('close')" class="text-gray-400 hover:text-gray-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        {{-- Body --}}
        {{-- DIPERBARUI: Mengubah tata letak body agar lebih rapi --}}
        <div class="p-6">
            <div class="space-y-3">
                <div class="flex items-center justify-between py-2 border-b">
                    <h4 class="text-sm font-medium text-gray-500">Nama Topik</h4>
                    <p class="text-sm font-semibold text-gray-800" x-text="selectedTopic ? selectedTopic.name : ''"></p>
                </div>
                <div class="flex items-center justify-between py-2 border-b">
                    <h4 class="text-sm font-medium text-gray-500">Jumlah Pertanyaan</h4>
                    <p class="text-sm font-semibold text-gray-800" x-text="selectedTopic ? selectedTopic.faqs_count : '0'"></p>
                </div>
                <div class="flex items-center justify-between py-2">
                    <h4 class="text-sm font-medium text-gray-500">Tanggal Dibuat</h4>
                    <p class="text-sm font-semibold text-gray-800" x-text="selectedTopic ? new Date(selectedTopic.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : ''"></p>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="px-6 py-4 bg-gray-50 sm:flex sm:flex-row-reverse">
             {{-- DIGANTI: Menyesuaikan gaya tombol tutup agar konsisten --}}
            <button @click="$dispatch('close')" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                Tutup
            </button>
        </div>
    </div>
</div>
