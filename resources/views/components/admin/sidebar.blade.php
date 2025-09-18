{{-- Backdrop untuk mobile (tetap hanya muncul di layar kecil) --}}
<div x-show="sidebarOpen" class="fixed inset-0 z-20 bg-black bg-opacity-50 lg:hidden" @click="sidebarOpen = false"></div>

<aside
    class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition-transform duration-300 transform border-r border-gray-200 bg-gray-50/90 backdrop-blur-lg"
    :class="{'translate-x-0 ease-out': sidebarOpen, '-translate-x-full ease-in': !sidebarOpen}"
>
    <div class="flex items-center justify-center mt-8">
        <div class="flex items-center">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Pondok Pesantren Al-Ihsan" class="h-10">
        </div>
    </div>

    <nav class="mt-10 px-4">
        {{-- Menggunakan route() dan request()->routeIs() untuk active state --}}
        <x-admin.nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
            <x-slot name="icon">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            </x-slot>
            Dashboard
        </x-admin.nav-link>

        <x-admin.nav-link href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.users.*')">
            <x-slot name="icon">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-3-5.197M15 21a9 9 0 00-9-9m9 9a9 9 0 00-9-9"></path></svg>
            </x-slot>
            Manajemen Pengguna
        </x-admin.nav-link>

        <x-admin.nav-link href="{{ route('admin.pendaftaran') }}" :active="request()->routeIs('admin.pendaftaran')">
            <x-slot name="icon">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </x-slot>
            Pendaftaran Santri
        </x-admin.nav-link>

        <x-admin.nav-link href="{{ route('admin.keuangan') }}" :active="request()->routeIs('admin.keuangan')">
            <x-slot name="icon">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
            </x-slot>
            Keuangan
        </x-admin.nav-link>

        <div x-data="{ open: {{ request()->routeIs('admin.faq-topics.*') || request()->routeIs('admin.faq.*') ? 'true' : 'false' }} }">
            {{-- Tombol Parent Menu (disempurnakan agar sesuai nav-link.blade.php) --}}
            <a href="#" @click.prevent="open = !open"
               class="flex items-center justify-between w-full px-6 py-3 mt-4 text-left transition-colors duration-200 transform rounded-md"
               :class="open ? 'bg-[#028579] text-white' : 'text-gray-600 hover:bg-gray-200 hover:text-gray-800'">

                <span class="flex items-center">
                    {{-- Ikon Tanda Tanya --}}
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="mx-4 font-medium">Manajemen FAQ</span>
                </span>

                {{-- Ikon Panah Dropdown --}}
                <svg class="w-4 h-4 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </a>

            {{-- Sub-Menu Dropdown --}}
            <div x-show="open" x-collapse class="mt-2 space-y-2">
                <x-admin.nav-link href="{{ route('admin.faq-topics.index') }}" :active="request()->routeIs('admin.faq-topics.*')" class="pl-12">
                    Topik
                </x-admin.nav-link>

                {{-- FIX: Change 'admin.faqs.*' to 'admin.faq.*' --}}
                <x-admin.nav-link href="{{ route('admin.faq.index') }}" :active="request()->routeIs('admin.faq.*')" class="pl-12">
                    Pertanyaan
                </x-admin.nav-link>
            </div>
        </div>
    </nav>
</aside>
