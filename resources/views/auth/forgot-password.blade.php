<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4 py-8">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-8">
                <div class="text-center mb-6">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Pondok Pesantren Al-Ihsan" class="h-16 mx-auto mb-4">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Pondok Pesantren al-ihsan</h2>
                </div>

                <div class="mb-6 text-center text-gray-600 text-sm">
                    {{ __('Lupa password? Masukkan email anda dan kami akan mengirimkan tautan pengaturan ulang kata sandi') }}
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                    @csrf

                    <!-- Email Input -->
                    <div>
                        <x-text-input id="email" name="email" type="email" :value="old('email')" required autofocus
                            placeholder="Masukkan Email"
                            class="w-full px-4 py-3 rounded-full bg-gray-200 text-gray-700 focus:bg-white focus:ring-2 focus:ring-green-400 focus:border-transparent border-0 placeholder-gray-500" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit"
                            class="w-full py-3 px-4 bg-green-400 hover:bg-green-500 text-white font-semibold rounded-full transition duration-200">
                            KIRIM TAUTAN
                        </button>
                    </div>
                </form>

                <!-- Footer -->
                <div class="mt-8 text-center text-xs text-gray-500">
                    Copyright ©2025 All Rights Reserved by PMB Pondok Pesantren Al-Ihsan
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
