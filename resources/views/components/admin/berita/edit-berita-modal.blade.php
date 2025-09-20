<div
    x-show="editModalOpen"
    @keydown.escape.window="editModalOpen = false"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto bg-gray-800 bg-opacity-75"
>
    {{-- Panel Modal --}}
    <div
        x-show="editModalOpen"
        x-transition
        @click.outside="editModalOpen = false"
        {{-- DIUBAH 1: Ukuran dikembalikan ke `max-w-md` dan struktur flexbox ditambahkan --}}
        class="flex flex-col w-full max-w-md bg-white rounded-lg shadow-2xl"
    >
        {{-- Header Modal (Tetap) --}}
        <div class="flex-shrink-0 p-5 border-b">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-semibold text-gray-800">Edit Berita</h3>
                <button @click="editModalOpen = false" class="p-1 text-gray-500 rounded-full hover:bg-gray-200 hover:text-gray-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <template x-if="beritaToEdit">
            <form :action="`/admin/berita/${beritaToEdit.id}`" method="POST" enctype="multipart/form-data" class="flex flex-col flex-grow overflow-hidden">
                @csrf
                @method('PUT')

                {{-- DIUBAH 2: Area konten form dibuat bisa scroll secara independen --}}
                <div class="flex-grow p-6 space-y-6 overflow-y-auto" style="max-height: 70vh;">

                    {{-- Judul Berita --}}
                    <div>
                        <label for="judul_edit" class="block text-sm font-medium text-gray-700">Judul Berita</label>
                        <input type="text" name="judul" id="judul_edit" :value="beritaToEdit.judul" required class="w-full px-3 py-2 mt-1 text-gray-700 bg-gray-100 border-0 rounded-md focus:ring-2 focus:ring-[#028579] focus:bg-white">
                        @error('judul')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    {{-- Upload Gambar --}}
                    <div x-data="{ imagePreview: `/storage/${beritaToEdit.gambar}` }">
                        <label for="gambar_edit" class="block text-sm font-medium text-gray-700">Gambar Utama</label>
                        <input type="file" name="gambar" id="gambar_edit" @change="imagePreview = URL.createObjectURL($event.target.files[0])" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-[#028579] hover:file:bg-gray-200">
                        <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengganti gambar.</p>
                        @error('gambar') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                        <template x-if="imagePreview">
                            <div class="mt-4"><p class="text-sm font-medium">Preview:</p><img :src="imagePreview" class="mt-2 h-48 w-auto object-cover rounded-md border"></div>
                        </template>
                    </div>

                    {{-- Isi Berita --}}
                    <div>
                        <label for="isi_edit" class="block text-sm font-medium text-gray-700">Isi Berita</label>
                        {{-- DIUBAH 3: Menggunakan x-html, cara paling andal untuk mengisi textarea dari Alpine.js --}}
                        <textarea name="isi" id="isi_edit" rows="4" required class="w-full px-3 py-2 mt-1 text-gray-700 bg-gray-100 border-0 rounded-md focus:ring-2 focus:ring-[#028579] focus:bg-white" x-html="beritaToEdit.isi"></textarea>
                        @error('isi')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <div class="mt-2 flex space-x-4">
                            <label class="inline-flex items-center"><input type="radio" name="status" value="draft" class="text-[#028579] focus:ring-[#028579]" :checked="beritaToEdit.status == 'draft'"><span class="ml-2 text-sm text-gray-700">Draft</span></label>
                            <label class="inline-flex items-center"><input type="radio" name="status" value="published" class="text-[#028579] focus:ring-[#028579]" :checked="beritaToEdit.status == 'published'"><span class="ml-2 text-sm text-gray-700">Published</span></label>
                        </div>
                        @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Footer Modal (Tetap) --}}
                <div class="flex-shrink-0 p-5 space-x-3 border-t bg-gray-50 rounded-b-lg">
                    <div class="flex items-center justify-end">
                        <button type="button" @click="editModalOpen = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">Batal</button>
                        <button type="submit" class="px-4 py-2 ml-3 text-sm font-medium text-white bg-[#028579] rounded-lg shadow-sm hover:bg-[#026c61]">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </template>
    </div>
</div>
