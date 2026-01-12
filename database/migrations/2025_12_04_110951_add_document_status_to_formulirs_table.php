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
            // Status default 'pending' (belum diperiksa)
            $table->string('status_dokumen_ktp')->default('pending')->after('dokumen_ktp');
            $table->string('alasan_tolak_ktp')->nullable()->after('status_dokumen_ktp');

            $table->string('status_dokumen_kk')->default('pending')->after('dokumen_kk');
            $table->string('alasan_tolak_kk')->nullable()->after('status_dokumen_kk');

            $table->string('status_dokumen_ijazah')->default('pending')->after('dokumen_ijazah');
            $table->string('alasan_tolak_ijazah')->nullable()->after('status_dokumen_ijazah');
        });

        // Tambahkan kolom alasan di tabel KIP (jika belum ada)
        Schema::table('kip_documents', function (Blueprint $table) {
            if (! Schema::hasColumn('kip_documents', 'alasan_penolakan')) {
                $table->string('alasan_penolakan')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('formulirs', function (Blueprint $table) {
            $table->dropColumn([
                'status_dokumen_ktp', 'alasan_tolak_ktp',
                'status_dokumen_kk', 'alasan_tolak_kk',
                'status_dokumen_ijazah', 'alasan_tolak_ijazah',
            ]);
        });

        Schema::table('kip_documents', function (Blueprint $table) {
            $table->dropColumn('alasan_penolakan');
        });
    }
};
