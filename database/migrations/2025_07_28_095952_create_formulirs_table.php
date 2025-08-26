<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formulirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Data Pribadi
            $table->string('nama_panggilan');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('nik', 16);
            $table->enum('kategori_pendaftaran', ['Reguler', 'Non-Reguler']);
            $table->string('no_kip')->nullable();

            // Asal Sekolah (Detail)
            $table->string('asal_sd')->nullable();
            $table->string('tahun_lulus_sd')->nullable();
            $table->string('asal_smp')->nullable();
            $table->string('tahun_lulus_smp')->nullable();
            $table->string('asal_sma')->nullable();
            $table->string('tahun_lulus_sma')->nullable();
            $table->string('asal_universitas')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('fakultas')->nullable();
            $table->string('semester')->nullable();
            $table->string('angkatan')->nullable();

            // Status Sistem
            $table->enum('status_pendaftaran', ['baru', 'menunggu_verifikasi', 'diverifikasi'])->default('baru');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formulirs');
    }
};
