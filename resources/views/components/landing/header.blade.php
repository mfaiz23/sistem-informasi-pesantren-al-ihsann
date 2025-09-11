<header x-data="{ open: false }" class="bg-white shadow-md sticky top-0 z-50">
    <nav class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="/">
                    <img class="h-10" src="{{ asset('assets/images/logo.png') }}" alt="Logo Pesantren Al-Ihsan">
                </a>
            </div>

            {{-- Menu Navigasi Desktop --}}
            <div class="hidden md:flex items-center space-x-8">
                {{-- Dropdown Informasi --}}
                <div x-data="{ dropdownOpen: false }" class="relative">
                    <button @click="dropdownOpen = !dropdownOpen"
                        class="flex items-center text-gray-700 hover:text-green-600">
                        <span>Informasi</span>
                        <svg class="h-5 w-5 ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                        class="absolute -right-4 mt-2 py-2 w-48 bg-white rounded-md shadow-xl z-20"
                        style="display: none;">
                        <a href="informasi-biaya"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50">Informasi Biaya</a>
                        <a href="{{ route('informasi-pendaftaran') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50">Informasi Pendaftaran</a>
                        <a href="{{ route('informasi-fasilitas') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50">Informasi Fasilitas</a>
                    </div>
                </div>

                {{-- Dropdown Petunjuk --}}
                <div x-data="{ dropdownOpen: false }" class="relative">
                    <button @click="dropdownOpen = !dropdownOpen"
                        class="flex items-center text-gray-700 hover:text-green-600">
                        <span>Petunjuk</span>
                        <svg class="h-5 w-5 ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                        class="absolute -right-4 mt-2 py-2 w-48 bg-white rounded-md shadow-xl z-20"
                        style="display: none;">
                        <a href="{{ route('petunjuk-pendaftaran') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50">Petunjuk Pendaftaran</a>
                        <a href="{{ route('petunjuk-pembayaran') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50">Petunjuk
                            Pembayaran</a>
                    </div>
                </div>
                <a href="{{ route('berita') }}" class="text-gray-700 hover:text-green-600">Berita</a>
                <a href="#" class="text-gray-700 hover:text-green-600">Jadwal Pendaftaran</a>
            </div>

            <div class="hidden md:block">
                <a href="{{ route('register') }}"
                    class="bg-[#028579] text-white font-semibold py-2 px-4 rounded-lg hover:bg-[#016a60] transition duration-300 flex flex-col items-center leading-tight">
                    <span>DAFTAR</span>
                    <span>SEKARANG</span>
                </a>
            </div>

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
                    class="block text-center bg-[#028579] text-white font-semibold py-2 px-4 rounded-lg hover:bg-[#016a60] transition duration-300">
                    DAFTAR SEKARANG
                </a>
            </div>
        </div>
    </nav>
</header>