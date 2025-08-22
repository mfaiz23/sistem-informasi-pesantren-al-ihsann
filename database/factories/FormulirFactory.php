<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Formulir>
 */
class FormulirFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
            'nama_panggilan' => 'cici',
            'tempat_lahir' => fake()->city(),
            'tanggal_lahir' => fake()->date(max: '2008-01-01'),
            'jenis_kelamin' => fake()->randomElement(['Laki-laki','Perempuan']),
            'kategori_pendaftaran' => fake()->randomElement(['Non-Reguler','Reguler']),
            'nik' => fake()->numerify('################'),
            // 'no_ijazah' => fake()->bothify('DN-##/M-SMA/K13/??/???????'),
            // 'no_telp_orang_tua' => fake()->phoneNumber(),
            // 'status_pembayaran_formulir' => fake()->randomElement(['lunas','belum_lunas']),
            // 'status_pendaftaran' => fake()->randomElement(['baru','menunggu_verifikasi','diverifikasi']),
            // 'created_at' => now(),
            // 'updated_at' => now(),
        ];
    }
}
