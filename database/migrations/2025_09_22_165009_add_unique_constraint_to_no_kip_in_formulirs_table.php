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
            $table->string('no_kip')->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('formulirs', function (Blueprint $table) {
            // Drop the unique constraint
            $table->dropUnique(['no_kip']);

            // Perlu mengubah kembali kolom ke nullable jika sebelumnya nullable
            $table->string('no_kip')->nullable()->change();
        });
    }
};
