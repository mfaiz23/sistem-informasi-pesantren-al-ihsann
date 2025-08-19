<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormulirController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

// Rute Dashboard sudah benar
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard_admin', function () {
    return view('admin.dashboard');
});

Route::get('/manajemen_pengguna', function () {
    return view('admin.management-users');
});

Route::get('/pendaftaran_santri', function () {
    return view('admin.pendaftaran-santri');
});

Route::get('/keuangan', function () {
    return view('admin.keuangan');
});

Route::get('/edit_pengguna', function () {
    return view('admin.pengguna.edit-users');
});

/*
|--------------------------------------------------------------------------
| Rute yang dilindungi (Memerlukan Login & Verifikasi)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // --- Rute Profil (Menampilkan & Mengupdate Data Formulir) ---
    // Menggunakan FormulirController untuk menampilkan dan memperbarui data utama
    Route::get('/profile', [FormulirController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [FormulirController::class, 'update'])->name('profile.update');

    // --- Rute Hapus Akun ---
    // Tetap menggunakan ProfileController karena fungsinya spesifik untuk menghapus user
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Rute Formulir Pendaftaran (Hanya untuk user baru) ---
    Route::get('/formulir', [FormulirController::class, 'create'])->name('formulir.create');
    Route::post('/formulir', [FormulirController::class, 'store'])->name('formulir.store');

});

// Memuat rute otentikasi dari Breeze (login, register, dll.)
require __DIR__.'/auth.php';
