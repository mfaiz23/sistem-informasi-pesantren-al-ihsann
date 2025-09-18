{{-- Kode Lengkap untuk edit-topics-modal.blade.php --}}
<style>[x-cloak] { display: none !important; }</style>

<div {{ $attributes->merge(['class' => 'fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50 sm:p-0']) }}
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     style="display: none;">

    {{-- Form Konten Modal --}}
    <form @click.away="$dispatch('close')"
          method="POST" :action="topicToEdit ? `/admin/faq-topics/${topicToEdit.id}` : '#'"
          class="relative w-full max-w-lg overflow-hidden bg-white rounded-lg shadow-xl sm:my-8">
        @csrf
        @method('PATCH')

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b">
            {{-- DITAMBAHKAN: Grup judul dengan ikon --}}
            <div class="flex items-center space-x-3">
                {{-- DITAMBAHKAN: Ikon di sebelah judul --}}
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-[#e6f3f2]">
                    <svg class="w-5 h-5 text-[#028579]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L15.232 5.232z"></path></svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Edit Topik FAQ</h3>
            </div>
            <button type="button" @click="$dispatch('close')" class="text-gray-400 hover:text-gray-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="p-6">
            <label for="name-edit" class="block text-sm font-medium text-gray-700">Nama Topik</label>
            <input type="text" name="name" id="name-edit" :value="topicToEdit ? topicToEdit.name : ''"
                   {{-- DIGANTI: Menyesuaikan warna tema pada focus input --}}
                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-[#028579] focus:border-[#028579] sm:text-sm"
                   required>
        </div>

        {{-- Footer --}}
        <div class="px-6 py-4 bg-gray-50 sm:flex sm:flex-row-reverse">
            {{-- DIGANTI: Menyesuaikan warna tema pada tombol simpan --}}
            <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-[#028579] border border-transparent rounded-md shadow-sm hover:bg-[#026c61] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#028579] sm:ml-3 sm:w-auto">
                Simpan Perubahan
            </button>
            {{-- DIGANTI: Menyesuaikan gaya tombol batal agar konsisten --}}
            <button @click="$dispatch('close')" type="button" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:w-auto">
                Batal
            </button>
        </div>
    </form>
</div>
