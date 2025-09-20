@props(['errors'])

<div
    {{-- State lokal: modal tertutup dan akan terbuka jika ada event atau error validasi --}}
    x-data="{
        isOpen: false,
        imagePreview: null
    }"
    x-init="() => {
        {{-- Jika ada error validasi dari form ini, modal akan otomatis terbuka kembali --}}
        if ({{ ($errors->has('judul') || $errors->has('isi') || $errors->has('gambar') || $errors->has('status')) && old('modal_source') == 'create_berita' ? 'true' : 'false' }}) {
            isOpen = true;
        }
    }"
    @open-create-berita-modal.window="isOpen = true"
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
        x-transition
        @click.outside="isOpen = false"
        {{-- DIUBAH: Lebar maksimal dikurangi dari max-w-lg menjadi max-w-md --}}
        class="w-full max-w-md bg-white rounded-lg shadow-2xl"
    >
        {{-- Header Modal --}}
        <div class="flex items-center justify-between p-5 border-b">
            <h3 class="text-xl font-semibold text-gray-800">Buat Berita Baru</h3>
            <button @click="isOpen = false" class="p-1 text-gray-500 rounded-full hover:bg-gray-200 hover:text-gray-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        {{-- Form --}}
        <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="modal_source" value="create_berita">

            <div class="p-6 space-y-6">

                {{-- Judul Berita --}}
                <div>
                    <label for="judul" class="block text-sm font-medium text-gray-700">Judul Berita</label>
                    <input type="text" name="judul" value="{{ old('judul') }}" required class="w-full px-3 py-2 mt-1 text-gray-700 bg-gray-100 border-0 rounded-md focus:ring-2 focus:ring-[#028579] focus:bg-white" placeholder="Tulis judul berita...">
                    @error('judul')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>


                <div>
                    <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar Utama</label>
                    <input type="file" name="gambar" id="gambar" required @change="imagePreview = URL.createObjectURL($event.target.files[0])" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-[#028579] hover:file:bg-gray-200">
                    @error('gambar') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                    <template x-if="imagePreview">
                        <div class="mt-4">
                            <p class="text-sm font-medium">Preview:</p>
                            <img :src="imagePreview" class="mt-2 h-48 w-auto object-cover rounded-md border">
                        </div>
                    </template>
                </div>

                <div>
                    <label for="isi" class="block text-sm font-medium text-gray-700">Isi Berita</label>
                    <textarea name="isi" rows="4" required class="w-full px-3 py-2 mt-1 text-gray-700 bg-gray-100 border-0 rounded-md focus:ring-2 focus:ring-[#028579] focus:bg-white" placeholder="Tulis konten berita lengkap di sini...">{{ old('isi') }}</textarea>
                    @error('isi')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <div class="mt-2 flex space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="status" value="draft" {{ old('status', 'draft') == 'draft' ? 'checked' : '' }} class="text-[#028579] focus:ring-[#028579]">
                            <span class="ml-2 text-sm text-gray-700">Draft</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="status" value="published" {{ old('status') == 'published' ? 'checked' : '' }} class="text-[#028579] focus:ring-[#028579]">
                            <span class="ml-2 text-sm text-gray-700">Published</span>
                        </label>
                    </div>
                    @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Footer Modal --}}
            <div class="flex items-center justify-end p-5 space-x-3 border-t bg-gray-50 rounded-b-lg">
                <button type="button" @click="isOpen = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-[#028579] rounded-lg shadow-sm hover:bg-[#026c61]">
                    Simpan Berita
                </button>
            </div>
        </form>
    </div>
</div>
