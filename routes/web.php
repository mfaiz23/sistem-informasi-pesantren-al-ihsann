<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormulirController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Rute untuk manajemen pengguna (calon mahasiswa)
    // Resource route akan otomatis membuat semua route CRUD
    Route::resource('users', UserController::class);

    // Route tambahan jika diperlukan untuk custom naming
    Route::get('/management-users', [UserController::class, 'index'])->name('management-users');

    // Anda bisa tambahkan rute admin lainnya di sini
    Route::get('/pendaftaran-santri', function () {
        return view('admin.pendaftaran-santri');
    })->name('pendaftaran');
    Route::get('/keuangan', function () {
        return view('admin.keuangan');
    })->name('keuangan');
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
