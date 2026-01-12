@props([])

<div x-show="rejectModalOpen"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-60"
     style="display: none;">

    <div @click.away="rejectModalOpen = false"
         x-show="rejectModalOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-90"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-90"
         class="w-full max-w-lg p-6 mx-4 bg-white rounded-lg shadow-xl">

        <form :action="rejectActionUrl" method="POST" class="flex flex-col">
            @csrf
            <div class="flex items-center mb-4">
                <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 bg-red-100 rounded-full">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="ml-4 text-left">
                    <h3 class="text-lg font-medium text-gray-900">Tolak Pendaftaran</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Mohon berikan alasan penolakan. Alasan ini akan dikirimkan ke email pendaftar.
                    </p>
                </div>
            </div>

            {{-- Alasan Penolakan --}}
            <div>
                <label for="alasan_penolakan" class="sr-only">Alasan Penolakan</label>
                <textarea id="alasan_penolakan" name="alasan_penolakan" rows="4"
                          class="w-full px-3 py-2 text-sm text-gray-700 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                          placeholder="Contoh: Dokumen KIP tidak valid, data wali tidak lengkap, dll."
                          required></textarea>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end mt-6 space-x-4">
                <button type="button"
                        @click="rejectModalOpen = false"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Batal
                </button>
                <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Kirim Penolakan
                </button>
            </div>
        </form>
    </div>
</div>
