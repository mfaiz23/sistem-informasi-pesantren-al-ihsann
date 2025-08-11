<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formulir_id')->constrained('formulirs')->onDelete('cascade');
            
            // Data Ayah
            $table->string('nama_ayah');
            $table->string('no_telp_ayah');
            
            // Data Ibu
            $table->string('nama_ibu');
            $table->string('no_telp_ibu');

            // Data Wali (Opsional)
            $table->string('nama_wali')->nullable();
            $table->string('no_telp_wali')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parents');
    }
};
