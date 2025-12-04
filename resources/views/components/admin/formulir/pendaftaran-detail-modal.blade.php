<div x-show="modalOpen" x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 transition-opacity ease-out duration-300">

    <div x-show="modalOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        class="bg-white rounded-lg shadow-xl w-11/12 md:w-4/5 lg:w-3/4 xl:w-2/3 max-h-[95vh] flex flex-col overflow-hidden">

        {{-- Header Modal Utama --}}
        <div class="flex items-center justify-between p-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Detail Pendaftar</h2>
            <button @click="modalOpen = false" class="text-gray-500 hover:text-gray-700 focus:outline-none" aria-label="Tutup">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        {{-- x-data Scope --}}
        <div class="flex-grow p-4 md:p-6 overflow-y-auto" x-show="selectedSantri"
             x-data="{
                rejectModalOpen: false,
                docVerifModalOpen: false,
                markAllModalOpen: false,
                selectedDocType: '',
                selectedDocLabel: '',
                rejectReason: '',

                // FUNGSI BARU: Cek apakah semua dokumen sudah valid
                checkAllDocsValid() {
                    // 1. Cek Dokumen Wajib
                    let mainDocsValid = this.selectedSantri.status_dokumen_ktp === 'valid' &&
                                        this.selectedSantri.status_dokumen_kk === 'valid' &&
                                        this.selectedSantri.status_dokumen_ijazah === 'valid';

                    // 2. Cek KIP (Hanya jika Non-Reguler)
                    if (this.selectedSantri.kategori_pendaftaran === 'Non-Reguler') {
                        // Jika punya dokumen KIP, cek statusnya. Jika tidak punya, anggap belum valid.
                        const kipValid = this.selectedSantri.kip_document &&
                                         this.selectedSantri.kip_document.status_verifikasi === 'valid';
                        return mainDocsValid && kipValid;
                    }

                    return mainDocsValid;
                },

                submitDocumentStatus(type, status, reason = null) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('admin.formulir.dokumen.update') }}';
                    form.appendChild(this.createInput('_token', '{{ csrf_token() }}'));
                    form.appendChild(this.createInput('formulir_id', this.selectedSantri.id));
                    form.appendChild(this.createInput('jenis_dokumen', type));
                    form.appendChild(this.createInput('status', status));

                    if(reason) {
                        form.appendChild(this.createInput('alasan', reason));
                    }
                    document.body.appendChild(form);
                    form.submit();
                },

                submitMarkAll() {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ url('admin/formulir') }}/${this.selectedSantri.id}/verifikasi-semua-dokumen`;
                    form.appendChild(this.createInput('_token', '{{ csrf_token() }}'));

                    document.body.appendChild(form);
                    form.submit();
                },

                createInput(name, value) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = name;
                    input.value = value;
                    return input;
                },

                openRejectModal(type, label) {
                    this.selectedDocType = type;
                    this.selectedDocLabel = label;
                    this.rejectReason = '';
                    this.rejectModalOpen = true;
                },
                openDocVerifModal(type, label) {
                    this.selectedDocType = type;
                    this.selectedDocLabel = label;
                    this.docVerifModalOpen = true;
                }
             }">

            {{-- 1. Header Profile --}}
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
                                :class="selectedSantri.status_pendaftaran === 'diverifikasi' ? 'text-green-700 bg-green-100' :
                                        (selectedSantri.status_pendaftaran === 'ditolak' ? 'text-red-700 bg-red-100' :
                                        (selectedSantri.status_pendaftaran === 'menunggu_verifikasi' ? 'text-yellow-700 bg-yellow-100' : 'text-gray-700 bg-gray-100'))"
                                x-text="selectedSantri.status_pendaftaran ? selectedSantri.status_pendaftaran.replace('_', ' ').charAt(0).toUpperCase() + selectedSantri.status_pendaftaran.replace('_', ' ').slice(1) : 'N/A'">
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. Data Pribadi --}}
            <div class="mb-6 pb-6 border-b border-gray-200">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Data Pribadi</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div><span class="block text-sm font-semibold text-gray-600">Nama Lengkap</span><p class="text-gray-900" x-text="selectedSantri.user && selectedSantri.user.name ? selectedSantri.user.name : 'N/A'"></p></div>
                    <div><span class="block text-sm font-semibold text-gray-600">Nama Panggilan</span><p class="text-gray-900" x-text="selectedSantri.nama_panggilan || 'N/A'"></p></div>
                    <div><span class="block text-sm font-semibold text-gray-600">Tempat Lahir</span><p class="text-gray-900" x-text="selectedSantri.tempat_lahir || 'N/A'"></p></div>
                    <div><span class="block text-sm font-semibold text-gray-600">Tanggal Lahir</span><p class="text-gray-900" x-text="selectedSantri.tanggal_lahir ? new Date(selectedSantri.tanggal_lahir).toLocaleDateString('id-ID') : 'N/A'"></p></div>
                    <div><span class="block text-sm font-semibold text-gray-600">Jenis Kelamin</span><p class="text-gray-900" x-text="selectedSantri.jenis_kelamin || 'N/A'"></p></div>
                    <div><span class="block text-sm font-semibold text-gray-600">Nomor Handphone</span><p class="text-gray-900" x-text="selectedSantri.user && selectedSantri.user.no_telp ? selectedSantri.user.no_telp : 'N/A'"></p></div>
                    <div><span class="block text-sm font-semibold text-gray-600">NIK</span><p class="text-gray-900" x-text="selectedSantri.nik || 'N/A'"></p></div>
                    <div><span class="block text-sm font-semibold text-gray-600">Email</span><p class="text-gray-900" x-text="selectedSantri.user ? selectedSantri.user.email : 'N/A'"></p></div>
                </div>
            </div>

            {{-- 3. Kartu Indonesia Pintar (KIP) --}}
            <div class="mb-6 pb-6 border-b border-gray-200" x-show="selectedSantri.kategori_pendaftaran === 'Non-Reguler'">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Kartu Indonesia Pintar (KIP)</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Kiri: Nomor KIP (Tanpa Badge) --}}
                    <div>
                        <span class="block text-sm font-semibold text-gray-600">Nomor Kartu Indonesia Pintar (KIP)</span>
                        <p class="text-gray-900" x-text="selectedSantri.kip_document ? selectedSantri.kip_document.no_kip : 'N/A'"></p>
                    </div>

                    {{-- Kanan: Dokumen & Badge --}}
                    <div>
                        <div class="flex justify-between items-end mb-2">
                            <span class="block text-sm font-semibold text-gray-600">Dokumen KIP</span>

                            {{-- BADGE STATUS KIP --}}
                            <div x-show="selectedSantri.kip_document">
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded uppercase"
                                    :class="{
                                        'bg-yellow-100 text-yellow-800': !selectedSantri.kip_document.status_verifikasi || selectedSantri.kip_document.status_verifikasi == 'pending',
                                        'bg-green-100 text-green-800': selectedSantri.kip_document.status_verifikasi == 'valid',
                                        'bg-red-100 text-red-800': selectedSantri.kip_document.status_verifikasi == 'tidak_valid'
                                    }"
                                    x-text="(!selectedSantri.kip_document.status_verifikasi || selectedSantri.kip_document.status_verifikasi == 'pending') ? 'PENDING' : (selectedSantri.kip_document.status_verifikasi == 'valid' ? 'VALID' : 'DITOLAK')">
                                </span>
                            </div>
                        </div>

                        <template x-if="selectedSantri.kip_document && selectedSantri.kip_document.dokumen_path">
                            <div class="mt-2">
                                <a :href="`{{ url('admin/formulir/download-kip') }}/${selectedSantri.kip_document.id}`"
                                    target="_blank"
                                    class="inline-flex items-center px-3 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded-md hover:bg-blue-200 mb-2">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z"></path></svg>
                                    Unduh Dokumen
                                </a>
                                <div class="relative">
                                    <img :src="`{{ asset('storage') }}/${selectedSantri.kip_document.dokumen_path}`"
                                        alt="Preview Dokumen KIP"
                                        class="max-w-xs max-h-48 rounded border border-gray-200 shadow-sm object-contain"
                                        x-on:error="$el.src='https://via.placeholder.com/300x200?text=Preview+Gagal+Dimuat'">
                                </div>

                                <p x-show="selectedSantri.kip_document.status_verifikasi == 'tidak_valid'" class="text-xs text-red-600 mt-1 bg-red-50 p-2 rounded border border-red-100" x-text="'Alasan: ' + (selectedSantri.kip_document.alasan_penolakan || '-')"></p>

                                <div class="flex gap-2 mt-3 max-w-xs"
                                     x-show="selectedSantri.status_pendaftaran === 'menunggu_verifikasi' && (!selectedSantri.kip_document || selectedSantri.kip_document.status_verifikasi !== 'valid')">

                                    <button @click="openDocVerifModal('kip', 'KIP')"
                                        class="flex-1 bg-green-50 text-green-700 border border-green-200 hover:bg-green-100 px-2 py-1.5 rounded text-xs font-medium transition">
                                        Valid
                                    </button>
                                    <button @click="openRejectModal('kip', 'KIP')"
                                        class="flex-1 bg-red-50 text-red-700 border border-red-200 hover:bg-red-100 px-2 py-1.5 rounded text-xs font-medium transition">
                                        Tolak
                                    </button>
                                </div>
                            </div>
                        </template>
                        <template x-if="!selectedSantri.kip_document || !selectedSantri.kip_document.dokumen_path">
                            <p class="text-gray-500 mt-2">Tidak ada dokumen yang diunggah.</p>
                        </template>
                    </div>
                </div>
            </div>

            {{-- 4, 5, 6: Asal Sekolah, Alamat, Orang Tua --}}
            <div class="mb-6 pb-6 border-b border-gray-200"><h4 class="text-lg font-semibold text-gray-800 mb-4">Asal Sekolah</h4><div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4"><div><span class="block text-sm font-semibold text-gray-600">SD/MI</span><p class="text-gray-900" x-text="selectedSantri.asal_sd || 'N/A'"></p></div><div><span class="block text-sm font-semibold text-gray-600">Tahun Lulus SD</span><p class="text-gray-900" x-text="selectedSantri.tahun_lulus_sd || 'N/A'"></p></div><div><span class="block text-sm font-semibold text-gray-600">SMP/MTs</span><p class="text-gray-900" x-text="selectedSantri.asal_smp || 'N/A'"></p></div><div><span class="block text-sm font-semibold text-gray-600">Tahun Lulus SMP</span><p class="text-gray-900" x-text="selectedSantri.tahun_lulus_smp || 'N/A'"></p></div><div><span class="block text-sm font-semibold text-gray-600">SMA/SMK/MA</span><p class="text-gray-900" x-text="selectedSantri.asal_sma || 'N/A'"></p></div><div><span class="block text-sm font-semibold text-gray-600">Tahun Lulus SMA</span><p class="text-gray-900" x-text="selectedSantri.tahun_lulus_sma || 'N/A'"></p></div><div><span class="block text-sm font-semibold text-gray-600">Universitas</span><p class="text-gray-900" x-text="selectedSantri.asal_universitas || 'N/A'"></p></div><div><span class="block text-sm font-semibold text-gray-600">Fakultas</span><p class="text-gray-900" x-text="selectedSantri.fakultas || 'N/A'"></p></div><div><span class="block text-sm font-semibold text-gray-600">Jurusan</span><p class="text-gray-900" x-text="selectedSantri.jurusan || 'N/A'"></p></div><div><span class="block text-sm font-semibold text-gray-600">Angkatan</span><p class="text-gray-900" x-text="selectedSantri.angkatan || 'N/A'"></p></div><div><span class="block text-sm font-semibold text-gray-600">Semester</span><p class="text-gray-900" x-text="selectedSantri.semester || 'N/A'"></p></div></div></div>
            <div class="mb-6 pb-6 border-b border-gray-200"><h4 class="text-lg font-semibold text-gray-800 mb-4">Alamat</h4><div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4"><div><span class="block text-sm font-semibold text-gray-600">Provinsi</span><p class="text-gray-900" x-text="selectedSantri.alamat && selectedSantri.alamat.provinsi ? selectedSantri.alamat.provinsi : 'N/A'"></p></div><div class="md:col-span-2 lg:col-span-4"><span class="block text-sm font-semibold text-gray-600">Alamat Lengkap</span><p class="text-gray-900" x-text="selectedSantri.alamat && selectedSantri.alamat.alamat_lengkap ? selectedSantri.alamat.alamat_lengkap : 'N/A'"></p></div></div></div>
            <div class="mb-6"><h4 class="text-lg font-semibold text-gray-800 mb-4">Data Orang Tua / Wali</h4><div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4"><div><span class="block text-sm font-semibold text-gray-600">Nama Lengkap</span><p class="text-gray-900" x-text="selectedSantri.parent && selectedSantri.parent.nama_lengkap ? selectedSantri.parent.nama_lengkap : 'N/A'"></p></div><div><span class="block text-sm font-semibold text-gray-600">No Handphone</span><p class="text-gray-900" x-text="selectedSantri.parent && selectedSantri.parent.no_telp ? selectedSantri.parent.no_telp : 'N/A'"></p></div></div></div>

            {{-- 7. Dokumen Pendukung --}}
            <div class="mb-6 pb-6 border-b border-gray-200">

                {{-- HEADER DOKUMEN --}}
                <div class="flex flex-col md:flex-row justify-between items-center mb-4">
                    <h4 class="text-lg font-semibold text-gray-800">Dokumen Pendukung</h4>

                    {{-- TOMBOL VERIFIKASI SEMUA (DENGAN LOGIKA HIDE JIKA SEMUA VALID) --}}
                    {{-- Hanya muncul jika:
                         1. Status pendaftaran 'menunggu_verifikasi'
                         2. Masih ada dokumen yang BELUM valid (!checkAllDocsValid)
                    --}}
                    <div x-show="selectedSantri.status_pendaftaran === 'menunggu_verifikasi' && !checkAllDocsValid()">
                        <button @click="markAllModalOpen = true"
                            class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            Tandai Semua Valid
                        </button>
                    </div>
                </div>

                {{-- GRID DOKUMEN --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach([
                        ['type' => 'ktp', 'label' => 'Scan KTP', 'field' => 'dokumen_ktp', 'status' => 'status_dokumen_ktp', 'reason' => 'alasan_tolak_ktp'],
                        ['type' => 'kk', 'label' => 'Scan KK', 'field' => 'dokumen_kk', 'status' => 'status_dokumen_kk', 'reason' => 'alasan_tolak_kk'],
                        ['type' => 'ijazah', 'label' => 'Ijazah Terakhir', 'field' => 'dokumen_ijazah', 'status' => 'status_dokumen_ijazah', 'reason' => 'alasan_tolak_ijazah']
                    ] as $doc)

                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 flex flex-col items-center text-center">
                        <div class="flex justify-between w-full items-start mb-3">
                            <span class="text-sm font-semibold text-gray-600">{{ $doc['label'] }}</span>

                            {{-- BADGE STATUS KTP/KK/IJAZAH --}}
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded uppercase"
                                :class="{
                                    'bg-yellow-100 text-yellow-800': selectedSantri.{{ $doc['status'] }} == 'pending',
                                    'bg-green-100 text-green-800': selectedSantri.{{ $doc['status'] }} == 'valid',
                                    'bg-red-100 text-red-800': selectedSantri.{{ $doc['status'] }} == 'invalid'
                                }"
                                x-text="selectedSantri.{{ $doc['status'] }} || 'PENDING'">
                            </span>
                        </div>

                        <template x-if="selectedSantri.{{ $doc['field'] }}">
                            <div class="w-full">
                                <div class="h-40 w-full bg-gray-200 rounded overflow-hidden flex items-center justify-center border cursor-pointer hover:bg-gray-300 transition relative group mb-3"
                                    @click="window.open(`{{ asset('storage') }}/${selectedSantri.{{ $doc['field'] }}}`, '_blank')"
                                    title="Klik untuk melihat file">

                                    <template x-if="selectedSantri.{{ $doc['field'] }}.toLowerCase().endsWith('.pdf')">
                                        <div class="text-red-500 flex flex-col items-center group-hover:scale-110 transition duration-300">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                            <span class="text-xs mt-2 font-bold text-gray-700">Lihat PDF</span>
                                        </div>
                                    </template>
                                    <template x-if="!selectedSantri.{{ $doc['field'] }}.toLowerCase().endsWith('.pdf')">
                                        <img :src="`{{ asset('storage') }}/${selectedSantri.{{ $doc['field'] }}}`" class="w-full h-full object-contain group-hover:opacity-80 transition duration-300" alt="Preview">
                                    </template>
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition duration-300 flex items-center justify-center">
                                        <span class="bg-white bg-opacity-90 px-2 py-1 rounded text-xs font-semibold shadow opacity-0 group-hover:opacity-100 transition duration-300">Buka File</span>
                                    </div>
                                </div>

                                <p x-show="selectedSantri.{{ $doc['status'] }} == 'invalid'" class="text-xs text-red-600 mb-2 bg-red-50 p-2 rounded border border-red-100 text-left" x-text="'Alasan: ' + (selectedSantri.{{ $doc['reason'] }} || '-')"></p>

                                <div class="flex gap-2 w-full"
                                     x-show="selectedSantri.status_pendaftaran === 'menunggu_verifikasi' && selectedSantri.{{ $doc['status'] }} !== 'valid'">

                                    <button @click="openDocVerifModal('{{ $doc['type'] }}', '{{ $doc['label'] }}')"
                                        class="flex-1 bg-green-50 hover:bg-green-100 text-green-700 border border-green-200 px-2 py-1.5 rounded text-xs flex items-center justify-center gap-1 transition font-medium">
                                        Valid
                                    </button>
                                    <button @click="openRejectModal('{{ $doc['type'] }}', '{{ $doc['label'] }}')"
                                        class="flex-1 bg-red-50 hover:bg-red-100 text-red-700 border border-red-200 px-2 py-1.5 rounded text-xs flex items-center justify-center gap-1 transition font-medium">
                                        Tolak
                                    </button>
                                </div>
                            </div>
                        </template>

                        <template x-if="!selectedSantri.{{ $doc['field'] }}">
                            <div class="flex flex-col items-center justify-center h-40 w-full text-gray-400 border-2 border-dashed border-gray-300 rounded">
                                <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                <span class="text-xs">Belum diunggah</span>
                            </div>
                        </template>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Include Modals --}}
            @include('components.admin.formulir.pendaftaran-tolak-dokumen-modal')
            @include('components.admin.formulir.pendaftaran-verifikasi-dokumen-modal')
            @include('components.admin.formulir.pendaftaran-verifikasi-semua-modal')

        </div>
        {{-- End x-data --}}

        {{-- Footer Modal Utama --}}
        <div class="p-4 border-t border-gray-200 flex justify-end">
            <button @click="modalOpen = false" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 focus:outline-none">Tutup</button>
        </div>
    </div>
</div>
