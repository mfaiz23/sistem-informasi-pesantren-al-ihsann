<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Models\User;

class TermsConditionTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function tnc_modal_is_shown_to_new_user_on_dashboard(): void
    {
        // Arrange: Buat user baru (accepted_tnc_at akan otomatis null)
        $user = User::factory()->create();

        // Act: Login sebagai user dan kunjungi dashboard
        $response = $this->withoutVite()
                         ->actingAs($user)
                         ->get('/dashboard');

        // Assert: Pastikan ada teks dari modal di halaman
        $response->assertStatus(200);
        $response->assertSee('Syarat dan Ketentuan');
    }

    #[Test]
    public function user_can_accept_the_tnc(): void
    {
        // Arrange: Buat user baru
        $user = User::factory()->create();

        // Act: Login dan simulasikan submit form persetujuan T&C
        $response = $this->actingAs($user)->post(route('tnc.accept'));

        // Assert:
        // 1. Pastikan diarahkan kembali ke dashboard
        $response->assertRedirect('/dashboard');

        // 2. Periksa database untuk memastikan timestamp sudah tersimpan
        // Gunakan fresh() untuk mendapatkan data terbaru dari database
        $this->assertNotNull($user->fresh()->accepted_tnc_at);
    }

    #[Test]
    public function tnc_modal_is_not_shown_after_user_accepts(): void
    {
        // Arrange: Buat user yang seolah-olah sudah pernah setuju
        $user = User::factory()->create([
            'accepted_tnc_at' => now(),
        ]);

        // Act: Login sebagai user dan kunjungi dashboard
        $response = $this->withoutVite()
                         ->actingAs($user)
                         ->get('/dashboard');

        // Assert: Pastikan teks dari modal TIDAK ADA di halaman
        $response->assertStatus(200);
        $response->assertDontSee('Syarat dan Ketentuan Layanan');
    }
}
