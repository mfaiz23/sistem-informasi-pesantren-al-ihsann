<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
     <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    {{--
      Inisialisasi state.
      Secara default, sidebar akan terbuka di layar besar (lebar > 1024px) dan tertutup di layar kecil.
    --}}
    <div x-data="{ sidebarOpen: window.innerWidth > 1024 }">

        <!-- Sidebar (sekarang posisinya fixed) -->
        <x-admin.sidebar />

        {{--
          Konten utama.
          Diberi padding kiri di layar besar (lg) jika sidebarOpen bernilai true.
          Padding ini akan hilang saat sidebar ditutup, membuat konten melebar.
        --}}
        <div class="relative min-h-screen transition-all duration-300 ease-in-out" :class="{'lg:pl-64': sidebarOpen}">
            <!-- Header -->
            <x-admin.header />

            <!-- Main Content -->
            <main class="h-full pb-16">
                <div class="container grid px-6 mx-auto">
                    @if (isset($header))
                        <h2 class="my-6 text-2xl font-semibold text-gray-700">
                            {{ $header }}
                        </h2>
                    @endif
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>
</html>
