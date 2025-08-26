<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormulirController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TncController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('users', UserController::class);
    Route::get('/management-users', [UserController::class, 'index'])->name('management-users');

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


    // Rute Profil
    Route::get('/profile', [FormulirController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [FormulirController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute Formulir Pendaftaran
    Route::get('/formulir', [FormulirController::class, 'create'])->name('formulir.create');
    Route::post('/formulir', [FormulirController::class, 'store'])->name('formulir.store');

    // Rute Pembayaran Formulir
    Route::get('/payment/create', [PaymentController::class, 'create'])->name('payment.create');

    // Rute untuk menangani persetujuan T&C
    Route::post('/tnc/accept', [TncController::class, 'accept'])->name('tnc.accept');

});

/*
|--------------------------------------------------------------------------
| Rute Notifikasi Midtrans (Webhook)
|--------------------------------------------------------------------------
*/
Route::post('/midtrans/notification', [PaymentController::class, 'notificationHandler'])->name('midtrans.notification');

// Memuat rute otentikasi dari Breeze
require __DIR__.'/auth.php';
