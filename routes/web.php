<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Rute ini tidak memerlukan login sama sekali.
|
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
|
| Semua rute di bawah ini memerlukan pengguna untuk login DAN telah
| memverifikasi alamat email mereka.
|
*/

// Rute Dashboard sudah benar
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grup rute profil sekarang juga dilindungi oleh verifikasi email
Route::middleware(['auth', 'verified'])->group(function () { // <-- PERUBAHAN DI SINI
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Memuat rute otentikasi dari Breeze (login, register, dll.)
require __DIR__.'/auth.php';