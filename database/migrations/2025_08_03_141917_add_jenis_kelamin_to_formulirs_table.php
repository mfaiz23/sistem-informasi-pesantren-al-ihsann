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
        Schema::table('formulirs', function (Blueprint $table) {
            // Menambahkan kolom jenis_kelamin setelah kolom tanggal_lahir
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->after('tanggal_lahir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('formulirs', function (Blueprint $table) {
            // Menghapus kolom jenis_kelamin jika migrasi di-rollback
            $table->dropColumn('jenis_kelamin');
        });
    }
};
