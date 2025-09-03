    <?php

    use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('parents', function (Blueprint $table) {
            // Hapus kolom-kolom lama
            $table->dropColumn(['nama_ayah', 'no_telp_ayah', 'nama_ibu', 'no_telp_ibu', 'nama_wali', 'no_telp_wali']);

            // Tambahkan kolom baru yang lebih fleksibel
            $table->string('nama_lengkap');
            $table->string('no_telp', 15);
            $table->text('alamat');
            $table->string('hubungan_keluarga');
        });
    }

    public function down(): void
    {
        Schema::table('parents', function (Blueprint $table) {
            // Logika untuk mengembalikan perubahan jika migrasi di-rollback
            $table->string('nama_ayah');
            $table->string('no_telp_ayah', 15);
            $table->string('nama_ibu');
            $table->string('no_telp_ibu', 15);
            $table->string('nama_wali')->nullable();
            $table->string('no_telp_wali', 15)->nullable();

            $table->dropColumn(['nama_lengkap', 'no_telp', 'alamat', 'hubungan_keluarga']);
        });
    }
};
