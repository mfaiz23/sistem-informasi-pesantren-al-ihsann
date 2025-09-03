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
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade');

            $table->decimal('amount', 10, 2);
            $table->string('payment_method');

            // Menggabungkan status dari Midtrans dan status internal
            $table->string('status');

            $table->string('midtrans_order_id')->nullable();
            $table->string('midtrans_transaction_id')->nullable();

            // raw_response lebih baik menggunakan JSON atau TEXT
            $table->json('raw_response')->nullable();

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
