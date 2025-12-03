@props(['disabled' => false])

<div class="pt-8">
    {{-- HEADER --}}
    <div class="flex items-baseline border-b pb-4 mb-6">
        <h3 class="text-lg font-semibold text-gray-800">DOKUMEN PENDUKUNG</h3>
    </div>

    {{-- FORM GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

        @php
            $documents = [
                'dokumen_ktp' => 'Scan KTP',
                'dokumen_kk' => 'Scan Kartu Keluarga',
                'dokumen_ijazah' => 'Scan Ijazah Terakhir',
            ];
        @endphp

        @foreach ($documents as $field => $label)
            {{-- x-data lokal untuk menghandle nama file setiap input secara independen --}}
            <div x-data="{ fileName: null }">
                <x-input-label :for="$field" :value="$label" />

                {{-- CONTAINER INPUT --}}
                <div class="mt-1">
                    {{-- 1. Input Asli (Hidden) --}}
                    <input id="{{ $field }}" type="file" name="{{ $field }}" class="hidden" accept=".pdf,.jpg,.jpeg,.png"
                        x-on:change="fileName = $event.target.files[0]" {{ $disabled ? 'disabled' : '' }}>

                    {{-- 2. Tampilan Custom (Slim & Ramping) --}}
                    <div @class([
                        'flex items-center justify-between w-full border border-gray-300 rounded-md shadow-sm overflow-hidden',
                        'bg-white' => !$disabled,
                        'bg-gray-100' => $disabled,
                    ])>
                        {{-- Area Teks (Kiri) --}}
                        <div class="flex-1 px-3 py-2 text-sm truncate">
                            {{-- 1. Tampilkan nama file jika ada --}}
                            <span x-show="fileName" x-text="fileName ? fileName.name : ''"
                                class="text-gray-700 font-medium"></span>

                            {{-- 2. Tampilkan placeholder jika kosong --}}
                            <span x-show="!fileName" class="text-gray-400">Pilih file...</span>
                        </div>

                        {{-- Tombol 'Choose File' (Kanan) --}}
                        <label for="{{ $field }}" @class([
                            'flex items-center justify-center px-4 py-2 bg-gray-100 text-sm font-medium border-l border-gray-300 text-gray-700',
                            'cursor-pointer hover:bg-gray-200 transition' => !$disabled,
                            'cursor-not-allowed text-gray-400' => $disabled,
                        ])>
                            Choose File
                        </label>
                    </div>

                    {{-- 3. Status File / Helper Text (Di Bawah Kotak) --}}
                    <div class="mt-1 flex justify-between items-start text-xs">

                        {{-- KIRI: Status File Database (Jika ada file lama) --}}
                        <div>
                            @if (isset($formulir) && $formulir->$field)
                                <a href="{{ asset('storage/' . $formulir->$field) }}" target="_blank"
                                    class="text-green-600 hover:text-green-800 hover:underline flex items-center font-medium">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    File tersimpan. Cek {{ $label }}
                                </a>
                            @else
                                <span class="text-gray-500">*Format PDF/JPG, Max 5MB</span>
                            @endif
                        </div>

                        {{-- KANAN: Error Message --}}
                        <x-input-error :messages="$errors->get($field)" class="text-right" />
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>