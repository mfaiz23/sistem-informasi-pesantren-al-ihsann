<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Formulir Pendaftaran Calon Santri') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">

                    <form method="POST" action="{{ route('formulir.store') }}">
                        @csrf

                        <h3 class="text-lg font-medium text-gray-900 mb-4">A. Data Diri Calon Santri</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Nama Lengkap (terisi otomatis & terkunci) -->
                            <div>
                                <x-input-label for="name" :value="__('Nama Lengkap')" />
                                <x-text-input id="name" class="block mt-1 w-full bg-gray-100" type="text" name="name"
                                    :value="$user->name" disabled />
                            </div>

                            <!-- Email (terisi otomatis & terkunci) -->
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full bg-gray-100" type="email" name="email"
                                    :value="$user->email" disabled />
                            </div>

                            <!-- Jenis Kelamin -->
                            <div>
                                <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                                <select id="jenis_kelamin" name="jenis_kelamin"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required>
                                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" @if(old('jenis_kelamin') == 'Laki-laki') selected @endif>
                                        Laki-laki</option>
                                    <option value="Perempuan" @if(old('jenis_kelamin') == 'Perempuan') selected @endif>
                                        Perempuan</option>
                                </select>
                                <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                            </div>

                            <!-- Tempat Lahir -->
                            <div>
                                <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
                                <x-text-input id="tempat_lahir" class="block mt-1 w-full" type="text"
                                    name="tempat_lahir" :value="old('tempat_lahir')" required />
                                <x-input-error :messages="$errors->get('tempat_lahir')" class="mt-2" />
                            </div>

                            <!-- Tanggal Lahir -->
                            <div>
                                <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                                <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date"
                                    name="tanggal_lahir" :value="old('tanggal_lahir')" required />
                                <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
                            </div>
                        </div>

                        <hr class="my-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">B. Informasi Pendaftaran</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Asal Sekolah -->
                            <div class="md:col-span-2">
                                <x-input-label for="asal_sekolah" :value="__('Asal Sekolah')" />
                                <x-text-input id="asal_sekolah" class="block mt-1 w-full" type="text"
                                    name="asal_sekolah" :value="old('asal_sekolah')" required />
                                <x-input-error :messages="$errors->get('asal_sekolah')" class="mt-2" />
                            </div>

                            <!-- Kategori Pendaftaran -->
                            <div>
                                <x-input-label for="kategori_pendaftaran" :value="__('Kategori Pendaftaran')" />
                                <select id="kategori_pendaftaran" name="kategori_pendaftaran"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="Reguler">Reguler</option>
                                    <option value="Non-Reguler">Non-Reguler (KIP)</option>
                                </select>
                                <x-input-error :messages="$errors->get('kategori_pendaftaran')" class="mt-2" />
                            </div>

                            <!-- Nomor Ijazah (Opsional) -->
                            <div>
                                <x-input-label for="no_ijazah" :value="__('Nomor Ijazah (jika ada)')" />
                                <x-text-input id="no_ijazah" class="block mt-1 w-full" type="text" name="no_ijazah"
                                    :value="old('no_ijazah')" />
                                <x-input-error :messages="$errors->get('no_ijazah')" class="mt-2" />
                            </div>

                            <!-- No. Telp Orang Tua -->
                            <div class="md:col-span-2">
                                <x-input-label for="no_telp_orang_tua" :value="__('Nomor Telepon Orang Tua/Wali')" />
                                <x-text-input id="no_telp_orang_tua" class="block mt-1 w-full" type="tel"
                                    name="no_telp_orang_tua" :value="old('no_telp_orang_tua')" required
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" />

                                <x-input-error :messages="$errors->get('no_telp_orang_tua')" class="mt-2" />
                            </div>
                        </div>


                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Simpan & Lanjutkan') }}
                            </x-primary-button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>