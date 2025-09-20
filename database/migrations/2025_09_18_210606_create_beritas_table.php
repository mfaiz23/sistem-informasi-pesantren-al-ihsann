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
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade'); // FK ke tabel users. Jika user dihapus, beritanya juga terhapus.
            $table->string('judul');
            $table->longText('isi');
            $table->string('gambar')->nullable();
            $table->enum('status', ['published', 'draft'])->default('draft'); // Enum dengan default value 'draft'
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
