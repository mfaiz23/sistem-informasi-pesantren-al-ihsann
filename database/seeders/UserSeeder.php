<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            // Pengguna Admin
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'no_telp' => '081234567890',
                'email_verified_at' => now(),
                'password' => Hash::make('admin123'), 
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Pengguna Calon Mahasiswa
            [
                'name' => 'Calon Mahasiswa',
                'email' => 'mahasiswa@gmail.com',
                'no_telp' => '089876543210',
                'email_verified_at' => now(),
                'password' => Hash::make('mahasiswa'), 
                'role' => 'calon_mahasiswa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
