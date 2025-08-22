@props(['formulir' => null, 'disabled' => false])

<div class="pt-2" x-data="{ 
    nama_lengkap: '{{ old('name', optional($formulir)->user->name ?? Auth::user()->name) }}',
    no_telp: '{{ old('no_telp', optional($formulir)->user->no_telp ?? Auth::user()->no_telp) }}',
    nama_panggilan: '{{ old('nama_panggilan', optional($formulir)->nama_panggilan ?? '') }}',
    tempat_lahir: '{{ old('tempat_lahir', optional($formulir)->tempat_lahir ?? '') }}',
    tanggal_lahir: '{{ old('tanggal_lahir', optional($formulir)->tanggal_lahir ?? '') }}',
    jenis_kelamin: '{{ old('jenis_kelamin', optional($formulir)->jenis_kelamin ?? '') }}',
    nik: '{{ old('nik', optional($formulir)->nik ?? '') }}',
    kategori: '{{ old('kategori_pendaftaran', optional($formulir)->kategori_pendaftaran ?? 'Reguler') }}',
    no_kip: '{{ old('no_kip', optional($formulir)->no_kip ?? '') }}',
    dokumen_kip: null,
    isKipFilled() {
        if (this.kategori !== 'Non-Reguler') return true;
        return this.no_kip && (this.dokumen_kip || '{{ $formulir && $formulir->kipDocument ? 'true' : 'false' }}');
    }
}">
    <div class="flex items-baseline border-b pb-4 mb-6">
        <h3 class="text-lg font-semibold text-gray-800">DATA PRIBADI</h3>
        <span
            x-show="!nama_lengkap || !nama_panggilan || !tempat_lahir || !tanggal_lahir || !jenis_kelamin || !nik || !no_telp || !kategori || !isKipFilled()"
            class="ml-4 text-sm font-medium text-red-600" style="display: none;">
            Data Belum Lengkap
        </span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-8">

        <div>
            <x-input-label for="name" value="Nama Lengkap" />
            <x-text-input id="name" type="text" name="name" class="mt-1 block w-full" :value="old('name', optional($formulir)->user->name ?? Auth::user()->name)" required x-model="nama_lengkap"
                :disabled="$disabled" />
            <p x-show="!nama_lengkap" class="text-xs text-red-600 mt-1" style="display: none;">*Wajib diisi</p>
        </div>
        <div>
            <x-input-label for="nama_panggilan" value="Nama Panggilan" />
            <x-text-input id="nama_panggilan" type="text" name="nama_panggilan" class="mt-1 block w-full"
                :value="old('nama_panggilan', optional($formulir)->nama_panggilan ?? '')" required
                placeholder="Masukkan Nama Panggilan" :disabled="$disabled" x-model="nama_panggilan" />
            <p x-show="!nama_panggilan" class="text-xs text-red-600 mt-1" style="display: none;">*Wajib diisi</p>
        </div>
        <div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-input-label for="tempat_lahir" value="Tempat Lahir" />
                    <x-text-input id="tempat_lahir" type="text" name="tempat_lahir" class="mt-1 block w-full"
                        :value="old('tempat_lahir', optional($formulir)->tempat_lahir ?? '')" required
                        placeholder="Masukkan Tempat" :disabled="$disabled" x-model="tempat_lahir" />
                    <p x-show="!tempat_lahir" class="text-xs text-red-600 mt-1" style="display: none;">*Wajib diisi</p>
                </div>
                <div>
                    <x-input-label for="tanggal_lahir" value="Tanggal Lahir" />
                    <x-text-input id="tanggal_lahir" type="date" name="tanggal_lahir" class="mt-1 block w-full"
                        :value="old('tanggal_lahir', optional($formulir)->tanggal_lahir ?? '')" required
                        :disabled="$disabled" x-model="tanggal_lahir" />
                    <p x-show="!tanggal_lahir" class="text-xs text-red-600 mt-1" style="display: none;">*Wajib diisi</p>
                </div>
            </div>
        </div>
        <div>
            <x-input-label value="Jenis Kelamin" class="mb-2" />
            <div class="flex items-center space-x-6 mt-1">
                <label class="flex items-center">
                    <input type="radio" name="jenis_kelamin" value="Laki-laki" x-model="jenis_kelamin"
                        class="text-indigo-600 focus:ring-indigo-500" {{ $disabled ? 'disabled' : '' }}>
                    <span class="ml-2">Laki-laki</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="jenis_kelamin" value="Perempuan" x-model="jenis_kelamin"
                        class="text-indigo-600 focus:ring-indigo-500" {{ $disabled ? 'disabled' : '' }}>
                    <span class="ml-2">Perempuan</span>
                </label>
            </div>
            <p x-show="!jenis_kelamin" class="text-xs text-red-600 mt-1" style="display: none;">*Data pilih salah satu
            </p>
        </div>
        <div>
            <x-input-label for="nik" value="Nomor Induk Kependudukan (NIK)" />
            <x-text-input id="nik" type="text" name="nik" class="mt-1 block w-full" :value="old('nik', optional($formulir)->nik ?? '')" required placeholder="Masukkan 16 digit NIK" maxlength="16"
                :disabled="$disabled" x-model="nik" />
            <p x-show="!nik" class="text-xs text-red-600 mt-1" style="display: none;">*Wajib diisi</p>
        </div>
        <div>
            <x-input-label for="no_telp" value="Nomor Handphone/WhatsApp" />
            <x-text-input id="no_telp" type="tel" name="no_telp" class="mt-1 block w-full" :value="old('no_telp', optional($formulir)->user->no_telp ?? Auth::user()->no_telp)" required x-model="no_telp"
                :disabled="$disabled" />
            <p x-show="!no_telp" class="text-xs text-red-600 mt-1" style="display: none;">*Wajib diisi</p>
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
            <p x-show="!kategori" class="text-xs text-red-600 mt-1" style="display: none;">*Data pilih salah satu</p>
        </div>
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" type="email" class="mt-1 block w-full bg-gray-100 cursor-not-allowed"
                :value="optional($formulir)->user->email ?? Auth::user()->email" disabled />
        </div>

        {{-- Bagian KIP --}}
        <template x-if="kategori === 'Non-Reguler'">
            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-8 border-t pt-8">
                <div>
                    <x-input-label for="no_kip" value="Nomor Kartu Indonesia Pintar (KIP)" />
                    <x-text-input id="no_kip" type="text" name="no_kip" class="mt-1 block w-full" x-model="no_kip"
                        placeholder="Masukkan No KIP" :disabled="$disabled" />
                    <p x-show="!no_kip && !{{ $disabled ? 'true' : 'false' }}" class="text-xs text-red-600 mt-1">*Wajib
                        diisi</p>
                </div>
                <div>
                    <x-input-label for="dokumen_kip" value="Unggah Dokumen KIP" />

                    <div>
                        <input id="dokumen_kip" type="file" name="dokumen_kip" class="hidden"
                            x-on:change="dokumen_kip = $event.target.files[0]" {{ $disabled ? 'disabled' : '' }}>
                        <div @class([
                            'mt-1 flex items-center justify-between w-full border border-gray-300 rounded-md shadow-sm overflow-hidden',
                            'bg-gray-100' => $disabled,
                        ])>
                            <div class="text-sm text-gray-700 px-3 truncate">
                                <span x-show="dokumen_kip" x-text="dokumen_kip.name"></span>
                                @if (isset($formulir) && $formulir->kipDocument)
                                    <a href="{{ asset('storage/' . $formulir->kipDocument->dokumen_path) }}" target="_blank"
                                        x-show="!dokumen_kip" class="hover:text-blue-600 transition">
                                        {{ basename($formulir->kipDocument->dokumen_path) }}
                                    </a>
                                @else
                                    <span x-show="!dokumen_kip" class="text-gray-400">Pilih file...</span>
                                @endif
                            </div>

                            <label for="dokumen_kip" @class([
                                'inline-flex items-center px-4 py-2 bg-gray-200 text-sm font-semibold border-l border-gray-300',
                                'cursor-pointer text-gray-700 hover:bg-gray-300 transition' => !$disabled,
                                'cursor-not-allowed text-gray-500' => $disabled,
                            ])>
                                Choose File
                            </label>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Catatan: Format yang didukung (JPG,JPEG,PNG,PDF) dan Max
                            size 5MB</p>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>