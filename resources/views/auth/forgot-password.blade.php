<x-guest-layout>
    <div class="w-full max-w-md bg-slate-50 rounded-2xl shadow-lg overflow-hidden p-10">
        <div class="text-center mb-8">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Pondok Pesantren Al-Ihsan"
                class="h-16 mx-auto mb-4">
            <p class="text-gray-600 text-sm leading-relaxed">
                Lupa password? Masukkan email anda dan kami akan mengirimkan tautan pengaturan ulang kata sandi.
            </p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <div>
                <x-text-input id="email" name="email" type="email" :value="old('email')" required autofocus
                    placeholder="Masukkan Email"
                    class="w-full px-4 py-3 rounded-[20px] bg-gray-200 text-gray-700 focus:ring-2 focus:ring-green-400 focus:border-transparent placeholder-gray-500 shadow-md" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <button type="submit"
                    class="w-full py-3 px-4 bg-[#028579] hover:bg-[#016a60] text-white font-semibold rounded-[20px] transition duration-200">
                    KIRIM TAUTAN
                </button>
            </div>

            <div class="text-center text-sm text-gray-600 pt-2 border-t border-slate-200">
                <a href="{{ route('login') }}" class="text-green-600 hover:underline font-medium">Kembali ke Login</a>
            </div>
        </form>
    </div>
</x-guest-layout>