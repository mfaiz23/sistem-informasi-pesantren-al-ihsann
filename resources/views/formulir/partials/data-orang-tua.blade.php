{{-- File: resources/views/formulir/partials/data-orang-tua.blade.php --}}

@props(['parent' => null, 'disabled' => false])

<div class="pt-8" x-data="{
    nama_lengkap: '{{ old('nama_lengkap', $parent->nama_lengkap ?? '') }}',
    no_telp: '{{ old('no_telp', $parent->no_telp ?? '') }}',
    alamat: '{{ old('alamat', $parent->alamat ?? '') }}',
    hubungan_keluarga: '{{ old('hubungan_keluarga', $parent->hubungan_keluarga ?? '') }}'
}">
    {{-- HEADER --}}
    <div class="flex items-baseline border-b pb-4 mb-6">
        <h3 class="text-lg font-semibold text-gray-800">DATA ORANG TUA / WALI</h3>

        <span x-show="!nama_lengkap || !no_telp || !alamat || !hubungan_keluarga"
            class="ml-4 text-sm font-medium text-red-600" style="display: none;">
            Data Belum Lengkap
        </span>
    </div>

    {{-- FORM GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

        <div>
            <x-input-label for="nama_lengkap" value="Nama Lengkap" />
            <x-text-input id="nama_lengkap" type="text" name="nama_lengkap" class="mt-1 block w-full"
                :value="old('nama_lengkap', $parent->nama_lengkap ?? '')" required placeholder="Masukkan Nama Lengkap"
                :disabled="$disabled" x-model="nama_lengkap" />
            <p x-show="!nama_lengkap" class="text-xs text-red-600 mt-1" style="display: none;">*Wajib diisi</p>
        </div>

        <div>
            <x-input-label for="no_telp" value="No Telp" />
            <x-text-input id="no_telp" type="tel" name="no_telp" class="mt-1 block w-full" :value="old('no_telp', $parent->no_telp ?? '')" required placeholder="Masukkan No Telp"
                oninput="this.value = this.value.replace(/[^0-9]/g, '')" :disabled="$disabled" x-model="no_telp" />
            <p x-show="!no_telp" class="text-xs text-red-600 mt-1" style="display: none;">*Wajib diisi</p>
        </div>

        <div>
            <x-input-label for="alamat_orang_tua" value="Alamat" />
            <x-text-input id="alamat_orang_tua" type="text" name="alamat" class="mt-1 block w-full"
                :value="old('alamat', $parent->alamat ?? '')" required placeholder="Masukkan Alamat"
                :disabled="$disabled" x-model="alamat" />
            <p x-show="!alamat" class="text-xs text-red-600 mt-1" style="display: none;">*Wajib diisi</p>
        </div>

        <div>
            <x-input-label for="hubungan_keluarga" value="Hubungan Keluarga" />
            <select id="hubungan_keluarga" name="hubungan_keluarga"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $disabled ? 'bg-gray-100' : '' }}"
                required {{ $disabled ? 'disabled' : '' }} x-model="hubungan_keluarga">
                <option value="" disabled>Pilih</option>
                <option value="Ayah">Ayah</option>
                <option value="Ibu">Ibu</option>
                <option value="Wali">Wali</option>
            </select>
            <p x-show="!hubungan_keluarga" class="text-xs text-red-600 mt-1" style="display: none;">*Wajib diisi</p>
        </div>

    </div>
</div>