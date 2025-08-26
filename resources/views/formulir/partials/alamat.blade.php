@props(['alamat' => null, 'disabled' => false])

{{-- 1. Inisialisasi Alpine.js untuk semua field alamat --}}
<div class="pt-8" x-data="{
    negara: '{{ old('negara', $alamat->negara ?? 'Indonesia') }}',
    provinsi: '{{ old('provinsi', $alamat->provinsi ?? '') }}',
    kota_kabupaten: '{{ old('kota_kabupaten', $alamat->kota_kabupaten ?? '') }}',
    kecamatan: '{{ old('kecamatan', $alamat->kecamatan ?? '') }}',
    desa_kelurahan: '{{ old('desa_kelurahan', $alamat->desa_kelurahan ?? '') }}',
    alamat_lengkap: `{{ old('alamat_lengkap', $alamat->alamat_lengkap ?? '') }}`
}">
    {{-- HEADER --}}
    <div class="flex items-baseline border-b pb-4 mb-6">
        <h3 class="text-lg font-semibold text-gray-800">ALAMAT</h3>
        <span x-show="!negara || !provinsi || !kota_kabupaten || !kecamatan || !desa_kelurahan || !alamat_lengkap"
            class="ml-4 text-sm font-medium text-red-600" style="display: none;">
            Data Belum Lengkap
        </span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-8">

        <div>
            <x-input-label for="negara" value="Negara" />
            <select id="negara_select" name="negara_display" x-model="negara"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $disabled ? 'bg-gray-100' : '' }}"
                required {{ $disabled ? 'disabled' : '' }}>
                <option value="" disabled>Pilih Negara</option>
                <option value="Indonesia">Indonesia</option>
            </select>
            <input type="hidden" name="negara" x-bind:value="negara">
            <p x-show="!negara" class="text-xs text-red-600 mt-1" style="display: none;">*Wajib diisi</p>
        </div>

        <div></div>

        <div>
            <x-input-label for="provinsi" value="Provinsi" />
            {{-- PERUBAHAN DI SINI --}}
            <select id="provinsi" name="provinsi_id" x-model="provinsi"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $disabled ? 'bg-gray-100' : '' }}"
                required {{ $disabled ? 'disabled' : '' }}>
                @if($alamat && $alamat->provinsi)
                    <option value="{{ $alamat->provinsi }}" selected>{{ $alamat->provinsi }}</option>
                @else
                    <option value="" disabled selected>Pilih Provinsi</option>
                @endif
            </select>
            <input type="hidden" name="provinsi" id="provinsi_nama" x-bind:value="provinsi">
            <p x-show="!provinsi" class="text-xs text-red-600 mt-1" style="display: none;">*Wajib diisi</p>
        </div>

        <div>
            <x-input-label for="kota_kabupaten" value="Kota / Kabupaten" />
            {{-- PERUBAHAN DI SINI --}}
            <select id="kota_kabupaten" name="kota_kabupaten_id" x-model="kota_kabupaten"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $disabled ? 'bg-gray-100' : '' }}"
                required {{ $disabled ? 'disabled' : '' }}>
                @if($alamat && $alamat->kota_kabupaten)
                    <option value="{{ $alamat->kota_kabupaten }}" selected>{{ $alamat->kota_kabupaten }}</option>
                @else
                    <option value="" disabled selected>Pilih Kota/Kabupaten</option>
                @endif
            </select>
            <input type="hidden" name="kota_kabupaten" id="kota_kabupaten_nama" x-bind:value="kota_kabupaten">
            <p x-show="!kota_kabupaten" class="text-xs text-red-600 mt-1" style="display: none;">*Wajib diisi</p>
        </div>

        <div>
            <x-input-label for="kecamatan" value="Kecamatan" />

            <select id="kecamatan" name="kecamatan_id" x-model="kecamatan"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $disabled ? 'bg-gray-100' : '' }}"
                required {{ $disabled ? 'disabled' : '' }}>
                @if($alamat && $alamat->kecamatan)
                    <option value="{{ $alamat->kecamatan }}" selected>{{ $alamat->kecamatan }}</option>
                @else
                    <option value="" disabled selected>Pilih Kecamatan</option>
                @endif
            </select>
            <input type="hidden" name="kecamatan" id="kecamatan_nama" x-bind:value="kecamatan">
            <p x-show="!kecamatan" class="text-xs text-red-600 mt-1" style="display: none;">*Wajib diisi</p>
        </div>

        <div>
            <x-input-label for="desa_kelurahan" value="Desa / Kelurahan" />
            <select id="desa_kelurahan" name="desa_kelurahan_id" x-model="desa_kelurahan"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $disabled ? 'bg-gray-100' : '' }}"
                required {{ $disabled ? 'disabled' : '' }}>
                @if($alamat && $alamat->desa_kelurahan)
                    <option value="{{ $alamat->desa_kelurahan }}" selected>{{ $alamat->desa_kelurahan }}</option>
                @else
                    <option value="" disabled selected>Pilih Desa/Kelurahan</option>
                @endif
            </select>
            <input type="hidden" name="desa_kelurahan" id="desa_kelurahan_nama" x-bind:value="desa_kelurahan">
            <p x-show="!desa_kelurahan" class="text-xs text-red-600 mt-1" style="display: none;">*Wajib diisi</p>
        </div>

        <div class="md:col-span-2">
            <x-input-label for="alamat_lengkap" value="Alamat Lengkap" />
            <textarea id="alamat_lengkap" name="alamat_lengkap" rows="4" x-model="alamat_lengkap"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $disabled ? 'bg-gray-100' : '' }}"
                placeholder="Masukan Alamat Lengkap" {{ $disabled ? 'disabled' : '' }}>{{ old('alamat_lengkap', $alamat->alamat_lengkap ?? '') }}</textarea>
            <p x-show="!alamat_lengkap" class="text-xs text-red-600 mt-1" style="display: none;">*Wajib diisi</p>
        </div>
    </div>
</div>