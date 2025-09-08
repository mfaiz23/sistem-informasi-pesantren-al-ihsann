<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FormulirController as AdminFormulirController;
use App\Http\Controllers\Admin\KeuanganController as AdminKeuanganController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
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

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', AdminUserController::class);
    Route::get('/management-users', [AdminUserController::class, 'index'])->name('management-users');

    // PERBAIKAN: Ganti rute ini agar memanggil FormulirController
    Route::get('/pendaftaran-santri', [AdminFormulirController::class, 'index'])->name('pendaftaran');
    // PERBAIKAN: Hapus prefix 'admin.' dari name() karena sudah ada di grup
    Route::post('/formulir/verifikasi/{id}', [AdminFormulirController::class, 'verifikasi'])
        ->name('formulir.verifikasi'); // ← Hanya 'formulir.verifikasi'

    Route::get('/formulir/download-kip/{id}', [AdminFormulirController::class, 'downloadKipDocument'])->name('formulir.download_kip');

    // PERBAIKAN: Hapus '/admin' yang berulang dari path
    Route::delete('/formulir/{id}', [AdminFormulirController::class, 'destroy'])
        ->name('formulir.destroy'); // ← Hanya 'formulir.destroy'

    Route::post('/formulir/tolak/{id}', [AdminFormulirController::class, 'tolak'])
        ->name('formulir.tolak');

    Route::get('/keuangan', [AdminKeuanganController::class, 'index'])->name('keuangan');
    Route::get('/keuangan/cetak', [AdminKeuanganController::class, 'cetakPdf'])->name('keuangan.cetak');

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
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Rute Formulir Pendaftaran (Hanya untuk user baru) ---

    Route::get('/formulir', [FormulirController::class, 'create'])->name('formulir.create');
    Route::post('/formulir', [FormulirController::class, 'store'])->name('formulir.store');

    // Rute Pembayaran Formulir
    Route::get('/payment/create', [PaymentController::class, 'create'])->name('payment.create');

    // Rute untuk menangani persetujuan T&C
    Route::post('/tnc/accept', [TncController::class, 'accept'])->name('tnc.accept');

});

// Memuat rute otentikasi dari Breeze (login, register, dll.)
/*
|--------------------------------------------------------------------------
| Rute Notifikasi Midtrans (Webhook)
|--------------------------------------------------------------------------
*/
Route::post('/midtrans/notification', [PaymentController::class, 'notificationHandler'])->name('midtrans.notification');

require __DIR__.'/auth.php';
