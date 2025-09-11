<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-t">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Informasi Pendaftaran - PSB Al-Ihsan</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-white">

    <x-landing.header />

    <main>
        <section class="bg-[#12BC9A]">
            <div class="container mx-auto px-6 py-10 text-white">
                <h1 class="text-3xl font-bold">Informasi Pendaftaran</h1>
                <div class="text-sm mt-1">
                    <a href="/" class="hover:underline opacity-80">Home</a>
                    <span class="mx-2">></span>
                    <span>Informasi Pendaftaran</span>
                </div>
            </div>
        </section>

        <section class="container mx-auto px-6 py-12">
            <div x-data="{ tab: 'reguler' }"
                class="w-full max-w-5xl mx-auto bg-gray-50 p-4 sm:p-8 rounded-lg shadow-sm">
                <div class="border-b border-gray-200">
                    <nav class="flex justify-center -mb-px space-x-1">
                        <button @click="tab = 'reguler'"
                            :class="{'border-[#028579] text-[#028579]': tab === 'reguler', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'reguler'}"
                            class="whitespace-nowrap py-4 px-8 border-b-2 font-medium text-sm focus:outline-none">
                            Santri Reguler
                        </button>
                        <button @click="tab = 'non-reguler'"
                            :class="{'border-[#028579] text-[#028579]': tab === 'non-reguler', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'non-reguler'}"
                            class="whitespace-nowrap py-4 px-8 border-b-2 font-medium text-sm focus:outline-none">
                            Santri Non Reguler
                        </button>
                    </nav>
                </div>

                <div class="mt-8">
                    <div x-show="tab === 'reguler'" class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                        <div class="w-full">
                            <img src="{{ asset('assets/images/pesantren.png') }}" alt="Santri Belajar"
                                class="rounded-lg object-cover w-full h-auto">
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">Persyaratan Santri Reguler:</h3>
                            <ol class="list-decimal list-outside ml-5 text-gray-700 space-y-2">
                                <li>Beragama Islam</li>
                                <li>Sehat jasmani maupun rohani, tidak memiliki gangguan kejiwaan</li>
                                <li>Bersedia mengikuti seluruh aturan dan tata tertib pesantren</li>
                                <li>Bersedia menimba ilmu dengan serius dan disiplin</li>
                                <li>Tidak bertato dan bebas dari narkotika</li>
                            </ol>
                        </div>
                    </div>

                    <div x-show="tab === 'non-reguler'" style="display: none;"
                        class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                        <div class="w-full">
                            <img src="{{ asset('assets/images/pesantren.png') }}" alt="Santri Belajar"
                                class="rounded-lg object-cover w-full h-auto">
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">Persyaratan Santri Non Reguler:</h3>
                            <ol class="list-decimal list-outside ml-5 text-gray-700 space-y-2">
                                <li>Beragama Islam</li>
                                <li>Sehat jasmani maupun rohani, tidak memiliki gangguan kejiwaan</li>
                                <li>Bersedia mengikuti seluruh aturan dan tata tertib pesantren</li>
                                <li>Bersedia menimba ilmu dengan serius dan disiplin</li>
                                <li>Tidak bertato dan bebas dari narkotika</li>
                                <li>Memiliki dokumen KIP asli</li>
                                <li>Terdaftar sebagai mahasiswa KIP</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <x-landing.footer />

</body>

</html>