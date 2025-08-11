{{-- File: resources/views/formulir/partials/data-orang-tua.blade.php --}}

@props(['parent' => null, 'disabled' => false])

<div class="pt-8">
    <h3 class="text-lg font-semibold text-gray-800 border-b pb-4 mb-6">DATA ORANG TUA / WALI</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div>
            <x-input-label for="nama_ayah" value="Nama Lengkap Ayah" />
            <x-text-input id="nama_ayah" type="text" name="nama_ayah" class="mt-1 block w-full" :value="old('nama_ayah', $parent->nama_ayah ?? '')" required placeholder="Masukkan Nama Lengkap Ayah" :disabled="$disabled" />
        </div>

        <div>
            <x-input-label for="nama_ibu" value="Nama Lengkap Ibu" />
            <x-text-input id="nama_ibu" type="text" name="nama_ibu" class="mt-1 block w-full" :value="old('nama_ibu', $parent->nama_ibu ?? '')" required placeholder="Masukkan Nama Lengkap Ibu" :disabled="$disabled" />
        </div>

        <div>
            <x-input-label for="no_telp_ayah" value="No Telp Ayah" />
            <x-text-input id="no_telp_ayah" type="tel" name="no_telp_ayah" class="mt-1 block w-full"
                :value="old('no_telp_ayah', $parent->no_telp_ayah ?? '')" required placeholder="Masukkan No Telp Ayah"
                oninput="this.value = this.value.replace(/[^0-9]/g, '')" :disabled="$disabled" />
        </div>

        <div>
            <x-input-label for="no_telp_ibu" value="No Telp Ibu" />
            <x-text-input id="no_telp_ibu" type="tel" name="no_telp_ibu" class="mt-1 block w-full"
                :value="old('no_telp_ibu', $parent->no_telp_ibu ?? '')" required placeholder="Masukkan No Telp Ibu"
                oninput="this.value = this.value.replace(/[^0-9]/g, '')" :disabled="$disabled" />
        </div>

        <hr class="md:col-span-2 my-2">

        <div>
            <x-input-label for="nama_wali" value="Nama Lengkap Wali (Opsional)" />
            <x-text-input id="nama_wali" type="text" name="nama_wali" class="mt-1 block w-full" :value="old('nama_wali', $parent->nama_wali ?? '')" placeholder="Masukkan Nama Lengkap Wali" :disabled="$disabled" />
        </div>

        <div>
            <x-input-label for="no_telp_wali" value="No Telp Wali (Opsional)" />
            <x-text-input id="no_telp_wali" type="tel" name="no_telp_wali" class="mt-1 block w-full"
                :value="old('no_telp_wali', $parent->no_telp_wali ?? '')" placeholder="Masukkan No Telp Wali"
                oninput="this.value = this.value.replace(/[^0-9]/g, '')" :disabled="$disabled" />
        </div>

    </div>
</div>