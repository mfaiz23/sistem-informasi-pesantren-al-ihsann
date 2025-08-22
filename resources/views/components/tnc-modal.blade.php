@props(['show'])

<div x-data="{ show: @js($show) }" x-show="show" x-on:keydown.escape.window="show = false"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4" style="display: none;">
    <div x-show="show" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-auto">
        <div class="p-8">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-8 tracking-wider uppercase">Syarat dan
                Ketentuan</h2>

            <div class="max-w-none pr-4 text-gray-700 text-sm space-y-4">
                <ol class="list-decimal list-outside ml-5 space-y-4">
                    <li>Formulir Pendaftaran hanya dapat diakses oleh calon santri yang telah melakukan pembayaran biaya
                        formulir sebesar Rp300.000 melalui sistem pembayaran resmi yang tersedia di website PSB.</li>
                    <li>Dengan melakukan pembayaran, calon santri dianggap telah membaca, memahami, dan menyetujui
                        Syarat dan Ketentuan ini.</li>
                    <li>Biaya formulir bersifat tetap dan tidak dapat dikembalikan (non-refundable) dengan alasan
                        apapun.</li>
                    <li>Calon santri wajib memastikan bahwa data yang diisi saat proses pembayaran sesuai dengan
                        identitas yang terdaftar.</li>
                    <li>Pembayaran uang pangkal dilakukan diluar sistem PSB, yakni melalui no rekening resmi Yayasan
                        Pondok Pesantren Al-Ihsan.</li>
                    <li>Akses formulir diberikan maksimal 1x24 jam setelah sistem menerima dan memverifikasi pembayaran.
                    </li>
                    <li>Calon santri bertanggung jawab untuk mengisi formulir dengan benar, lengkap, dan sesuai dengan
                        dokumen resmi yang diminta.</li>
                    <li>Pondok Pesantren Al-Ihsan berhak menolak atau membatalkan akses formulir apabila ditemukan
                        kecurangan, manipulasi, atau pelanggaran terhadap ketentuan ini.</li>
                    <li>Calon santri bertanggung jawab untuk mengisi formulir dengan benar, lengkap, dan sesuai dengan
                        dokumen resmi yang diminta.</li>
                    <li>Syarat dan Ketentuan ini dapat berubah sewaktu-waktu sesuai kebijakan Pondok Pesantren Al Ihsan,
                        dan perubahan akan diumumkan melalui website resmi PSB.</li>
                </ol>
            </div>

            <form method="POST" action="{{ route('tnc.accept') }}" x-data="{ agreed: false }" class="mt-8">
                @csrf
                <div class="flex items-center">
                    <input id="agree_tnc" type="checkbox" x-model="agreed"
                        class="h-5 w-5 border-gray-400 rounded text-green-600 focus:ring-green-500 focus:ring-offset-0">
                    <label for="agree_tnc" class="ml-3 text-sm text-gray-800 tracking-wide cursor-pointer">SAYA
                        MENYETUJUI SYARAT DAN KETENTUAN YANG BERLAKU DI LINGKUNGAN YAYASAN PONDOK PESANTREN
                        AL-IHSAN.</label>
                </div>

                <div class="mt-8 flex justify-center">
                    <button type="submit" :disabled="!agreed"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-16 py-3 bg-green-600 border border-transparent rounded-lg font-semibold text-white uppercase tracking-widest hover:bg-green-700 disabled:bg-gray-400 disabled:cursor-not-allowed transition shadow-md">
                        Lanjutkan ke Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>