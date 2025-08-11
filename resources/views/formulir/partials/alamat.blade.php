@props(['alamat' => null, 'disabled' => false])

<div class="pt-8">
    <h3 class="text-lg font-semibold text-gray-800 border-b pb-4 mb-6">ALAMAT</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-8">

        <div>
            <x-input-label for="negara" value="Negara" />
            <select id="negara" name="negara"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                required {{ $disabled ? 'disabled' : '' }}>
                <option value="Indonesia" @if(old('negara', $alamat->negara ?? '') == 'Indonesia') selected @endif>
                    Indonesia</option>
            </select>
            <p class="text-xs text-red-600 mt-1">*Wajib diisi</p>
            <x-input-error :messages="$errors->get('negara')" class="mt-2" />
        </div>

        <div></div> {{-- Kolom kosong untuk alignment --}}

        <div x-data="{ value: '{{ old('provinsi', $alamat->provinsi ?? '') }}' }">
            <x-input-label for="provinsi" value="Provinsi" />
            <select id="provinsi" name="provinsi" x-model="value"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                required {{ $disabled ? 'disabled' : '' }}>
                @if($alamat && $alamat->provinsi)
                    <option value="{{ $alamat->provinsi }}" selected>{{ $alamat->provinsi }}</option>
                @else
                    <option value="" disabled selected>Pilih Provinsi</option>
                @endif
            </select>
            <p x-show="!value && !{{ $disabled ? 'true' : 'false' }}" class="text-xs text-red-600 mt-1">*Wajib diisi</p>
            <x-input-error :messages="$errors->get('provinsi')" class="mt-2" />
        </div>

        <div x-data="{ value: '{{ old('kota_kabupaten', $alamat->kota_kabupaten ?? '') }}' }">
            <x-input-label for="kota_kabupaten" value="Kota / Kabupaten" />
            <select id="kota_kabupaten" name="kota_kabupaten" x-model="value"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                required {{ $disabled ? 'disabled' : '' }}>
                @if($alamat && $alamat->kota_kabupaten)
                    <option value="{{ $alamat->kota_kabupaten }}" selected>{{ $alamat->kota_kabupaten }}</option>
                @else
                    <option value="" disabled selected>Pilih Kota/Kabupaten</option>
                @endif
            </select>
            <p x-show="!value && !{{ $disabled ? 'true' : 'false' }}" class="text-xs text-red-600 mt-1">*Wajib diisi</p>
            <x-input-error :messages="$errors->get('kota_kabupaten')" class="mt-2" />
        </div>

        <div x-data="{ value: '{{ old('kecamatan', $alamat->kecamatan ?? '') }}' }">
            <x-input-label for="kecamatan" value="Kecamatan" />
            <select id="kecamatan" name="kecamatan" x-model="value"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                required {{ $disabled ? 'disabled' : '' }}>
                @if($alamat && $alamat->kecamatan)
                    <option value="{{ $alamat->kecamatan }}" selected>{{ $alamat->kecamatan }}</option>
                @else
                    <option value="" disabled selected>Pilih Kecamatan</option>
                @endif
            </select>
            <p x-show="!value && !{{ $disabled ? 'true' : 'false' }}" class="text-xs text-red-600 mt-1">*Wajib diisi</p>
            <x-input-error :messages="$errors->get('kecamatan')" class="mt-2" />
        </div>

        <div x-data="{ value: '{{ old('desa_kelurahan', $alamat->desa_kelurahan ?? '') }}' }">
            <x-input-label for="desa_kelurahan" value="Desa / Kelurahan" />
            <select id="desa_kelurahan" name="desa_kelurahan" x-model="value"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                required {{ $disabled ? 'disabled' : '' }}>
                @if($alamat && $alamat->desa_kelurahan)
                    <option value="{{ $alamat->desa_kelurahan }}" selected>{{ $alamat->desa_kelurahan }}</option>
                @else
                    <option value="" disabled selected>Pilih Desa/Kelurahan</option>
                @endif
            </select>
            <p x-show="!value && !{{ $disabled ? 'true' : 'false' }}" class="text-xs text-red-600 mt-1">*Wajib diisi</p>
            <x-input-error :messages="$errors->get('desa_kelurahan')" class="mt-2" />
        </div>

        <div class="md:col-span-2" x-data="{ value: '{{ old('alamat_lengkap', $alamat->alamat_lengkap ?? '') }}' }">
            <x-input-label for="alamat_lengkap" value="Alamat Lengkap" />
            <textarea id="alamat_lengkap" name="alamat_lengkap" rows="4" x-model="value"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                placeholder="Masukkan Alamat Lengkap"
                :disabled="$disabled">{{ old('alamat_lengkap', $alamat->alamat_lengkap ?? '') }}</textarea>
            <p x-show="!value && !{{ $disabled ? 'true' : 'false' }}" class="text-xs text-red-600 mt-1">*Wajib diisi</p>
            <x-input-error :messages="$errors->get('alamat_lengkap')" class="mt-2" />
        </div>
    </div>
</div>