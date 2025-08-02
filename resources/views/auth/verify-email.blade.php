<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4 py-8">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-8">
                <div class="text-center mb-6">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Pondok Pesantren Al-Ihsan" class="h-16 mx-auto mb-4">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Pondok Pesantren al-ihsan</h2>
                </div>

                <div class="mb-6 text-center text-gray-600 text-sm">
                    {{ __('Terima kasih sudah mendaftar! Sebelum memulai, mohon verifikasi alamat email Anda dengan mengklik tautan yang kami kirimkan.') }}
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 text-center text-sm text-green-600">
                        {{ __('Tautan verifikasi baru telah dikirim ke email Anda.') }}
                    </div>
                @endif

                <div class="mt-6 space-y-4">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit"
                            class="w-full py-3 px-4 bg-green-400 hover:bg-green-500 text-white font-semibold rounded-full transition duration-200">
                            Kirim Ulang Email Verifikasi
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full py-3 px-4 border border-gray-300 text-gray-600 hover:bg-gray-50 font-medium rounded-full transition duration-200">
                            Keluar
                        </button>
                    </form>
                </div>

                <!-- Footer -->
                <div class="mt-8 text-center text-xs text-gray-500">
                    Copyright ©2025 All Rights Reserved by PMB Pondok Pesantren Al-Ihsan
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
