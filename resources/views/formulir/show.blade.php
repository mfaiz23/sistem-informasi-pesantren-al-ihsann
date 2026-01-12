<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Formulir Pendaftaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="border-l-4 border-orange-500 text-orange-800 p-4 mb-6" style="background-color: #FFD4AE;"
                role="alert">
                <p class="font-bold">Informasi</p>
                <p>Ini adalah data yang telah Anda kirimkan. Untuk mengubah data, silakan kunjungi halaman <a
                        href="{{ route('profile.edit') }}" class="underline font-semibold">Profil</a> Anda.</p>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    @include('formulir.partials.data-pribadi', ['formulir' => $formulir, 'disabled' => true])
                    @include('formulir.partials.asal-sekolah', ['formulir' => $formulir, 'disabled' => true])
                    @include('formulir.partials.alamat', ['alamat' => $formulir->alamat, 'disabled' => true])
                    @include('formulir.partials.data-orang-tua', ['parent' => $formulir->parent, 'disabled' => true])
                    @include('formulir.partials.dokumen-pendukung', ['formulir' => $formulir, 'disabled' => true])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>