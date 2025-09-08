<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Formulir Pendaftaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
                <p>Mohon isi formulir pendaftaran dengan benar!</p>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6"
                            role="alert">
                            <strong class="font-bold">Oops! Ada yang salah:</strong>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('formulir.store') }}" enctype="multipart/form-data">
                        @csrf

                        @include('formulir.partials.data-pribadi')
                        @include('formulir.partials.asal-sekolah')
                        @include('formulir.partials.alamat')
                        @include('formulir.partials.data-orang-tua')

                        <div class="flex justify-center mt-8">
                            <x-primary-button class="bg-[#028579] hover:bg-[#016a60]">
                                {{ __('SIMPAN DATA') }}
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
                const provinsiSelect = document.getElementById('provinsi');
                const kotaSelect = document.getElementById('kota_kabupaten');
                const kecamatanSelect = document.getElementById('kecamatan');
                const desaSelect = document.getElementById('desa_kelurahan');

                // Mengambil input tersembunyi
                const provinsiNamaInput = document.getElementById('provinsi_nama');
                const kotaNamaInput = document.getElementById('kota_kabupaten_nama');
                const kecamatanNamaInput = document.getElementById('kecamatan_nama');
                const desaNamaInput = document.getElementById('desa_kelurahan_nama');

                const apiBaseUrl = 'https://www.emsifa.com/api-wilayah-indonesia/api';

                function populateSelect(selectElement, data, nameField, idField) {
                    selectElement.innerHTML = `<option value="" disabled selected>Pilih ${selectElement.previousElementSibling.innerText}</option>`;
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item[idField]; // Tetap gunakan ID untuk value
                        option.textContent = item[nameField];
                        selectElement.appendChild(option);
                    });
                }

                // 1. Ambil data Provinsi
                fetch(`${apiBaseUrl}/provinces.json`)
                    .then(response => response.json())
                    .then(provinces => {
                        populateSelect(provinsiSelect, provinces, 'name', 'id');
                    });

                // 2. Event listener untuk Provinsi
                provinsiSelect.addEventListener('change', function () {
                    const provinceId = this.value;
                    // Simpan nama provinsi ke input tersembunyi
                    provinsiNamaInput.value = this.options[this.selectedIndex].text;

                    kotaSelect.innerHTML = '<option value="" disabled selected>Memuat...</option>';
                    kecamatanSelect.innerHTML = '<option value="" disabled selected>Pilih Kecamatan</option>';
                    desaSelect.innerHTML = '<option value="" disabled selected>Pilih Desa/Kelurahan</option>';

                    fetch(`${apiBaseUrl}/regencies/${provinceId}.json`)
                        .then(response => response.json())
                        .then(regencies => {
                            populateSelect(kotaSelect, regencies, 'name', 'id');
                        });
                });

                // 3. Event listener untuk Kota/Kabupaten
                kotaSelect.addEventListener('change', function () {
                    const regencyId = this.value;
                    // Simpan nama kota ke input tersembunyi
                    kotaNamaInput.value = this.options[this.selectedIndex].text;

                    kecamatanSelect.innerHTML = '<option value="" disabled selected>Memuat...</option>';
                    desaSelect.innerHTML = '<option value="" disabled selected>Pilih Desa/Kelurahan</option>';

                    fetch(`${apiBaseUrl}/districts/${regencyId}.json`)
                        .then(response => response.json())
                        .then(districts => {
                            populateSelect(kecamatanSelect, districts, 'name', 'id');
                        });
                });

                // 4. Event listener untuk Kecamatan
                kecamatanSelect.addEventListener('change', function () {
                    const districtId = this.value;
                    // Simpan nama kecamatan ke input tersembunyi
                    kecamatanNamaInput.value = this.options[this.selectedIndex].text;

                    desaSelect.innerHTML = '<option value="" disabled selected>Memuat...</option>';

                    fetch(`${apiBaseUrl}/villages/${districtId}.json`)
                        .then(response => response.json())
                        .then(villages => {
                            populateSelect(desaSelect, villages, 'name', 'id');
                        });
                });

                // 5. Event listener untuk Desa/Kelurahan
                desaSelect.addEventListener('change', function () {
                    // Simpan nama desa ke input tersembunyi
                    desaNamaInput.value = this.options[this.selectedIndex].text;
                });
            });
        </script>
    @endpush
</x-app-layout>