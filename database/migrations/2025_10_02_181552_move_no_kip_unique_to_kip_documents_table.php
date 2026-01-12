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
        // Langkah 1: Hapus unique constraint dari tabel 'formulirs'
        Schema::table('formulirs', function (Blueprint $table) {
            // Nama constraint default Laravel adalah nama_tabel_nama_kolom_unique
            $table->dropUnique('formulirs_no_kip_unique');
        });

        // Langkah 2: Tambahkan kolom no_kip dan unique constraint ke tabel 'kip_documents'
        Schema::table('kip_documents', function (Blueprint $table) {
            $table->string('no_kip')->after('id')->unique()->comment('Nomor Kartu Indonesia Pintar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Langkah 1 (dibalik): Hapus kolom no_kip dari 'kip_documents'
        Schema::table('kip_documents', function (Blueprint $table) {
            // Drop unique dulu baru drop kolom
            $table->dropUnique('kip_documents_no_kip_unique');
            $table->dropColumn('no_kip');
        });

        // Langkah 2 (dibalik): Tambahkan kembali unique constraint ke 'formulirs'
        Schema::table('formulirs', function (Blueprint $table) {
            $table->unique('no_kip');
        });
    }
};
