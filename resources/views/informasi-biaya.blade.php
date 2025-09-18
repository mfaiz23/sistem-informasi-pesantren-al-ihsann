@extends('layouts.public')

@section('title', 'Informasi Biaya - PSB Al-Ihsan')

@section('content')
    <section class="bg-[#12BC9A]">
        <div class="container mx-auto px-6 py-10 text-white">
            <h1 class="text-3xl font-bold">Informasi Biaya</h1>
            <div class="text-sm mt-1">
                <a href="/" class="hover:underline opacity-80">Home</a>
                <span class="mx-2">></span>
                <span>Informasi Biaya</span>
            </div>
        </div>
    </section>

    <section class="container mx-auto px-6 py-12">
        <div class="w-full max-w-5xl mx-auto bg-white p-6 sm:p-8 rounded-lg shadow-md">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">

                <div>
                    <img src="{{ asset('assets/images/pesantren.png') }}" alt="Santri Al-Ihsan"
                        class="rounded-lg object-cover w-full h-auto shadow">
                </div>

                <div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-6 pb-2 border-b">Rincian Biaya:</h3>
                    <div class="space-y-5 text-gray-800">

                        <div class="flex justify-between items-start space-x-4">
                            <div class="flex-1">
                                <strong class="font-semibold">a. Formulir pendaftaran</strong>
                                <p class="text-sm text-gray-500">(Pembayaran sekali pada awal masuk)</p>
                            </div>
                            <strong class="flex-shrink-0 font-semibold text-lg text-gray-900">Rp. 300.000,-</strong>
                        </div>

                        <div class="flex justify-between items-start space-x-4">
                            <div class="flex-1">
                                <strong class="font-semibold">b. Uang pangkal</strong>
                                <p class="text-sm text-gray-500">(Pembayaran sekali pada awal masuk)</p>
                            </div>
                            <strong class="flex-shrink-0 font-semibold text-lg text-gray-900">Rp.
                                6.000.000,-</strong>
                        </div>

                        <div class="flex justify-between items-start space-x-4">
                            <div class="flex-1">
                                <strong class="font-semibold">c. Infaq per semester</strong>
                                <p class="text-sm text-gray-500">(Pembayaran setiap awal bulan Juni dan awal bulan
                                    Desember)</p>
                            </div>
                            <strong class="flex-shrink-0 font-semibold text-lg text-gray-900">Rp. 900.000,-</strong>
                        </div>

                        <div class="flex justify-between items-start space-x-4">
                            <div class="flex-1">
                                <strong class="font-semibold">d. Uang makan per bulan (putri)</strong>
                                <p class="text-sm text-gray-500">(Pembayaran setiap awal bulan)</p>
                            </div>
                            <strong class="flex-shrink-0 font-semibold text-lg text-gray-900">Rp. 300.000,-</strong>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
