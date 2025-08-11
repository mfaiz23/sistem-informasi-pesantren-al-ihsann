@props(['formulir' => null, 'disabled' => false])

<!-- ASAL SEKOLAH -->
<div class="pt-8">
    <h3 class="text-lg font-semibold text-gray-800 border-b pb-4 mb-6">ASAL SEKOLAH</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-8">

        <!-- SD/MI -->
        <div x-data="{ value: '{{ old('asal_sd', $formulir->asal_sd ?? '') }}' }">
            <x-input-label for="asal_sd" value="SD/MI" />
            <x-text-input id="asal_sd" type="text" name="asal_sd" class="mt-1 block w-full" x-model="value"
                placeholder="Masukkan Asal SD/MI" :disabled="$disabled" />
            <p x-show="!value && !{{ $disabled ? 'true' : 'false' }}" class="text-xs text-red-600 mt-1">*Wajib diisi</p>
            <x-input-error :messages="$errors->get('asal_sd')" class="mt-2" />
        </div>
        <div x-data="{ value: '{{ old('tahun_lulus_sd', $formulir->tahun_lulus_sd ?? '') }}' }">
            <x-input-label for="tahun_lulus_sd" value="Tahun Lulus" />
            <x-text-input id="tahun_lulus_sd" type="text" name="tahun_lulus_sd" class="mt-1 block w-full"
                x-model="value" placeholder="Masukan Tahun Lulus" maxlength="4" :disabled="$disabled" />
            <p x-show="!value && !{{ $disabled ? 'true' : 'false' }}" class="text-xs text-red-600 mt-1">*Wajib diisi</p>
            <x-input-error :messages="$errors->get('tahun_lulus_sd')" class="mt-2" />
        </div>

        <!-- SMP/MTs -->
        <div x-data="{ value: '{{ old('asal_smp', $formulir->asal_smp ?? '') }}' }">
            <x-input-label for="asal_smp" value="SMP/MTs" />
            <x-text-input id="asal_smp" type="text" name="asal_smp" class="mt-1 block w-full" x-model="value"
                placeholder="Masukkan Asal SMP/MTs" :disabled="$disabled" />
            <p x-show="!value && !{{ $disabled ? 'true' : 'false' }}" class="text-xs text-red-600 mt-1">*Wajib diisi</p>
            <x-input-error :messages="$errors->get('asal_smp')" class="mt-2" />
        </div>
        <div x-data="{ value: '{{ old('tahun_lulus_smp', $formulir->tahun_lulus_smp ?? '') }}' }">
            <x-input-label for="tahun_lulus_smp" value="Tahun Lulus" />
            <x-text-input id="tahun_lulus_smp" type="text" name="tahun_lulus_smp" class="mt-1 block w-full"
                x-model="value" placeholder="Masukan Tahun Lulus" maxlength="4" :disabled="$disabled" />
            <p x-show="!value && !{{ $disabled ? 'true' : 'false' }}" class="text-xs text-red-600 mt-1">*Wajib diisi</p>
            <x-input-error :messages="$errors->get('tahun_lulus_smp')" class="mt-2" />
        </div>

        <!-- SMA/SMK/MA -->
        <div x-data="{ value: '{{ old('asal_sma', $formulir->asal_sma ?? '') }}' }">
            <x-input-label for="asal_sma" value="SMA/SMK/MA" />
            <x-text-input id="asal_sma" type="text" name="asal_sma" class="mt-1 block w-full" x-model="value"
                placeholder="Masukkan Asal SMA/SMK/MA" :disabled="$disabled" />
            <p x-show="!value && !{{ $disabled ? 'true' : 'false' }}" class="text-xs text-red-600 mt-1">*Wajib diisi</p>
            <x-input-error :messages="$errors->get('asal_sma')" class="mt-2" />
        </div>
        <div x-data="{ value: '{{ old('tahun_lulus_sma', $formulir->tahun_lulus_sma ?? '') }}' }">
            <x-input-label for="tahun_lulus_sma" value="Tahun Lulus" />
            <x-text-input id="tahun_lulus_sma" type="text" name="tahun_lulus_sma" class="mt-1 block w-full"
                x-model="value" placeholder="Masukan Tahun Lulus" maxlength="4" :disabled="$disabled" />
            <p x-show="!value && !{{ $disabled ? 'true' : 'false' }}" class="text-xs text-red-600 mt-1">*Wajib diisi</p>
            <x-input-error :messages="$errors->get('tahun_lulus_sma')" class="mt-2" />
        </div>

        <!-- Universitas (HAPUS md:col-span-2) -->
        <div x-data="{ value: '{{ old('asal_universitas', $formulir->asal_universitas ?? '') }}' }">
            <x-input-label for="asal_universitas" value="Universitas" />
            <x-text-input id="asal_universitas" type="text" name="asal_universitas" class="mt-1 block w-full"
                x-model="value" placeholder="Masukkan Asal Universitas" :disabled="$disabled" />
            <p x-show="!value && !{{ $disabled ? 'true' : 'false' }}" class="text-xs text-red-600 mt-1">*Wajib diisi</p>
            <x-input-error :messages="$errors->get('asal_universitas')" class="mt-2" />
        </div>

        {{-- Kosongkan satu sel agar Jurusan berada di kolom kanan --}}
        <div></div>

        <!-- Fakultas -->
        <div x-data="{ value: '{{ old('fakultas', $formulir->fakultas ?? '') }}' }">
            <x-input-label for="fakultas" value="Fakultas" />
            <x-text-input id="fakultas" type="text" name="fakultas" class="mt-1 block w-full" x-model="value"
                placeholder="Masukkan Asal Fakultas" :disabled="$disabled" />
            <p x-show="!value && !{{ $disabled ? 'true' : 'false' }}" class="text-xs text-red-600 mt-1">*Wajib diisi</p>
            <x-input-error :messages="$errors->get('fakultas')" class="mt-2" />
        </div>

        <!-- Jurusan -->
        <div x-data="{ value: '{{ old('jurusan', $formulir->jurusan ?? '') }}' }">
            <x-input-label for="jurusan" value="Jurusan" />
            <x-text-input id="jurusan" type="text" name="jurusan" class="mt-1 block w-full" x-model="value"
                placeholder="Masukkan Asal Jurusan" :disabled="$disabled" />
            <p x-show="!value && !{{ $disabled ? 'true' : 'false' }}" class="text-xs text-red-600 mt-1">*Wajib diisi</p>
            <x-input-error :messages="$errors->get('jurusan')" class="mt-2" />
        </div>

        <!-- Angkatan -->
        <div x-data="{ value: '{{ old('angkatan', $formulir->angkatan ?? '') }}' }">
            <x-input-label for="angkatan" value="Angkatan" />
            <x-text-input id="angkatan" type="text" name="angkatan" class="mt-1 block w-full" x-model="value"
                placeholder="Masukkan Asal Angkatan" maxlength="4" :disabled="$disabled" />
            <p x-show="!value && !{{ $disabled ? 'true' : 'false' }}" class="text-xs text-red-600 mt-1">*Wajib diisi</p>
            <x-input-error :messages="$errors->get('angkatan')" class="mt-2" />
        </div>

        <!-- Semester -->
        <div x-data="{ value: '{{ old('semester', $formulir->semester ?? '') }}' }">
            <x-input-label for="semester" value="Semester" />
            <x-text-input id="semester" type="text" name="semester" class="mt-1 block w-full" x-model="value"
                placeholder="Masukkan Asal Semester" :disabled="$disabled" />
            <p x-show="!value && !{{ $disabled ? 'true' : 'false' }}" class="text-xs text-red-600 mt-1">*Wajib diisi</p>
            <x-input-error :messages="$errors->get('semester')" class="mt-2" />
        </div>
    </div>
</div>