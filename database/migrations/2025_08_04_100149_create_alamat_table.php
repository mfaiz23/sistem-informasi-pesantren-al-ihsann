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
        Schema::create('alamat', function (Blueprint $table) {
            $table->id();
            // Setiap alamat berelasi dengan satu formulir.
            // Jika data formulir dihapus, data alamat terkait juga akan terhapus.
            $table->foreignId('formulir_id')->constrained('formulirs')->onDelete('cascade');
            
            $table->string('negara');
            $table->string('provinsi');
            $table->string('kota_kabupaten');
            $table->string('kecamatan');
            $table->string('desa_kelurahan');
            $table->text('alamat_lengkap');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alamat');
    }
};
