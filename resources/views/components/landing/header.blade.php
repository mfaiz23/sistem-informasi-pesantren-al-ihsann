<header x-data="{ open: false }" class="bg-white shadow-md sticky top-0 z-50">
    <nav class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="/">
                    {{-- GANTI DENGAN LOGO ANDA --}}
                    <img class="h-10" src="{{ asset('assets/images/logo.png') }}">
                </a>
            </div>

            <div class="hidden md:flex items-center space-x-8">
                <a href="#" class="text-gray-700 hover:text-green-600">Informasi</a>

                {{-- Dropdown Menu --}}
                <div x-data="{ dropdownOpen: false }" class="relative">
                    <button @click="dropdownOpen = !dropdownOpen"
                        class="flex items-center text-gray-700 hover:text-green-600">
                        <span>Jalur Seleksi</span>
                        <svg class="h-5 w-5 ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                        class="absolute right-0 mt-2 py-2 w-48 bg-white rounded-md shadow-xl z-20">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50">Seleksi Reguler</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50">Seleksi Prestasi</a>
                    </div>
                </div>

                <a href="#" class="text-gray-700 hover:text-green-600">Berita Acara</a>
                <a href="#" class="text-gray-700 hover:text-green-600">Jadwal Pendaftaran</a>
            </div>

            {{-- ===== BAGIAN YANG DIPERBAIKI ADA DI SINI ===== --}}
            <div class="hidden md:block">
                <a href="{{ route('register') }}"
                    class="bg-green-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-700 transition duration-300 flex flex-col items-center leading-tight">
                    <span>DAFTAR</span>
                    <span>SEKARANG</span>
                </a>
            </div>
            {{-- ===== BATAS PERBAIKAN ===== --}}


            <div class="md:hidden flex items-center">
                <button @click="open = !open" class="text-gray-600 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
        </div>

        <div :class="{'block': open, 'hidden': !open}" class="md:hidden mt-4">
            <a href="#" class="block py-2 text-gray-700">Informasi</a>
            <a href="#" class="block py-2 text-gray-700">Jalur Seleksi</a>
            <a href="#" class="block py-2 text-gray-700">Berita Acara</a>
            <a href="#" class="block py-2 text-gray-700">Jadwal Pendaftaran</a>
            <div class="mt-4">
                <a href="{{ route('register') }}"
                    class="block text-center bg-green-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-700 transition duration-300">
                    DAFTAR SEKARANG
                </a>
            </div>
        </div>
    </nav>
</header>