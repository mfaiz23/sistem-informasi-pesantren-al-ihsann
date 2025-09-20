<x-admin-layout>
    <div class="flex flex-col items-start justify-between my-6 space-y-4 md:flex-row md:items-center md:space-y-0">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Selamat Datang Kembali! 👋</h2>
            <p class="mt-1 text-gray-500">Lihat ringkasan aktivitas terbaru di bawah ini.</p>
        </div>
    </div>

    {{-- Grid Utama untuk Konten --}}
    <div class="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-3">
        {{-- Kolom Kiri (lebih besar) untuk Cards & Tabel --}}
        <div class="space-y-6 lg:col-span-2">
            <div class="grid gap-6 sm:grid-cols-2">
                <x-admin.card title="Total Pengguna" :value="$totalPengguna">
                    <x-slot name="icon">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-3-5.197M15 21a9 9 0 00-9-9m9 9a9 9 0 00-9-9"></path></svg>
                    </x-slot>
                </x-admin.card>
                <x-admin.card title="Pendapatan" :value="$totalPendapatan">
                    <x-slot name="icon">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01M12 6v-1m0-1V4m0 2.01M12 18v-2m0 2v1m0 1v1m0-2.01M12 4.01V3m0 14.01V16"></path></svg>
                    </x-slot>
                </x-admin.card>
            </div>

            <h3 class="text-xl font-semibold text-gray-700">Pengguna Terbaru</h3>
            <x-admin.datatable>
                <x-slot name="header">
                    <th class="px-4 py-3">Pengguna</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Tanggal Daftar</th>
                </x-slot>

                @forelse($penggunaTerbaru as $user)
                <tr class="text-gray-700 transition-colors duration-200 hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                            <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                <img class="object-cover w-full h-full rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" alt="{{ $user->name }}" loading="lazy">
                                <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                            </div>
                            <div>
                                <p class="font-semibold">{{ $user->name }}</p>
                                <p class="text-xs text-gray-600">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-sm capitalize">{{ str_replace('_', ' ', $user->role) }}</td>
                    <td class="px-4 py-3 text-xs">
                        @if($user->email_verified_at)
                            <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                                Terverifikasi
                            </span>
                        @else
                            <span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full">
                                Belum Verifikasi
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm">{{ $user->created_at->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-3 text-center text-gray-500">Belum ada pengguna terdaftar.</td>
                </tr>
                @endforelse
            </x-admin.datatable>
        </div>

        {{-- Kolom Kanan untuk Aktivitas (DINAMIS) --}}
        <div class="lg:col-span-1">
            <div class="p-6 bg-white rounded-lg shadow-md">
                <h3 class="mb-4 text-lg font-semibold text-gray-700">Aktivitas Terbaru</h3>
                <div class="space-y-6">
                    @forelse($aktivitasTerbaru as $aktivitas)
                        <x-admin.activity-item
                            :type="$aktivitas['type']"
                            :title="$aktivitas['title']"
                            :time="$aktivitas['time']->diffForHumans()"
                        />
                    @empty
                        <p class="text-sm text-center text-gray-500">Belum ada aktivitas terbaru.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Footer Sederhana --}}
    <footer class="py-4 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} Pondok Pesantren Al-Ihsan. All rights reserved.
    </footer>
</x-admin-layout>
