<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Formulir; // Asumsi Anda punya model & factory Formulir
use App\Models\User;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;


class DashboardTest extends TestCase
{
    use RefreshDatabase; // Agar database bersih setiap kali tes dijalankan

    /**
     * 
     * Skenario 1: Tamu tidak bisa mengakses dashboard.
     */
    #[Test]
    public function guests_are_redirected_to_login_page()
    {
        // Act: Coba akses halaman /dashboard sebagai tamu
        $response = $this->withoutVite()->get('/dashboard');

        // Assert: Pastikan diarahkan ke halaman /login
        $response->assertRedirect('/login');
    }

    /**
     * 
     * Skenario 2: Pengguna yang login bisa melihat dashboard-nya.
     */
    #[Test]
    public function authenticated_users_can_see_their_dashboard()
    {
        // 1. Arrange (Atur)
        // Buat satu user palsu
        $user = User::factory()->create();

        // Buat data formulir yang terhubung dengan user tersebut
        $formulir = Formulir::factory()->create(['user_id' => $user->id]);

        // 2. Act (Aksi)
        // Login sebagai user tersebut dan akses halaman /dashboard
        $response = $this->withoutVite()->actingAs($user)->get('/dashboard');

        // 3. Assert (Asersi)
        // Pastikan request berhasil (status 200 OK)
        $response->assertStatus(200);

        // Pastikan view yang digunakan adalah 'dashboard'
        $response->assertViewIs('dashboard');

        // Pastikan view memiliki data 'user' dan 'formulir' yang benar
        $response->assertViewHas('user', $user);
        $response->assertViewHas('formulir', $formulir);
    }
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }
}
