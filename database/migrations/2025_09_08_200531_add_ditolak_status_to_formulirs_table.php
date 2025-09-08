<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // DIPERBAIKI: Menyertakan 'baru', menggunakan 'menunggu_verifikasi', dan mempertahankan default 'baru'
        DB::statement("ALTER TABLE formulirs MODIFY COLUMN status_pendaftaran ENUM('baru', 'menunggu_verifikasi', 'diverifikasi', 'ditolak') NOT NULL DEFAULT 'baru'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Mengembalikan ke kondisi semula (tanpa 'ditolak')
        DB::statement("ALTER TABLE formulirs MODIFY COLUMN status_pendaftaran ENUM('baru', 'menunggu_verifikasi', 'diverifikasi') NOT NULL DEFAULT 'baru'");
    }
};
