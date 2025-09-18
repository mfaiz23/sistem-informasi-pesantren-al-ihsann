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
        Schema::create('faq', function (Blueprint $table) {
            $table->id();

            // FK untuk topik
            $table->unsignedBigInteger('faq_topic_id');

            // FK untuk user (admin) yang mengelola
            $table->unsignedBigInteger('users_id');

            $table->text('pertanyaan');
            $table->text('jawaban');

            $table->timestamps();

            // Mendefinisikan Foreign Key Constraint
            $table->foreign('faq_topic_id')->references('id')->on('faq_topics')->onDelete('cascade');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faq');
    }
};
