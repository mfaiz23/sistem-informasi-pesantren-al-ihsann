{{-- File: resources/views/profile/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Profil Calon Santri
            </h2>

            {{-- Ganti class pada tombol ini --}}
            <a href="{{ route('dashboard') }}"
                class="inline-block bg-blue-500 text-white font-semibold py-2 px-5 rounded-lg shadow-md hover:bg-blue-600 transition duration-300 text-sm">
                Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">

                    {{-- Tampilkan pesan sukses jika ada --}}
                    @if (session('status') === 'profile-updated')
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                            <p class="font-bold">Sukses!</p>
                            <p>Data profil Anda berhasil diperbarui.</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        {{-- Langsung include semua partials tanpa <details> --}}
                            @include('formulir.partials.data-pribadi', ['formulir' => $formulir])
                            @include('formulir.partials.asal-sekolah', ['formulir' => $formulir])
                            @include('formulir.partials.alamat', ['alamat' => $formulir->alamat])
                            @include('formulir.partials.data-orang-tua', ['parent' => $formulir->parent])
                            @include('formulir.partials.dokumen-pendukung', ['formulir' => $formulir])

                            <div class="flex justify-center mt-8">
                                <x-primary-button
                                    class="!bg-[#028579] hover:!bg-[#016e63] active:!bg-[#016e63] focus:!ring-[#016e63]">
                                    {{ __('Simpan Perubahan') }}
                                </x-primary-button>
                            </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // --- SCRIPT API WILAYAH (UNTUK EDIT) ---

                const apiBaseUrl = 'https://www.emsifa.com/api-wilayah-indonesia/api';

                // Ambil elemen select dan input tersembunyi
                const provinsiSelect = document.getElementById('provinsi');
                const kotaSelect = document.getElementById('kota_kabupaten');
                const kecamatanSelect = document.getElementById('kecamatan');
                const desaSelect = document.getElementById('desa_kelurahan');

                const provinsiNamaInput = document.getElementById('provinsi_nama');
                const kotaNamaInput = document.getElementById('kota_kabupaten_nama');
                const kecamatanNamaInput = document.getElementById('kecamatan_nama');
                const desaNamaInput = document.getElementById('desa_kelurahan_nama');

                // Ambil nilai yang sudah tersimpan dari database (dilewatkan dari Blade)
                const savedProvinsi = '{{ old('provinsi', optional($formulir->alamat)->provinsi ?? '') }}';
                const savedKota = '{{ old('kota_kabupaten', optional($formulir->alamat)->kota_kabupaten ?? '') }}';
                const savedKecamatan = '{{ old('kecamatan', optional($formulir->alamat)->kecamatan ?? '') }}';
                const savedDesa = '{{ old('desa_kelurahan', optional($formulir->alamat)->desa_kelurahan ?? '') }}';

                // Fungsi untuk populate dan auto-select
                function populateSelect(selectElement, data, nameField, idField, selectedValue, callback = null) {
                    selectElement.innerHTML = `<option value="" disabled>Pilih ${selectElement.previousElementSibling.innerText}</option>`;
                    let selectedId = null;

                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item[idField];
                        option.textContent = item[nameField];
                        if (item[nameField] === selectedValue) {
                            option.selected = true;
                            selectedId = item[idField];
                        }
                        selectElement.appendChild(option);
                    });

                    // Jika ada item yang terpilih (dari data lama), panggil callback untuk memuat data turunan
                    if (callback && selectedId) {
                        callback(selectedId);
                    }
                }

                // 1. Ambil data Provinsi
                fetch(`${apiBaseUrl}/provinces.json`)
                    .then(response => response.json())
                    .then(provinces => {
                        populateSelect(provinsiSelect, provinces, 'name', 'id', savedProvinsi, (provinceId) => {
                            // 2. Jika provinsi terpilih, ambil data Kota/Kabupaten
                            kotaSelect.innerHTML = '<option value="" disabled selected>Memuat...</option>';
                            fetch(`${apiBaseUrl}/regencies/${provinceId}.json`)
                                .then(response => response.json())
                                .then(regencies => {
                                    populateSelect(kotaSelect, regencies, 'name', 'id', savedKota, (regencyId) => {
                                        // 3. Jika kota terpilih, ambil data Kecamatan
                                        kecamatanSelect.innerHTML = '<option value="" disabled selected>Memuat...</option>';
                                        fetch(`${apiBaseUrl}/districts/${regencyId}.json`)
                                            .then(response => response.json())
                                            .then(districts => {
                                                populateSelect(kecamatanSelect, districts, 'name', 'id', savedKecamatan, (districtId) => {
                                                    // 4. Jika kecamatan terpilih, ambil data Desa
                                                    desaSelect.innerHTML = '<option value="" disabled selected>Memuat...</option>';
                                                    fetch(`${apiBaseUrl}/villages/${districtId}.json`)
                                                        .then(response => response.json())
                                                        .then(villages => {
                                                            populateSelect(desaSelect, villages, 'name', 'id', savedDesa);
                                                        });
                                                });
                                            });
                                    });
                                });
                        });
                    });

                // --- Event listener untuk perubahan MANUAL oleh user ---

                provinsiSelect.addEventListener('change', function () {
                    const provinceId = this.value;
                    provinsiNamaInput.value = this.options[this.selectedIndex].text;
                    kotaNamaInput.value = ''; // Reset
                    kecamatanNamaInput.value = '';
                    desaNamaInput.value = '';

                    kotaSelect.innerHTML = '<option value="" disabled selected>Memuat...</option>';
                    kecamatanSelect.innerHTML = '<option value..." disabled selected>Pilih Kecamatan</option>';
                    desaSelect.innerHTML = '<option value="" disabled selected>Pilih Desa/Kelurahan</option>';

                    fetch(`${apiBaseUrl}/regencies/${provinceId}.json`)
                        .then(response => response.json())
                        .then(regencies => {
                            populateSelect(kotaSelect, regencies, 'name', 'id', null); // null karena ini pilihan baru
                        });
                });

                kotaSelect.addEventListener('change', function () {
                    const regencyId = this.value;
                    kotaNamaInput.value = this.options[this.selectedIndex].text;
                    kecamatanNamaInput.value = '';
                    desaNamaInput.value = '';

                    kecamatanSelect.innerHTML = '<option value="" disabled selected>Memuat...</option>';
                    desaSelect.innerHTML = '<option value="" disabled selected>Pilih Desa/Kelurahan</option>';

                    fetch(`${apiBaseUrl}/districts/${regencyId}.json`)
                        .then(response => response.json())
                        .then(districts => {
                            populateSelect(kecamatanSelect, districts, 'name', 'id', null);
                        });
                });

                kecamatanSelect.addEventListener('change', function () {
                    const districtId = this.value;
                    kecamatanNamaInput.value = this.options[this.selectedIndex].text;
                    desaNamaInput.value = '';

                    desaSelect.innerHTML = '<option value="" disabled selected>Memuat...</option>';

                    fetch(`${apiBaseUrl}/villages/${districtId}.json`)
                        .then(response => response.json())
                        .then(villages => {
                            populateSelect(desaSelect, villages, 'name', 'id', null);
                        });
                });

                desaSelect.addEventListener('change', function () {
                    desaNamaInput.value = this.options[this.selectedIndex].text;
                });
            });
        </script>
    @endpush
</x-app-layout>