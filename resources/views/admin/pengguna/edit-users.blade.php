    <x-admin-layout>
    {{-- Judul Halaman --}}
    <div class="my-6">
        <h2 class="text-2xl font-semibold text-gray-800">Edit Pengguna</h2>
        <p class="text-sm text-gray-600">Perbarui informasi untuk pengguna Fathan Qowiyun.</p>
    </div>

    {{-- Konten Utama: Form Edit --}}
    <div class="p-4 bg-white rounded-lg shadow-md sm:p-6">

        <form action="#" method="POST">
            @csrf
            @method('PUT')

            {{-- Grid untuk layout responsif --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- Kolom Kiri: Info Dasar --}}
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="Fathan Qowiyun" class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                        <input type="email" name="email" id="email" value="faqowid@example.com" class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                        <select id="role" name="role" class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                            <option value="admin" selected>Admin</option>
                            <option value="calon_santri">Calon Santri</option>
                        </select>
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="status" name="status" class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                            <option value="aktif" selected>Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>

                {{-- Kolom Kanan: Foto Profil dan Password --}}
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Foto Profil</label>
                        <div class="flex items-center mt-1 space-x-4">
                            <img class="object-cover w-16 h-16 rounded-full" src="https://ui-avatars.com/api/?name=Fathan+Qowiyun&background=22C55E&color=fff" alt="Foto profil saat ini">
                            <div class="flex-1">
                                <label for="photo" class="px-3 py-2 text-sm font-medium leading-4 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm cursor-pointer hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <span>Ubah Foto</span>
                                    <input id="photo" name="photo" type="file" class="sr-only">
                                </label>
                                <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF hingga 2MB.</p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password Baru (Opsional)</label>
                        <input type="password" name="password" id="password" placeholder="Kosongkan jika tidak ingin diubah" class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi Form --}}
            <div class="flex justify-end pt-6 mt-6 border-t border-gray-200">
                <a href="#" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Batal
                </a>
                <button type="submit" class="inline-flex justify-center px-4 py-2 ml-3 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Simpan Perubahan
                </button>
            </div>
        </form>

    </div>
</x-admin-layout>
