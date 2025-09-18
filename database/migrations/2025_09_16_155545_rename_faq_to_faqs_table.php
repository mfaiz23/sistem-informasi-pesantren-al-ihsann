<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Mengganti nama tabel dari 'faq' menjadi 'faqs'
        Schema::rename('faq', 'faqs');
    }

    public function down(): void
    {
        // Perintah untuk membatalkan, yaitu mengembalikan nama ke 'faq'
        Schema::rename('faqs', 'faq');
    }
};
