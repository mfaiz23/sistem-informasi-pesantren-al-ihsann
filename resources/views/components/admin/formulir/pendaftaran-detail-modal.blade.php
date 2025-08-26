{{--
    Modal dialog untuk menampilkan detail pendaftar santri.
    Struktur dirombak untuk stabilitas dan kemudahan pengembangan.
--}}
<div
    x-show="modalOpen"
    x-transition
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
    style="display: none;"
>
    {{-- PERUBAHAN: Modal dilebarkan dari max-w-lg menjadi max-w-3xl --}}
    <div
        @click.away="modalOpen = false"
        class="w-full max-w-3xl px-6 py-4 mx-auto bg-white rounded-lg shadow-xl"
    >
        <div class="flex items-start justify-between pb-3 border-b">
            <h3 class="text-xl font-semibold text-gray-800" id="modal-title">Detail Pendaftar</h3>
            <button @click="modalOpen = false" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        {{-- Body Modal: Hanya akan dirender jika selectedSantri tidak null --}}
        <div class="mt-4" x-if="selectedSantri">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                {{-- Kolom Kiri: Foto dan Info Utama --}}
                <div class="flex flex-col items-center text-center md:col-span-1 md:items-start md:text-left">
                    <img class="object-cover w-32 h-32 rounded-full" :src="`https://ui-avatars.com/api/?name=${selectedSantri.name.replace(' ', '+')}&background=22C55E&color=fff`" alt="Foto profil">
                    <p class="mt-4 text-2xl font-bold text-gray-800" x-text="selectedSantri.name"></p>
                    <p class="text-sm text-gray-500" x-text="selectedSantri.email"></p>
                    <span class="mt-2 px-2 py-1 text-xs font-semibold leading-tight rounded-full"
                          :class="{
                            'text-indigo-700 bg-indigo-100': selectedSantri.type === 'Reguler',
                            'text-purple-700 bg-purple-100': selectedSantri.type !== 'Reguler'
                          }"
                          x-text="selectedSantri.type">
                    </span>
                </div>

                {{-- Kolom Kanan: Detail Informasi --}}
                <div class="md:col-span-2">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nomor Pendaftaran</dt>
                            <dd class="mt-1 text-sm text-gray-900" x-text="selectedSantri.reg_id"></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal Pendaftaran</dt>
                            <dd class="mt-1 text-sm text-gray-900" x-text="selectedSantri.date"></dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                            <dd class="mt-1 text-sm text-gray-900" x-text="selectedSantri.address"></dd>
                        </div>

                        {{-- Bagian Dokumen KIP (Hanya muncul jika ada) --}}
                        <template x-if="selectedSantri.kip_document">
                            <div class="sm:col-span-2 p-3 bg-gray-50 rounded-md">
                                <dt class="text-sm font-medium text-gray-600">Dokumen KIP</dt>
                                <dd class="flex items-center justify-between mt-1 text-sm text-gray-900">
                                    <span class="truncate" x-text="selectedSantri.kip_document"></span>
                                    <a href="#" class="inline-flex items-center ml-4 text-sm font-medium text-green-600 hover:text-green-800">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        Download
                                    </a>
                                </dd>
                            </div>
                        </template>
                    </dl>
                </div>
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
