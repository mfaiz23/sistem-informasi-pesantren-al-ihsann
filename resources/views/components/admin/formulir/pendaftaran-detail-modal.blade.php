<div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 transition-opacity ease-out duration-300">
    <div x-show="modalOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         class="bg-white rounded-lg shadow-xl w-11/12 md:w-4/5 lg:w-3/4 xl:w-2/3 max-h-[95vh] flex flex-col overflow-hidden">

        <div class="flex items-center justify-between p-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Detail Pendaftar</h2>
            <button @click="modalOpen = false" class="text-gray-500 hover:text-gray-700 focus:outline-none" aria-label="Tutup">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="flex-grow p-4 md:p-6 overflow-y-auto" x-show="selectedSantri">
            {{-- Header dengan avatar dan info utama --}}
            <div class="mb-6 pb-6 border-b border-gray-200 flex flex-col items-center md:flex-row md:items-start md:space-x-6">
                <div class="flex-shrink-0 mb-4 md:mb-0">
                    <div class="flex items-center justify-center w-20 h-20 bg-green-100 rounded-full text-green-700 text-3xl font-bold">
                        <span x-text="selectedSantri.nama_panggilan ? selectedSantri.nama_panggilan.slice(0, 1) + selectedSantri.nama_panggilan.slice(1, 2) : 'N/A'"></span>
                    </div>
                </div>
                <div class="text-center md:text-left flex-1">
                    <h3 class="text-2xl font-bold text-gray-900" x-text="selectedSantri.user && selectedSantri.user.name ? selectedSantri.user.name : 'N/A'"></h3>
                    <p class="text-sm text-gray-600 mb-2" x-text="selectedSantri.user ? selectedSantri.user.email : 'N/A'"></p>

                    <div class="flex flex-wrap justify-center md:justify-start gap-4 mt-4">
                        <div class="flex flex-col items-center md:items-start">
                            <span class="text-xs font-semibold text-gray-500">ID Pendaftar</span>
                            <span class="text-sm font-medium text-gray-800" x-text="selectedSantri.id"></span>
                        </div>
                        <div class="flex flex-col items-center md:items-start">
                            <span class="text-xs font-semibold text-gray-500">Tanggal Pendaftaran</span>
                            <span class="text-sm font-medium text-gray-800" x-text="new Date(selectedSantri.created_at).toLocaleDateString('id-ID')"></span>
                        </div>
                        <div class="flex flex-col items-center md:items-start">
                            <span class="text-xs font-semibold text-gray-500">Kategori</span>
                            <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full"
                                  :class="selectedSantri.kategori_pendaftaran === 'Reguler' ? 'text-indigo-700 bg-indigo-100' : 'text-purple-700 bg-purple-100'"
                                  x-text="selectedSantri.kategori_pendaftaran">
                            </span>
                        </div>
                        <div class="flex flex-col items-center md:items-start">
                            <span class="text-xs font-semibold text-gray-500">Status</span>
                            <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full"
                                  :class="selectedSantri.status_pendaftaran === 'diverifikasi' ? 'text-green-700 bg-green-100' : (selectedSantri.status_pendaftaran === 'baru' ? 'text-yellow-700 bg-yellow-100' : 'text-gray-700 bg-gray-100')"
                                  x-text="selectedSantri.status_pendaftaran ? selectedSantri.status_pendaftaran.charAt(0).toUpperCase() + selectedSantri.status_pendaftaran.slice(1) : 'N/A'">
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Data Pribadi --}}
            <div class="mb-6 pb-6 border-b border-gray-200">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Data Pribadi</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <span class="block text-sm font-semibold text-gray-600">Nama Lengkap</span>
                        <p class="text-gray-900" x-text="selectedSantri.user && selectedSantri.user.name ? selectedSantri.user.name : 'N/A'"></p>
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-gray-600">Nama Panggilan</span>
                        <p class="text-gray-900" x-text="selectedSantri.nama_panggilan || 'N/A'"></p>
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-gray-600">Tempat Lahir</span>
                        <p class="text-gray-900" x-text="selectedSantri.tempat_lahir || 'N/A'"></p>
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-gray-600">Tanggal Lahir</span>
                        <p class="text-gray-900" x-text="selectedSantri.tanggal_lahir ? new Date(selectedSantri.tanggal_lahir).toLocaleDateString('id-ID') : 'N/A'"></p>
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-gray-600">Jenis Kelamin</span>
                        <p class="text-gray-900" x-text="selectedSantri.jenis_kelamin || 'N/A'"></p>
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-gray-600">Nomor Handphone</span>
                        <p class="text-gray-900" x-text="selectedSantri.user && selectedSantri.user.no_telp ? selectedSantri.user.no_telp : 'N/A'"></p>
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-gray-600">NIK</span>
                        <p class="text-gray-900" x-text="selectedSantri.nik || 'N/A'"></p>
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-gray-600">Email</span>
                        <p class="text-gray-900" x-text="selectedSantri.user ? selectedSantri.user.email : 'N/A'"></p>
                    </div>
                </div>
            </div>

            {{-- Kartu Indonesia Pintar (KIP) - Hanya untuk Non-Reguler --}}
            <div class="mb-6 pb-6 border-b border-gray-200" x-show="selectedSantri.kategori_pendaftaran === 'Non-Reguler'">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Kartu Indonesia Pintar (KIP)</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span class="block text-sm font-semibold text-gray-600">Nomor Kartu Indonesia Pintar (KIP)</span>
                        <p class="text-gray-900" x-text="selectedSantri.no_kip || 'N/A'"></p>
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-gray-600">Dokumen KIP</span>
                        <div x-show="selectedSantri.kip_document">
                            <a :href="'{{ url('admin/formulir/download-kip') }}/' + selectedSantri.kip_document.id" target="_blank" class="inline-flex items-center px-3 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded-md hover:bg-blue-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z"></path></svg>
                                Unduh Dokumen
                            </a>
                        </div>
                        <p x-show="!selectedSantri.kip_document" class="text-gray-500">Tidak ada dokumen</p>
                    </div>
                </div>
            </div>

            {{-- Asal Sekolah --}}
            <div class="mb-6 pb-6 border-b border-gray-200">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Asal Sekolah</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <span class="block text-sm font-semibold text-gray-600">SD/MI</span>
                        <p class="text-gray-900" x-text="selectedSantri.asal_sd || 'N/A'"></p>
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-gray-600">Tahun Lulus SD</span>
                        <p class="text-gray-900" x-text="selectedSantri.tahun_lulus_sd || 'N/A'"></p>
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-gray-600">SMP/MTs</span>
                        <p class="text-gray-900" x-text="selectedSantri.asal_smp || 'N/A'"></p>
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-gray-600">Tahun Lulus SMP</span>
                        <p class="text-gray-900" x-text="selectedSantri.tahun_lulus_smp || 'N/A'"></p>
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-gray-600">SMA/SMK/MA</span>
                        <p class="text-gray-900" x-text="selectedSantri.asal_sma || 'N/A'"></p>
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-gray-600">Tahun Lulus SMA</span>
                        <p class="text-gray-900" x-text="selectedSantri.tahun_lulus_sma || 'N/A'"></p>
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-gray-600">Universitas</span>
                        <p class="text-gray-900" x-text="selectedSantri.asal_universitas || 'N/A'"></p>
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-gray-600">Fakultas</span>
                        <p class="text-gray-900" x-text="selectedSantri.fakultas || 'N/A'"></p>
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-gray-600">Jurusan</span>
                        <p class="text-gray-900" x-text="selectedSantri.jurusan || 'N/A'"></p>
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-gray-600">Angkatan</span>
                        <p class="text-gray-900" x-text="selectedSantri.angkatan || 'N/A'"></p>
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-gray-600">Semester</span>
                        <p class="text-gray-900" x-text="selectedSantri.semester || 'N/A'"></p>
                    </div>
                </div>
            </div>

            {{-- Alamat --}}
            <div class="mb-6 pb-6 border-b border-gray-200">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Alamat</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <span class="block text-sm font-semibold text-gray-600">Negara</span>
                        <p class="text-gray-900" x-text="selectedSantri.alamat && selectedSantri.alamat.negara ? selectedSantri.alamat.negara : 'Indonesia'"></p>
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-gray-600">Provinsi</span>
                        <p class="text-gray-900" x-text="selectedSantri.alamat && selectedSantri.alamat.provinsi ? selectedSantri.alamat.provinsi : 'N/A'"></p>
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-gray-600">Kota/Kabupaten</span>
<p class="text-gray-900" x-text="selectedSantri.alamat && selectedSantri.alamat.kota_kabupaten ? selectedSantri.alamat.kota_kabupaten : 'N/A'"></p>
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-gray-600">Kecamatan</span>
                        <p class="text-gray-900" x-text="selectedSantri.alamat && selectedSantri.alamat.kecamatan ? selectedSantri.alamat.kecamatan : 'N/A'"></p>
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-gray-600">Desa/Kelurahan</span>
                        <p class="text-gray-900" x-text="selectedSantri.alamat && selectedSantri.alamat.desa_kelurahan ? selectedSantri.alamat.desa_kelurahan : 'N/A'"></p>
                    </div>
                    <div class="md:col-span-2 lg:col-span-4">
                        <span class="block text-sm font-semibold text-gray-600">Alamat Lengkap</span>
                        <p class="text-gray-900" x-text="selectedSantri.alamat && selectedSantri.alamat.alamat_lengkap ? selectedSantri.alamat.alamat_lengkap : 'N/A'"></p>
                    </div>
                </div>
            </div>

            {{-- Data Orang Tua/Wali --}}
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Data Orang Tua / Wali</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <span class="block text-sm font-semibold text-gray-600">Nama Lengkap</span>
                        <p class="text-gray-900" x-text="selectedSantri.parent && selectedSantri.parent.nama_lengkap ? selectedSantri.parent.nama_lengkap : 'N/A'"></p>
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-gray-600">No Handphone</span>
                        <p class="text-gray-900" x-text="selectedSantri.parent && selectedSantri.parent.no_telp ? selectedSantri.parent.no_telp : 'N/A'"></p>
                    </div>
                    <div class="md:col-span-2">
                        <span class="block text-sm font-semibold text-gray-600">Alamat</span>
                        <p class="text-gray-900" x-text="selectedSantri.parent && selectedSantri.parent.alamat ? selectedSantri.parent.alamat : 'N/A'"></p>
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-gray-600">Hubungan Keluarga</span>
                        <p class="text-gray-900" x-text="selectedSantri.parent && selectedSantri.parent.hubungan_keluarga ? selectedSantri.parent.hubungan_keluarga : 'N/A'"></p>
                    </div>
                </div>
            </div>

        </div>

        <div class="p-4 border-t border-gray-200 flex justify-end">
            <button @click="modalOpen = false" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 focus:outline-none">Tutup</button>
        </div>
    </div>
</div>
