@props(['formulir' => null, 'disabled' => false])

<div class="pt-8" x-data="{
    asal_sd: '{{ old('asal_sd', $formulir->asal_sd ?? '') }}',
    tahun_lulus_sd: '{{ old('tahun_lulus_sd', $formulir->tahun_lulus_sd ?? '') }}',
    asal_smp: '{{ old('asal_smp', $formulir->asal_smp ?? '') }}',
    tahun_lulus_smp: '{{ old('tahun_lulus_smp', $formulir->tahun_lulus_smp ?? '') }}',
    asal_sma: '{{ old('asal_sma', $formulir->asal_sma ?? '') }}',
    tahun_lulus_sma: '{{ old('tahun_lulus_sma', $formulir->tahun_lulus_sma ?? '') }}',
    asal_universitas: '{{ old('asal_universitas', $formulir->asal_universitas ?? '') }}',
    fakultas: '{{ old('fakultas', $formulir->fakultas ?? '') }}',
    jurusan: '{{ old('jurusan', $formulir->jurusan ?? '') }}',
    angkatan: '{{ old('angkatan', $formulir->angkatan ?? '') }}',
    semester: '{{ old('semester', $formulir->semester ?? '') }}'
}">
    {{-- HEADER --}}
    <div class="flex items-baseline border-b pb-4 mb-6">
        <h3 class="text-lg font-semibold text-gray-800">ASAL SEKOLAH</h3>
        <span
            x-show="!asal_sd || !tahun_lulus_sd || !asal_smp || !tahun_lulus_smp || !asal_sma || !tahun_lulus_sma || !asal_universitas || !fakultas || !jurusan || !angkatan || !semester"
            class="ml-4 text-sm font-medium text-red-600" style="display: none;">
            Data Belum Lengkap
        </span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-8">

        <div>
            <x-input-label for="asal_sd" value="SD/MI" />
            <x-text-input id="asal_sd" type="text" name="asal_sd" class="mt-1 block w-full" x-model="asal_sd"
                placeholder="Masukkan Asal SD/MI" :disabled="$disabled" />
            <p x-show="!asal_sd" class="text-xs text-red-600 mt-1" style="display: none;">*Wajib diisi</p>
        </div>
        <div>
            <x-input-label for="tahun_lulus_sd" value="Tahun Lulus" />
            <x-text-input id="tahun_lulus_sd" type="text" name="tahun_lulus_sd" class="mt-1 block w-full"
                x-model="tahun_lulus_sd" placeholder="Masukkan Tahun Lulus" maxlength="4" :disabled="$disabled" />
            <p x-show="!tahun_lulus_sd" class="text-xs text-red-600 mt-1" style="display: none;">*Wajib diisi</p>
        </div>

        <div>
            <x-input-label for="asal_smp" value="SMP/MTs" />
            <x-text-input id="asal_smp" type="text" name="asal_smp" class="mt-1 block w-full" x-model="asal_smp"
                placeholder="Masukkan Asal SMP/MTs" :disabled="$disabled" />
            <p x-show="!asal_smp" class="text-xs text-red-600 mt-1" style="display: none;">*Wajib diisi</p>
        </div>
        <div>
            <x-input-label for="tahun_lulus_smp" value="Tahun Lulus" />
            <x-text-input id="tahun_lulus_smp" type="text" name="tahun_lulus_smp" class="mt-1 block w-full"
                x-model="tahun_lulus_smp" placeholder="Masukkan Tahun Lulus" maxlength="4" :disabled="$disabled" />
            <p x-show="!tahun_lulus_smp" class="text-xs text-red-600 mt-1" style="display: none;">*Wajib diisi</p>
        </div>

        <div>
            <x-input-label for="asal_sma" value="SMA/SMK/MA" />
            <x-text-input id="asal_sma" type="text" name="asal_sma" class="mt-1 block w-full" x-model="asal_sma"
                placeholder="Masukkan Asal SMA/SMK/MA" :disabled="$disabled" />
            <p x-show="!asal_sma" class="text-xs text-red-600 mt-1" style="display: none;">*Wajib diisi</p>
        </div>
        <div>
            <x-input-label for="tahun_lulus_sma" value="Tahun Lulus" />
            <x-text-input id="tahun_lulus_sma" type="text" name="tahun_lulus_sma" class="mt-1 block w-full"
                x-model="tahun_lulus_sma" placeholder="Masukkan Tahun Lulus" maxlength="4" :disabled="$disabled" />
            <p x-show="!tahun_lulus_sma" class="text-xs text-red-600 mt-1" style="display: none;">*Wajib diisi</p>
        </div>

        <div>
            <x-input-label for="asal_universitas" value="Universitas" />
            <x-text-input id="asal_universitas" type="text" name="asal_universitas" class="mt-1 block w-full"
                x-model="asal_universitas" placeholder="Masukkan Asal Universitas" :disabled="$disabled" />
            <p x-show="!asal_universitas" class="text-xs text-red-600 mt-1" style="display: none;">*Wajib diisi</p>
        </div>

        <div></div>

        <div>
            <x-input-label for="fakultas" value="Fakultas" />
            <x-text-input id="fakultas" type="text" name="fakultas" class="mt-1 block w-full" x-model="fakultas"
                placeholder="Masukkan Asal Fakultas" :disabled="$disabled" />
            <p x-show="!fakultas" class="text-xs text-red-600 mt-1" style="display: none;">*Wajib diisi</p>
        </div>

        <div>
            <x-input-label for="jurusan" value="Jurusan" />
            <x-text-input id="jurusan" type="text" name="jurusan" class="mt-1 block w-full" x-model="jurusan"
                placeholder="Masukkan Asal Jurusan" :disabled="$disabled" />
            <p x-show="!jurusan" class="text-xs text-red-600 mt-1" style="display: none;">*Wajib diisi</p>
        </div>

        <div>
            <x-input-label for="angkatan" value="Angkatan" />
            <x-text-input id="angkatan" type="text" name="angkatan" class="mt-1 block w-full" x-model="angkatan"
                placeholder="Masukkan Asal Angkatan" maxlength="4" :disabled="$disabled" />
            <p x-show="!angkatan" class="text-xs text-red-600 mt-1" style="display: none;">*Wajib diisi</p>
        </div>

        <div>
            <x-input-label for="semester" value="Semester" />
            <x-text-input id="semester" type="text" name="semester" class="mt-1 block w-full" x-model="semester"
                placeholder="Masukkan Asal Semester" :disabled="$disabled" />
            <p x-show="!semester" class="text-xs text-red-600 mt-1" style="display: none;">*Wajib diisi</p>
        </div>
    </div>
</div>