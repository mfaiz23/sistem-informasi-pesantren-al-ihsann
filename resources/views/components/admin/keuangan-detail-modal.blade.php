{{--
    Modal dialog untuk menampilkan detail pembayaran.
--}}
<div
    x-show="modalOpen"
    x-transition
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
    style="display: none;"
>
    {{-- Modal dilebarkan menjadi max-w-2xl --}}
    <div
        @click.away="modalOpen = false"
        class="w-full max-w-2xl px-6 py-4 mx-auto bg-white rounded-lg shadow-xl"
    >
        <div class="flex items-start justify-between pb-3 border-b">
            <div>
                <h3 class="text-xl font-semibold text-gray-800" id="modal-title">Detail Pembayaran</h3>
                <p class="text-sm text-gray-500" x-show="selectedPayment">Invoice: <span x-text="selectedPayment.invoice_id"></span></p>
            </div>
            <button @click="modalOpen = false" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        {{-- Body Modal --}}
        <div class="mt-4" x-if="selectedPayment">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                {{-- Info Pendaftar --}}
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Dibayarkan oleh:</h4>
                    <div class="flex items-center mt-2 space-x-3">
                        <img class="object-cover w-12 h-12 rounded-full" :src="`https://ui-avatars.com/api/?name=${selectedPayment.name.replace(' ', '+')}&background=22C55E&color=fff`" alt="Foto profil">
                        <div>
                            <p class="font-semibold text-gray-800" x-text="selectedPayment.name"></p>
                            <p class="text-sm text-gray-600" x-text="selectedPayment.email"></p>
                        </div>
                    </div>
                </div>
                {{-- Info Pembayaran --}}
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Detail Transaksi:</h4>
                    <dl class="mt-2 space-y-2 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Tanggal Bayar:</dt>
                            <dd class="font-medium text-gray-800" x-text="selectedPayment.date"></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Metode Bayar:</dt>
                            <dd class="font-medium text-gray-800" x-text="selectedPayment.payment_method"></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Status:</dt>
                            <dd class="font-semibold"
                                :class="{
                                    'text-green-600': selectedPayment.status === 'Sudah Lunas',
                                    'text-red-600': selectedPayment.status === 'Menunggu Pembayaran',
                                    'text-yellow-600': selectedPayment.status === 'Menunggu Verifikasi'
                                }"
                                x-text="selectedPayment.status"></dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- Rincian Nominal --}}
            <div class="pt-4 mt-4 border-t">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-semibold text-gray-800">Total Pembayaran</span>
                    <span class="text-xl font-bold text-green-600" x-text="new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(selectedPayment.nominal)"></span>
                </div>
            </div>
        </div>

        {{-- Footer Modal --}}
        <div class="flex justify-end pt-4 mt-4 border-t">
            <button @click="modalOpen = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none">
                Tutup
            </button>
        </div>
    </div>
</div>
