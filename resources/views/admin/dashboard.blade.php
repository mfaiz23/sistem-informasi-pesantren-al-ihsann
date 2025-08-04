<x-admin-layout>
    {{-- 1. HEADER DINAMIS DENGAN TOMBOL AKSI --}}
    <div class="flex flex-col items-start justify-between my-6 space-y-4 md:flex-row md:items-center md:space-y-0">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Selamat Datang Kembali! 👋</h2>
            <p class="mt-1 text-gray-500">Lihat ringkasan aktivitas terbaru di bawah ini.</p>
        </div>
        <a href="#" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg shadow-md active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">
            <svg class="w-4 h-4 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
            <span>Buat Laporan Baru</span>
        </a>
    </div>

    {{-- Grid Utama untuk Konten --}}
    <div class="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-3">
        {{-- Kolom Kiri (lebih besar) untuk Cards & Tabel --}}
        <div class="space-y-6 lg:col-span-2">
            <!-- Cards Statistik -->
            <div class="grid gap-6 sm:grid-cols-2">
                <x-admin.card title="Total Pengguna" value="1,250">
                    <x-slot name="icon">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-3-5.197M15 21a9 9 0 00-9-9m9 9a9 9 0 00-9-9"></path></svg>
                    </x-slot>
                </x-admin.card>
                <x-admin.card title="Pendapatan" value="Rp 15.7Jt">
                    <x-slot name="icon">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01M12 6v-1m0-1V4m0 2.01M12 18v-2m0 2v1m0 1v1m0-2.01M12 4.01V3m0 14.01V16"></path></svg>
                    </x-slot>
                </x-admin.card>
            </div>

            <!-- Tabel Data Pengguna -->
            <h3 class="text-xl font-semibold text-gray-700">Pengguna Terbaru</h3>
            <x-admin.datatable>
                <x-slot name="header">
                    <th class="px-4 py-3">Pengguna</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Tanggal Daftar</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </x-slot>

                {{-- Contoh data statis, idealnya dari @foreach($users as $user) --}}
                <tr class="text-gray-700 transition-colors duration-200 hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                            <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                <img class="object-cover w-full h-full rounded-full" src="https://ui-avatars.com/api/?name=John+Doe&background=random" alt="" loading="lazy">
                                <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                            </div>
                            <div>
                                <p class="font-semibold">John Doe</p>
                                <p class="text-xs text-gray-600">johndoe@example.com</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-sm">Admin</td>
                    <td class="px-4 py-3 text-xs">
                        <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                            Aktif
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm">15/07/2024</td>
                    <td class="px-4 py-3 text-sm">
                        <div class="flex items-center justify-center space-x-4">
                            <button class="p-2 text-gray-500 transition-colors duration-200 rounded-lg hover:bg-gray-200 hover:text-green-600 focus:outline-none" aria-label="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L16.732 3.732z"></path></svg>
                            </button>
                            <button class="p-2 text-gray-500 transition-colors duration-200 rounded-lg hover:bg-gray-200 hover:text-red-600 focus:outline-none" aria-label="Delete">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                {{-- Akhir dari loop --}}
            </x-admin.datatable>
        </div>

        <div class="lg:col-span-1">
            <div class="p-6 bg-white rounded-lg shadow-md">
                <h3 class="mb-4 text-lg font-semibold text-gray-700">Aktivitas Terbaru</h3>
                <div class="space-y-6">
                    {{-- IMPLEMENTASI KOMPONEN ACTIVITY-ITEM YANG BARU --}}
                    <x-admin.activity-item
                        type="user"
                        title="Pengguna baru 'Aisha' mendaftar."
                        time="2 menit yang lalu"
                    />
                    <x-admin.activity-item
                        type="report"
                        title="Laporan bulanan berhasil dibuat."
                        time="1 jam yang lalu"
                    />
                    <x-admin.activity-item
                        type="payment"
                        title="Pembayaran SPP dari Budi telah dikonfirmasi."
                        time="2 jam yang lalu"
                    />
                    <x-admin.activity-item
                        type="setting"
                        title="Logo website telah diperbarui."
                        time="5 jam yang lalu"
                    />
                    <x-admin.activity-item
                        type="default"
                        title="Server merespon dengan normal."
                        time="Kemarin"
                    />
                </div>
            </div>
        </div>
    </div>

    {{-- Footer Sederhana --}}
    <footer class="py-4 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} Pondok Pesantren Al-Ihsan. All rights reserved.
    </footer>
</x-admin-layout>
