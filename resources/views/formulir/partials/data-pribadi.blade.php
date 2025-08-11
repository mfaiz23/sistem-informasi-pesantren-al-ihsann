@props(['formulir' => null, 'disabled' => false])

<div class="pt-2" x-data="{ 
    kategori: '{{ old('kategori_pendaftaran', $formulir->kategori_pendaftaran ?? 'Reguler') }}',
    jenisKelamin: '{{ old('jenis_kelamin', $formulir->jenis_kelamin ?? '') }}'
}">
    <h3 class="text-lg font-semibold text-gray-800 border-b pb-4 mb-6">DATA PRIBADI</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-8">

        <div>
            <x-input-label for="name" value="Nama Lengkap" />
            <x-text-input id="name" type="text" class="mt-1 block w-full bg-gray-100 cursor-not-allowed"
                :value="Auth::user()->name" disabled />
        </div>
        <div x-data="{ value: '{{ old('nama_panggilan', $formulir->nama_panggilan ?? '') }}' }">
            <x-input-label for="nama_panggilan" value="Nama Panggilan" />
            <x-text-input id="nama_panggilan" type="text" name="nama_panggilan" class="mt-1 block w-full"
                x-model="value" 
                required 
                placeholder="Masukkan Nama Panggilan" 
                :disabled="$disabled" />
            <p x-show="!value && !{{ $disabled ? 'true' : 'false' }}" class="text-xs text-red-600 mt-1">*Wajib diisi</p>
            <x-input-error :messages="$errors->get('nama_panggilan')" class="mt-2" />
        </div>

        <div>
            <div class="grid grid-cols-2 gap-4">
                <div x-data="{ value: '{{ old('tempat_lahir', $formulir->tempat_lahir ?? '') }}' }">
                    <x-input-label for="tempat_lahir" value="Tempat Lahir" />
                    <x-text-input id="tempat_lahir" type="text" name="tempat_lahir" class="mt-1 block w-full"
                        x-model="value" 
                        required 
                        placeholder="Masukkan Tempat" 
                        :disabled="$disabled" />
                    <p x-show="!value && !{{ $disabled ? 'true' : 'false' }}" class="text-xs text-red-600 mt-1">*Wajib diisi</p>
                    <x-input-error :messages="$errors->get('tempat_lahir')" class="mt-2" />
                </div>
                <div x-data="{ value: '{{ old('tanggal_lahir', $formulir->tanggal_lahir ?? '') }}' }">
                    <x-input-label for="tanggal_lahir" value="Tanggal Lahir" />
                    <x-text-input id="tanggal_lahir" type="date" name="tanggal_lahir" class="mt-1 block w-full"
                        x-model="value" 
                        required 
                        :disabled="$disabled" />
                    <p x-show="!value && !{{ $disabled ? 'true' : 'false' }}" class="text-xs text-red-600 mt-1">*Wajib diisi</p>
                    <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
                </div>
            </div>
        </div>
        <div>
            <x-input-label value="Jenis Kelamin" class="mb-2" />
            <div class="flex items-center space-x-6 mt-1">
                <label class="flex items-center">
                    <input type="radio" name="jenis_kelamin" value="Laki-laki" x-model="jenisKelamin"
                           class="text-indigo-600 focus:ring-indigo-500" {{ $disabled ? 'disabled' : '' }}>
                    <span class="ml-2">Laki-laki</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="jenis_kelamin" value="Perempuan" x-model="jenisKelamin"
                           class="text-indigo-600 focus:ring-indigo-500" {{ $disabled ? 'disabled' : '' }}>
                    <span class="ml-2">Perempuan</span>
                </label>
            </div>
            <p x-show="!jenisKelamin && !{{ $disabled ? 'true' : 'false' }}" class="text-xs text-red-600 mt-1">*Data pilih salah satu</p>
            <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
        </div>

        <div x-data="{ value: '{{ old('nik', $formulir->nik ?? '') }}' }">
            <x-input-label for="nik" value="Nomor Induk Kependudukan (NIK)" />
            <x-text-input id="nik" type="text" name="nik" class="mt-1 block w-full" 
                x-model="value" 
                required
                placeholder="Masukkan 16 digit NIK"
                maxlength="16" 
                :disabled="$disabled" />
            <p x-show="!value && !{{ $disabled ? 'true' : 'false' }}" class="text-xs text-red-600 mt-1">*Wajib diisi</p>
            <x-input-error :messages="$errors->get('nik')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="no_telp" value="Nomor Handphone/WhatsApp" />
            <x-text-input id="no_telp" type="text" class="mt-1 block w-full bg-gray-100 cursor-not-allowed"
                :value="Auth::user()->no_telp" disabled />
        </div>
        
        <div>
            <x-input-label value="Kategori Pendaftaran" class="mb-2" />
            <div class="flex items-center space-x-6 mt-1">
                <label class="flex items-center">
                    <input type="radio" name="kategori_pendaftaran" value="Reguler" x-model="kategori"
                           class="text-indigo-600 focus:ring-indigo-500" {{ $disabled ? 'disabled' : '' }}>
                    <span class="ml-2">Reguler</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="kategori_pendaftaran" value="Non-Reguler" x-model="kategori"
                           class="text-indigo-600 focus:ring-indigo-500" {{ $disabled ? 'disabled' : '' }}>
                    <span class="ml-2">Non-Reguler</span>
                </label>
            </div>
            <p x-show="!kategori && !{{ $disabled ? 'true' : 'false' }}" class="text-xs text-red-600 mt-1">*Data pilih salah satu</p>
            <x-input-error :messages="$errors->get('kategori_pendaftaran')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" type="email" class="mt-1 block w-full bg-gray-100 cursor-not-allowed"
                :value="Auth::user()->email" disabled />
        </div>

        <template x-if="kategori === 'Non-Reguler'">
            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-8 border-t pt-8">
                <div x-data="{ value: '{{ old('no_kip', $formulir->no_kip ?? '') }}' }">
                    <x-input-label for="no_kip" value="Nomor Kartu Indonesia Pintar (KIP)" />
                    <x-text-input id="no_kip" type="text" name="no_kip" class="mt-1 block w-full" 
                        x-model="value"
                        placeholder="Masukkan No KIP" 
                        :disabled="$disabled" />
                    <p x-show="!value && !{{ $disabled ? 'true' : 'false' }}" class="text-xs text-red-600 mt-1">*Wajib diisi</p>
                    <x-input-error :messages="$errors->get('no_kip')" class="mt-2" />
                </div>
                <div x-data="{ fileName: '' }">
                    <x-input-label for="dokumen_kip" value="Unggah Dokumen KIP" />
                    <input id="dokumen_kip" type="file" name="dokumen_kip" class="hidden"
                           x-on:change="fileName = $event.target.files.length > 0 ? $event.target.files[0].name : ''"
                           {{ $disabled ? 'disabled' : '' }}>
                    <div class="mt-1 flex items-center justify-between w-full border border-gray-300 rounded-md shadow-sm">
                        <p x-show="!fileName" class="text-sm text-gray-400 px-3 truncate">Max 5MB</p>
                        <p x-show="fileName" class="text-sm text-gray-700 px-3 truncate" x-text="fileName"></p>
                        <label for="dokumen_kip" 
                               class="cursor-pointer inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 text-sm font-semibold border-l border-gray-300 hover:bg-gray-300">
                            Choose File
                        </label>
                    </div>
                    <p x-show="!fileName && !{{ $disabled ? 'true' : 'false' }}" class="text-xs text-red-600 mt-1">*Wajib diisi</p>
                    <x-input-error :messages="$errors->get('dokumen_kip')" class="mt-2" />
                </div>
            </div>
        </template>
    </div>
</div>