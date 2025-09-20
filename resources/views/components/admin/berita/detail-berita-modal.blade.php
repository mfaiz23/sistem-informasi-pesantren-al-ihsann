<div
    x-data="{ isOpen: false, berita: null }"
    @open-detail-berita-modal.window="isOpen = true; berita = $event.detail"
    @keydown.escape.window="isOpen = false"
    x-show="isOpen"
    x-cloak
    class="fixed inset-0 z-50 flex items-start justify-center p-4 overflow-y-auto bg-gray-800 bg-opacity-75 pt-14"
>
    <div
        x-show="isOpen"
        x-transition
        @click.outside="isOpen = false"
        class="w-full max-w-3xl bg-white rounded-lg shadow-2xl"
    >
        <div class="flex items-center justify-between p-5 border-b">
            <h3 class="text-xl font-semibold text-gray-800">Detail Berita</h3>
            <button @click="isOpen = false" class="p-1 text-gray-500 rounded-full hover:bg-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="p-6 space-y-5" x-if="berita">
            <img :src="`/storage/${berita.gambar}`" :alt="berita.judul" class="object-cover w-full h-64 rounded-lg">

            <h2 class="text-2xl font-bold text-gray-900" x-text="berita.judul"></h2>

            <div class="flex items-center space-x-4 text-sm text-gray-500">
                <span>Penulis: <strong class="text-gray-700" x-text="berita.user ? berita.user.name : 'N/A'"></strong></span>
                <span>&bull;</span>
                <span>Dibuat: <strong class="text-gray-700" x-text="new Date(berita.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })"></strong></span>
                <span>&bull;</span>
                <div>
                    <span>Status: </span>
                    <span :class="{
                        'bg-green-100 text-green-800': berita.status == 'published',
                        'bg-yellow-100 text-yellow-800': berita.status == 'draft'
                    }" class="px-2 py-1 text-xs font-semibold rounded-full" x-text="berita.status.charAt(0).toUpperCase() + berita.status.slice(1)">
                    </span>
                </div>
            </div>

            <div class="prose max-w-none prose-indigo" x-html="berita.isi"></div>
        </div>

        <div class="flex items-center justify-end p-5 border-t bg-gray-50 rounded-b-lg">
            <button type="button" @click="isOpen = false" class="px-5 py-2 text-sm font-medium text-white bg-[#028579] rounded-lg shadow-sm hover:bg-[#026c61]">
                Tutup
            </button>
        </div>
    </div>
</div>
