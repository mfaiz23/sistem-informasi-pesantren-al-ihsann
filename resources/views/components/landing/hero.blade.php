<main>
    <section class="container mx-auto px-6 py-8">
        <img src="{{ asset('assets/images/pesantren.png') }}" alt="Pondok Pesantren Al-Ihsan"
            class="w-full h-auto object-cover rounded-lg shadow-lg">
    </section>

    <section class="text-center py-8">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 leading-tight">
            Wujudkan cita-cita dan masa depan yang gemilang bersama <br class="hidden md:block">
            <span class="text-[#00B0B0]">Pondok Pesantren Al-Ihsan</span>
        </h1>
        <p class="mt-4 max-w-3xl mx-auto text-gray-600">
            Dengan reputasi unggul, kurikulum terpadu, serta bimbingan ustadz dan asatidz berpengalaman, Pondok
            Pesantren Al-Ihsan siap memberikan pengalaman belajar terbaik. Kami hadir untuk mendukung potensi santri
            berkembang menjadi prestasi nyata, ditunjang pembinaan akhlak, hafalan Al-Qur’an, serta jaringan alumni yang
            luas dan solid.
        </p>
        <div class="mt-8 flex flex-col md:flex-row justify-center items-center space-y-4 md:space-y-0 md:space-x-4">
            <a href="{{ route('informasi-pendaftaran') }}"
                class="bg-[#12BC9A] text-white font-bold py-3 px-6 rounded-lg transition duration-300 hover:bg-[#0fa98a] w-full md:w-auto text-center">
                INFORMASI PENDAFTARAN
            </a>
            <a href="{{ route('register') }}"
                class="bg-[#028579] text-white font-bold py-3 px-8 rounded-lg transition duration-300 hover:bg-[#016a60] w-full md:w-auto text-center">
                DAFTAR SEKARANG
            </a>
            <a href="{{ route('petunjuk-pendaftaran') }}"
                class="bg-[#12BC9A] text-white font-bold py-3 px-6 rounded-lg transition duration-300 hover:bg-[#0fa98a] w-full md:w-auto text-center">
                PETUNJUK PENDAFTARAN
            </a>
        </div>
    </section>

    <section class="container mx-auto px-6 pb-12">
        <div
            class="flex flex-col md:flex-row items-stretch justify-center bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden">

            <div class="text-center p-6 flex-1">
                <h3 class="font-semibold text-gray-800">Status Pembimbing</h3>
                <p class="text-2xl font-bold text-[#028579] mt-2">BERKOMPETEN</p>
            </div>

            <div class="w-full md:w-px bg-gray-200"></div>

            <div class="text-center p-6 flex-1">
                <h3 class="font-semibold text-gray-800">Akreditasi Pesantren</h3>
                <p class="text-2xl font-bold text-[#028579] mt-2">UNGGUL</p>
            </div>

            <div class="w-full md:w-px bg-gray-200"></div>

            <div class="text-center p-6 flex-1">
                <h3 class="font-semibold text-gray-800">Lulusan Terbaik</h3>
                <p class="text-2xl font-bold text-[#028579] mt-2">1000+</p>
            </div>
        </div>
    </section>

    <section class="relative py-16 bg-gray-100 bg-cover bg-center"
        style="background-image: url('{{ asset('assets/images/pesantren.png') }}');">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="container mx-auto px-6 text-center relative z-10">
            <h2 class="text-3xl font-bold text-white mb-8">Dalam Cakupan <span class="text-green-300">Al-Ihsan</span>
            </h2>

            {{-- Panel Transparan --}}
            <div class="bg-white bg-opacity-20 backdrop-blur-lg rounded-lg p-8">
                {{-- Statistik Atas --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8 text-white">
                    <div class="flex flex-col items-center">
                        {{-- Ganti dengan SVG Ikon yang sesuai --}}
                        <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v11.494m-5.747-8.247l11.494 8.247-11.494-8.247z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 21.75V10.252m5.747 8.247L6.253 10.252l11.494 8.247z"></path>
                        </svg>
                        <p class="text-4xl font-bold">35</p>
                        <p class="mt-1">Kajian Materi</p>
                    </div>
                    <div class="flex flex-col items-center">
                        <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <p class="text-4xl font-bold">18</p>
                        <p class="mt-1">Pengajar Terbaik</p>
                    </div>
                    <div class="flex flex-col items-center">
                        <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            <path d="M12 14l6.16-3.422A12.083 12.083 0 0112 21.75c-2.673 0-5.18-1.02-7-2.75L12 14z">
                            </path>
                        </svg>
                        <p class="text-4xl font-bold">200+</p>
                        <p class="mt-1">Lulusan Terbaik</p>
                    </div>
                </div>

                {{-- Garis Pemisah --}}
                <hr class="border-white opacity-25 my-8">

                {{-- Statistik Bawah --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-white">
                    <div>
                        <p class="text-4xl font-bold">200+</p>
                        <p class="mt-1">Santri Registrasi</p>
                    </div>
                    <div>
                        <p class="text-4xl font-bold">1000+</p>
                        <p class="mt-1">Santri Aktif</p>
                    </div>
                    <div>
                        <p class="text-4xl font-bold">#1</p>
                        <p class="mt-1">Ranking Pesantren Se-Bandung Raya</p>
                    </div>
                    <div>
                        <p class="text-4xl font-bold">30+</p>
                        <p class="mt-1">Prestasi Unggulan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>