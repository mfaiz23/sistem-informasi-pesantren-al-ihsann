<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('formulirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('asal_sekolah');
            $table->enum('kategori_pendaftaran', ['Reguler', 'Non-Reguler']);
            $table->string('no_ijazah')->nullable();
            $table->string('no_telp_orang_tua');
            $table->enum('status_pembayaran_formulir', ['lunas', 'belum_lunas'])->default('belum_lunas');
            $table->enum('status_pendaftaran', ['baru', 'menunggu_verifikasi', 'diverifikasi'])->default('baru');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formulirs');
    }
};
