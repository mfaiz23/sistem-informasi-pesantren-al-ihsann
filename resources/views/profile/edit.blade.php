{{-- File: resources/views/profile/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Profil Calon Santri
            </h2>

            {{-- Ganti class pada tombol ini --}}
            <a href="{{ route('dashboard') }}"
                class="inline-block bg-blue-500 text-white font-semibold py-2 px-5 rounded-lg shadow-md hover:bg-blue-600 transition duration-300 text-sm">
                Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">

                    {{-- Tampilkan pesan sukses jika ada --}}
                    @if (session('status') === 'profile-updated')
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                            <p class="font-bold">Sukses!</p>
                            <p>Data profil Anda berhasil diperbarui.</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        {{-- Langsung include semua partials tanpa <details> --}}
                            @include('formulir.partials.data-pribadi', ['formulir' => $formulir])
                            @include('formulir.partials.asal-sekolah', ['formulir' => $formulir])
                            @include('formulir.partials.alamat', ['alamat' => $formulir->alamat])
                            @include('formulir.partials.data-orang-tua', ['parent' => $formulir->parent])

                            <div class="flex justify-center mt-8">
                                <x-primary-button class="bg-green-600 hover:bg-green-700">
                                    {{ __('SIMPAN PERUBAHAN') }}
                                </x-primary-button>
                            </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>