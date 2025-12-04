<div x-show="rejectModalOpen"
    class="fixed inset-0 z-[60] flex items-center justify-center bg-gray-800 bg-opacity-75"
    x-cloak>

    <div x-show="rejectModalOpen" x-transition @click.outside="rejectModalOpen = false"
        class="w-full max-w-md p-6 bg-white rounded-lg shadow-2xl">

        <div class="text-center">
            {{-- Ikon Peringatan (Kuning/Orange karena ini Warning/Input) --}}
            <svg class="w-16 h-16 mx-auto text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>

            {{-- Judul Modal --}}
            <h3 class="mt-4 text-xl font-semibold text-gray-900">Tolak Dokumen</h3>

            {{-- Deskripsi --}}
            <div class="mt-2 text-gray-600">
                <p>
                    Anda akan menolak dokumen <span class="font-bold text-gray-800" x-text="selectedDocLabel"></span>.
                </p>
                <p class="text-sm mt-1">Silakan pilih alasan penolakan di bawah ini:</p>
            </div>

            {{-- Input Dropdown Alasan --}}
            <div class="mt-4 text-left">
                <label class="block text-sm font-medium text-gray-700 mb-1">Alasan Penolakan</label>
                <select x-model="rejectReason" class="w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500 text-sm py-2 px-3">
                    <option value="" disabled selected>-- Pilih Alasan --</option>
                    <option value="Dokumen buram / tidak terbaca">Dokumen buram / tidak terbaca</option>
                    <option value="Dokumen tidak sesuai (Salah Upload)">Dokumen tidak sesuai (Salah Upload)</option>
                    <option value="Data dokumen tidak cocok dengan isian formulir">Data dokumen tidak cocok dengan isian formulir</option>
                    <option value="Dokumen kedaluwarsa">Dokumen kedaluwarsa</option>
                    <option value="Format file tidak didukung">Format file tidak didukung</option>
                    <option value="Dokumen terpotong / tidak lengkap">Dokumen terpotong / tidak lengkap</option>
                </select>
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="mt-6 flex justify-center space-x-3">
            {{-- Tombol Batal --}}
            <button @click="rejectModalOpen = false"
                class="w-full px-4 py-2.5 font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 sm:w-auto transition">
                Batal
            </button>

            {{-- Tombol Simpan Penolakan --}}
            <button
                @click="if(rejectReason) { submitDocumentStatus(selectedDocType, 'invalid', rejectReason); rejectModalOpen = false; } else { alert('Mohon pilih alasan penolakan terlebih dahulu.'); }"
                class="w-full inline-flex justify-center px-4 py-2.5 font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto transition disabled:opacity-50 disabled:cursor-not-allowed"
                :disabled="!rejectReason">
                Simpan Penolakan
            </button>
        </div>
    </div>
</div>
