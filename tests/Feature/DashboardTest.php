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
        
        $response = $this->withoutVite()->get('/dashboard');

        $response->assertRedirect('/login');
    }

    /**
     * 
     * Skenario 2: Pengguna yang login bisa melihat dashboard-nya.
     */
    #[Test]
    public function authenticated_users_can_see_their_dashboard()
    {
        
        $user = User::factory()->create();
        $formulir = Formulir::factory()->create(['user_id' => $user->id]);
        $response = $this->withoutVite()->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertViewIs('dashboard');

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
