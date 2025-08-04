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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Kolom yang disesuaikan dengan ERD
            $table->enum('jenis_pembayaran', ['formulir', 'pangkal', 'lainnya']);
            $table->decimal('jumlah', 10, 2); // Menggunakan decimal untuk nilai uang
            $table->enum('metode', ['midtrans'])->default('midtrans');
            
            // Info dari Midtrans
            $table->string('midtrans_order_id')->nullable();
            $table->string('midtrans_transaction_id')->nullable();
            $table->enum('midtrans_status', ['pending', 'settlement', 'deny', 'expire', 'cancel'])->nullable();

            // Status internal aplikasi
            $table->enum('status', ['pending', 'berhasil', 'gagal'])->default('pending');
            
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
