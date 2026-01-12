<div x-show="docVerifModalOpen"
    class="fixed inset-0 z-[70] flex items-center justify-center bg-gray-600 bg-opacity-50"
    x-cloak>
    <div class="bg-white rounded-lg p-6 shadow-xl max-w-sm w-full" @click.outside="docVerifModalOpen = false">
        <div class="text-center">
            {{-- Ikon Hijau (Sukses/Verifikasi) --}}
            <svg class="mx-auto h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 9 9 0 0118 0z">
                </path>
            </svg>
            <h3 class="mt-2 text-lg font-medium text-gray-900">Verifikasi Dokumen?</h3>
            <div class="mt-2">
                <p class="text-sm text-gray-500">
                    Anda akan memverifikasi dokumen <span class="font-bold text-gray-800" x-text="selectedDocLabel"></span> sebagai <span class="font-bold text-green-600">VALID</span>.
                </p>
                <p class="text-xs text-gray-400 mt-1">Notifikasi email akan dikirim ke pendaftar.</p>
            </div>
        </div>
        <div class="mt-4 flex justify-center space-x-3">
            <button @click="docVerifModalOpen = false"
                class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 transition">
                Batal
            </button>
            {{-- Tombol Eksekusi --}}
            <button @click="submitDocumentStatus(selectedDocType, 'valid'); docVerifModalOpen = false;"
                class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 transition">
                Ya, Verifikasi
            </button>
        </div>
    </div>
</div>
