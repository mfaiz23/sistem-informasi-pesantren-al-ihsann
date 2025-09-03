<div x-show="deleteModalOpen"
    class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-50"
    x-cloak>
    <div class="bg-white rounded-lg p-6 shadow-xl max-w-sm w-full">
        <div class="text-center">
            <svg class="mx-auto h-12 w-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <h3 class="mt-2 text-lg font-medium text-gray-900">Konfirmasi Penghapusan</h3>
            <div class="mt-2">
                <p class="text-sm text-gray-500">
                    Apakah Anda yakin ingin menghapus data santri <span x-text="santriToDelete ? santriToDelete.nama_panggilan : ''" class="font-semibold"></span>? Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
        </div>
        <div class="mt-4 flex justify-center space-x-3">
            <button @click="deleteModalOpen = false; santriToDelete = null"
                class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                Batal
            </button>
            <form x-bind:action="santriToDelete ? '{{ url('admin/formulir') }}/' + santriToDelete.id : ''" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>
