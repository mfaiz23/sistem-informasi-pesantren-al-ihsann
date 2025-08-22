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
        Schema::create('formulir_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formulir_id')->constrained('formulirs')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users'); // FK ke tabel users
            $table->string('field_name');
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
            $table->timestamp('edited_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formulir_logs');
    }
};
