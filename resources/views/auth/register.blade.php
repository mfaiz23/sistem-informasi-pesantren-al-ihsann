<x-guest-layout>
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-8">
                <div class="text-center mb-8">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Pondok Pesantren Al-Ihsan" class="h-16 mx-auto mb-4">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Pondok Pesantren al-ihsan</h2>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Silahkan registrasi akun baru untuk mengakses Aplikasi Penerimaan Mahasantri Baru (PMB) - Yayasan Pondok Pesantren Al-Ihsan
                    </p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Nama Lengkap dan No. Handphone -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-text-input id="name" name="name" type="text" :value="old('name')" required autocomplete="name"
                                placeholder="Nama Lengkap (HURUF KAPITAL)"
                                pattern="[A-Z\s]+"
                                title="Nama harus menggunakan huruf kapital"
                                oninput="this.value = this.value.toUpperCase()"
                                class="w-full px-4 py-3 rounded-full bg-gray-200 text-gray-700 focus:bg-white focus:ring-2 focus:ring-green-400 focus:border-transparent border-0 placeholder-gray-500"
                                x-data="{ focused: false }"
                                x-init="setTimeout(() => { $el.focus(); focused = true }, 100)" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div>
                            <x-text-input id="no_telp" name="no_telp" type="tel" :value="old('no_telp')" required autocomplete="tel"
                                placeholder="No. Handphone (Angka saja)"
                                pattern="[0-9]+"
                                title="Nomor telepon hanya boleh berisi angka"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                class="w-full px-4 py-3 rounded-full bg-gray-200 text-gray-700 focus:bg-white focus:ring-2 focus:ring-green-400 focus:border-transparent border-0 placeholder-gray-500" />
                            <x-input-error :messages="$errors->get('no_telp')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <x-text-input id="email" name="email" type="email" :value="old('email')" required autocomplete="username"
                            placeholder="Email Aktif"
                            class="w-full px-4 py-3 rounded-full bg-gray-200 text-gray-700 focus:bg-white focus:ring-2 focus:ring-green-400 focus:border-transparent border-0 placeholder-gray-500" />
                        <p class="mt-2 text-xs text-yellow-600">
                            *Pihak yayasan akan mengirimkan verifikasi melalui email, pastikan email sudah benar dan aktif
                        </p>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="relative">
                        <x-text-input id="password" name="password" type="password" required autocomplete="new-password"
                            placeholder="Kata Sandi"
                            class="w-full px-4 py-3 pr-12 rounded-full bg-gray-200 text-gray-700 focus:bg-white focus:ring-2 focus:ring-green-400 focus:border-transparent border-0 placeholder-gray-500" />
                        <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-4 flex items-center text-gray-500 hover:text-gray-700">
                            <svg id="eye-icon-password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="relative">
                        <x-text-input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                            placeholder="Konfirmasi Kata Sandi"
                            class="w-full px-4 py-3 pr-12 rounded-full bg-gray-200 text-gray-700 focus:bg-white focus:ring-2 focus:ring-green-400 focus:border-transparent border-0 placeholder-gray-500" />
                        <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-4 flex items-center text-gray-500 hover:text-gray-700">
                            <svg id="eye-icon-password_confirmation" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit"
                            class="w-full py-3 px-4 bg-green-400 hover:bg-green-500 text-white font-semibold rounded-full transition duration-200 flex items-center justify-center">
                            Buat Akun
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Login Link -->
                    <div class="text-center text-sm text-gray-600 pt-2">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-green-600 hover:underline font-medium">Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Password toggle function
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const eyeIcon = document.getElementById('eye-icon-' + fieldId);

            if (field.type === 'password') {
                field.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                `;
            } else {
                field.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
            }
        }
    </script>
</x-guest-layout>
