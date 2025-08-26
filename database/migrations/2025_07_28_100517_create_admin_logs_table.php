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
        Schema::create('admin_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users'); // FK ke tabel users
            $table->enum('action_type', [
                'create', 'update', 'delete', 'login', 'logout',
                'verify_kip_dok', 'verify_pendaftaran',
            ]);
            $table->unsignedBigInteger('target_id');
            $table->string('target_type');
            $table->timestamp('action_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_logs');
    }
};
