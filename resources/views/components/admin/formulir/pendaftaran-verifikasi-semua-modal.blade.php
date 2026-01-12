<div x-show="markAllModalOpen"
    class="fixed inset-0 z-[80] flex items-center justify-center bg-gray-900 bg-opacity-60 backdrop-blur-sm"
    x-cloak>

    <div class="bg-white rounded-xl p-6 shadow-2xl max-w-sm w-full transform transition-all scale-100"
         @click.outside="markAllModalOpen = false">

        <div class="text-center">
            {{-- Ikon Check Double (Blue/Green) --}}
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 mb-4">
                <svg class="h-10 w-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                    </path>
                </svg>
            </div>

            <h3 class="text-xl font-bold text-gray-900">Verifikasi Semua Dokumen?</h3>

            <div class="mt-3 text-gray-500 text-sm">
                <p>Tindakan ini akan mengubah status <strong>SEMUA</strong> dokumen (KTP, KK, Ijazah, KIP) menjadi <span class="text-green-600 font-bold">VALID</span>.</p>
                <p class="mt-2 text-xs text-red-500 bg-red-50 p-2 rounded">
                    <span class="font-bold">Perhatian:</span> Dokumen yang sebelumnya <strong>DITOLAK</strong> juga akan diubah menjadi VALID.
                </p>
            </div>
        </div>

        <div class="mt-6 flex justify-center gap-3">
            <button @click="markAllModalOpen = false"
                class="w-full px-4 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none transition">
                Batal
            </button>

            {{-- Tombol Submit Form --}}
            <button @click="submitMarkAll(); markAllModalOpen = false;"
                class="w-full px-4 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none shadow-lg shadow-blue-500/30 transition">
                Ya, Validasi Semua
            </button>
        </div>
    </div>
</div>
