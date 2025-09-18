<div
    x-show="deleteModalOpen"
    class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75"
    x-cloak
>
    <div
        x-show="deleteModalOpen"
        x-transition
        @click.outside="deleteModalOpen = false"
        class="w-full max-w-md p-6 bg-white rounded-lg shadow-2xl"
    >
        <div class="text-center">
            {{-- Ikon Peringatan --}}
            <svg class="w-16 h-16 mx-auto text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>

            {{-- Judul Konfirmasi --}}
            <h3 class="mt-4 text-xl font-semibold text-gray-900">Konfirmasi Penghapusan</h3>

            {{-- Pesan Konfirmasi --}}
            <div class="mt-2 text-gray-600">
                <p>
                    Apakah Anda yakin ingin menghapus pertanyaan ini?
                </p>
                {{-- Menampilkan kutipan pertanyaan yang akan dihapus --}}
                <p x-text="faqToDelete ? `&ldquo;${faqToDelete.pertanyaan.substring(0, 100)}...&rdquo;` : ''" class="mt-2 text-sm italic font-medium text-gray-800 bg-gray-100 rounded-md p-2"></p>
                <p class="mt-3 text-sm">
                    Tindakan ini **tidak dapat dibatalkan**.
                </p>
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="mt-6 flex justify-center space-x-4">
            {{-- Tombol Batal --}}
            <button @click="deleteModalOpen = false; faqToDelete = null"
                class="w-full px-4 py-2.5 font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 sm:w-auto">
                Batal
            </button>

            {{-- Form Hapus --}}
            <form x-show="faqToDelete" :action="faqToDelete ? `{{ url('admin/faq') }}/${faqToDelete.id}` : ''" method="POST" class="w-full sm:w-auto">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full inline-flex justify-center px-4 py-2.5 font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>
