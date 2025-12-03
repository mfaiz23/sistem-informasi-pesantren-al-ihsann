<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('formulirs', function (Blueprint $table) {
            // Menambah kolom untuk path dokumen (nullable karena mungkin diisi bertahap)
            $table->string('dokumen_ktp')->nullable()->after('status_pendaftaran');
            $table->string('dokumen_kk')->nullable()->after('dokumen_ktp');
            $table->string('dokumen_ijazah')->nullable()->after('dokumen_kk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('formulirs', function (Blueprint $table) {
            $table->dropColumn(['dokumen_ktp', 'dokumen_kk', 'dokumen_ijazah']);
        });
    }
};
