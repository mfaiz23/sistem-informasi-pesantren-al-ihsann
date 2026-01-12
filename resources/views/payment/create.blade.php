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

                    {{-- IKON KARTU --}}
                    <div class="w-16 h-16 bg-gray-100 rounded-lg mx-auto mb-6 flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                            </path>
                        </svg>
                    </div>

                    <h3 class="text-xl font-semibold text-gray-800">Selesaikan Pembayaran Anda</h3>
                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        Rp. 300.000,-
                    </p>
                    <p class="text-gray-500 text-sm mt-3">
                        Klik tombol di bawah ini untuk memilih metode pembayaran yang akan digunakan.
                    </p>

                    <div class="mt-8">
                        {{-- TOMBOL YANG DISESUAIKAN --}}
                        <button id="pay-button"
                            class="inline-block bg-[#028579] hover:bg-[#016a60] text-white font-bold py-3 px-8 rounded-[20px] transition duration-300">
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

    {{-- Script Midtrans Snap tidak berubah --}}
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function (result) {
                    window.location.href = '{{ route('dashboard') }}?payment_status=success';
                },
                onPending: function (result) {
                    window.location.href = '{{ route('dashboard') }}?payment_status=pending';
                },
                onError: function (result) {
                    window.location.href = '{{ route('dashboard') }}?payment_status=error';
                },
                onClose: function () {
                    console.log('Pop-up ditutup tanpa menyelesaikan pembayaran.');
                }
            });
        });
    </script>
</x-app-layout>