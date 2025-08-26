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
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom baru bernama 'accepted_tnc_at'
            // Kolom ini bisa kosong (nullable) dan diletakkan setelah kolom 'role'
            $table->timestamp('accepted_tnc_at')->nullable()->after('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Jika migrasi dibatalkan, hapus kolom ini
            $table->dropColumn('accepted_tnc_at');
        });
    }
};
