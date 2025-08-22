<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pembayaran Formulir') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-center">
                    <h3 class="text-2xl font-semibold text-gray-800">Selesaikan Pembayaran Anda</h3>
                    <p class="text-gray-600 mt-2">
                        Total biaya formulir pendaftaran adalah <strong>Rp 300.000,-</strong>.
                    </p>
                    <p class="text-gray-500 text-sm mt-1">
                        Klik tombol di bawah untuk memilih metode pembayaran Anda.
                    </p>

                    <div class="mt-8">
                        <button id="pay-button"
                            class="inline-block bg-green-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-green-700 transition duration-300">
                            BAYAR SEKARANG
                        </button>
                    </div>

                    <p class="text-xs text-gray-400 mt-8">
                        Pembayaran aman dan diproses oleh Midtrans.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Script Midtrans Snap --}}
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script type="text/javascript">
        // Ambil tombol pembayaran
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            // Panggil pop-up Snap dengan snap token dari controller
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function (result) {
                    /* Anda bisa menambahkan logika di sini jika pembayaran sukses, misal redirect */
                    window.location.href = '{{ route('dashboard') }}?payment_status=success';
                },
                onPending: function (result) {
                    /* Anda bisa menambahkan logika di sini jika pembayaran pending */
                    window.location.href = '{{ route('dashboard') }}?payment_status=pending';
                },
                onError: function (result) {
                    /* Anda bisa menambahkan logika di sini jika pembayaran gagal */
                    window.location.href = '{{ route('dashboard') }}?payment_status=error';
                },
                onClose: function () {
                    /* Pengguna menutup pop-up tanpa menyelesaikan transaksi */
                    alert('Anda menutup pop-up pembayaran sebelum selesai.');
                }
            });
        });
    </script>
</x-app-layout>