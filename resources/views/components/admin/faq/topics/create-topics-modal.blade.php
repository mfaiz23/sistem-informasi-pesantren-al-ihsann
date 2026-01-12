@props(['errors'])

{{-- Modal Backdrop --}}
<div
    x-show="createModalOpen"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-40 bg-black bg-opacity-50"
    aria-hidden="true"
></div>

{{-- Modal Panel --}}
<div
    x-show="createModalOpen"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-95"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-95"
    @click.away="createModalOpen = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    x-cloak
>
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-xl">
        <h3 class="text-lg font-semibold text-gray-800">Tambah Topik Baru</h3>
        <p class="mt-1 text-sm text-gray-600">Masukkan nama untuk topik FAQ yang baru.</p>

        {{-- Form untuk membuat topik baru --}}
        <form action="{{ route('admin.faq-topics.store') }}" method="POST" class="mt-4 space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Topik</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-[#028579] focus:border-[#028579] sm:text-sm"
                    placeholder="Contoh: Pendaftaran & Biaya"
                    value="{{ old('name') }}"
                    required
                >
                {{-- Menampilkan pesan error validasi --}}
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end pt-4 space-x-3 border-t">
                <button
                    type="button"
                    @click="createModalOpen = false"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-[#028579] rounded-md hover:bg-[#026c61] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#028579]"
                >
                    Simpan Topik
                </button>
            </div>
        </form>
    </div>
</div>
