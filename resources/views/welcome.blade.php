<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pesantren Al-Ihsan</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50">

    {{-- Memanggil komponen header --}}
    <x-landing.header />

    {{-- KONTEN UTAMA HALAMAN ANDA AKAN ADA DI SINI --}}
    <x-landing.hero />

    {{-- Memanggil komponen footer --}}
    <x-landing.footer />

</body>

</html>