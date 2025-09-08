@props(['show'])

{{-- Latar belakang gelap --}}
<div x-data="{ show: @js($show) }" x-show="show"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4" style="display: none;">

    {{-- Konten Modal --}}
    <div x-show="show" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-auto">

        <div class="p-8">
            {{-- Judul --}}
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6 tracking-wider uppercase">Syarat dan
                Ketentuan</h2>

            {{-- Isi Konten T&C --}}
            <div class="text-gray-700 text-sm space-y-3">
                <ol class="list-decimal list-outside ml-5 space-y-3">
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
                    <li>Syarat dan Ketentuan ini dapat berubah sewaktu-waktu sesuai kebijakan Pondok Pesantren Al Ihsan,
                        dan perubahan akan diumumkan melalui website resmi PSB.</li>
                </ol>
            </div>

            {{-- Form Persetujuan --}}
            <form method="POST" action="{{ route('tnc.accept') }}" x-data="{ agreed: false }" class="mt-6">
                @csrf
                <div class="flex items-center">
                    <input id="agree_tnc" type="checkbox" x-model="agreed"
                        class="h-4 w-4 border-gray-400 rounded text-[#028579] focus:ring-[#028579]">
                    <label for="agree_tnc"
                        class="ml-3 text-xs text-gray-800 tracking-wide cursor-pointer uppercase">SAYA
                        MENYETUJUI SYARAT DAN KETENTUAN YANG BERLAKU DI LINGKUNGAN YAYASAN PONDOK PESANTREN
                        AL-IHSAN.</label>
                </div>

                {{-- Tombol Lanjutkan --}}
                <div class="mt-6 flex justify-center">
                    <button type="submit" :disabled="!agreed"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-12 py-2.5 bg-[#028579] border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-[#016a60] disabled:bg-gray-400 disabled:cursor-not-allowed transition shadow-sm">
                        Lanjutkan ke Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>