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

            $table->string('nik', 20);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('asal_sekolah');
            $table->enum('kategori_pendaftaran', ['Reguler', 'Non Reguler']);
            
            $table->string('no_kip')->nullable();
            $table->string('dokumen_kip')->nullable(); 

            $table->string('no_hp_orang_tua');
            $table->boolean('pernyataan_persetujuan');

            $table->enum('status_pendaftaran', ['proses', 'diterima', 'ditolak'])->default('proses');
            $table->enum('status_pembayaran_formulir', ['menunggu_pembayaran', 'lunas', 'gagal', 'menunggu_verifikasi'])->default('menunggu_pembayaran');
            
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
