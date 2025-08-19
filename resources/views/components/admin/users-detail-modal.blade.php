@props(['user'])

{{--
    Modal dialog untuk menampilkan detail pengguna.
    - 'x-show="modalOpen"': Mengontrol visibilitas modal.
    - 'x-transition': Menambahkan animasi fade-in/out.
    - '@click.away="modalOpen = false"': Menutup modal saat mengklik di luar area konten.
    - '@keydown.escape.window="modalOpen = false"': Menutup modal saat menekan tombol Escape.
--}}
<div
    x-show="modalOpen"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
    style="display: none;" {{-- Sembunyikan secara default, Alpine.js akan menanganinya --}}
>
    {{-- Konten Modal --}}
    <div
        @click.away="modalOpen = false"
        class="w-full max-w-lg px-6 py-4 mx-auto overflow-hidden bg-white rounded-lg shadow-xl"
    >
        <div class="flex items-start justify-between pb-3 border-b">
            <h3 class="text-xl font-semibold text-gray-800" id="modal-title">Detail Pengguna</h3>
            <button @click="modalOpen = false" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        {{-- Body Modal --}}
        <div class="mt-4">
            <div class="flex flex-col items-center space-y-4 sm:flex-row sm:space-y-0 sm:space-x-6">
                {{-- Foto Profil --}}
                <img class="object-cover w-24 h-24 rounded-full" :src="`https://ui-avatars.com/api/?name=${selectedUser.name.replace(' ', '+')}&background=22C55E&color=fff`" alt="Foto profil">

                {{-- Info Pengguna --}}
                <div class="flex-1 text-center sm:text-left">
                    <p class="text-2xl font-bold text-gray-800" x-text="selectedUser.name"></p>
                    <p class="text-sm text-gray-500" x-text="selectedUser.email"></p>
                    <div class="flex items-center justify-center mt-2 space-x-2 sm:justify-start">
                        <span class="px-2 py-1 text-xs font-semibold leading-tight rounded-full"
                              :class="{
                                'text-green-700 bg-green-100': selectedUser.status === 'Aktif',
                                'text-yellow-700 bg-yellow-100': selectedUser.status !== 'Aktif'
                              }"
                              x-text="selectedUser.status">
                        </span>
                        <span class="px-2 py-1 text-xs font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full" x-text="selectedUser.role"></span>
                    </div>
                </div>
            </div>

            <div class="pt-4 mt-4 border-t">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">ID Pengguna</dt>
                        <dd class="mt-1 text-sm text-gray-900" x-text="selectedUser.id"></dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Tanggal Daftar</dt>
                        <dd class="mt-1 text-sm text-gray-900" x-text="selectedUser.date"></dd>
                    </div>
                </dl>
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
