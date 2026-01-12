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
            $table->year('tahun_lulus_sd')->change();
            $table->year('tahun_lulus_smp')->change();
            $table->year('tahun_lulus_sma')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('formulirs', function (Blueprint $table) {
            $table->string('tahun_lulus_sd')->change();
            $table->string('tahun_lulus_smp')->change();
            $table->string('tahun_lulus_sma')->change();
        });
    }
};
