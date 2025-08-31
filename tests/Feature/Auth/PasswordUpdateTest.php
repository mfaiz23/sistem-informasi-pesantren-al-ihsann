<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class PasswordUpdateTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_password_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->put('/password', [
                'current_password' => 'password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertTrue(Hash::check('new-password', $user->refresh()->password));
    }

    #[Test]
    public function test_correct_password_must_be_provided_to_update_password(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->put('/password', [
                'current_password' => 'wrong-password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response
            ->assertSessionHasErrorsIn('updatePassword', 'current_password')
            ->assertRedirect('/profile');
    }

    #[Test]
    public function test_new_password_must_be_confirmed(): void
    {
        // Skenario konfirmasi kata sandi baru tidak cocok
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->put('/password', [
                'current_password' => 'password',
                'password' => 'new-password',
                'password_confirmation' => 'different-new-password', // <-- Sengaja disalahkan
            ]);

        $response
            ->assertSessionHasErrors('updatePassword')
            ->assertRedirect('/profile');
    }
    
    #[Test]
    public function test_new_password_must_meet_minimum_length(): void
    {
        // Skenario kata sandi baru terlalu pendek
        $user = User::factory()->create();
    
        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->put('/password', [
                'current_password' => 'password',
                'password' => '123', // <-- Sengaja dibuat terlalu pendek
                'password_confirmation' => '123',
            ]);
    
        $response->assertSessionHasErrors('password');
        $this->assertTrue(Hash::check('password', $user->refresh()->password));
    }

    #[Test]
    public function test_current_password_is_required(): void
    {
        // Skenario kata sandi saat ini dikosongkan
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->put('/password', [
                'current_password' => '', // <-- Sengaja dikosongkan
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response->assertSessionHasErrors('current_password');
        $this->assertTrue(Hash::check('password', $user->refresh()->password));
    }

    #[Test]
    public function test_new_password_is_required(): void
    {
        // Skenario kata sandi baru dikosongkan
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->put('/password', [
                'current_password' => 'password',
                'password' => '', // <-- Sengaja dikosongkan
                'password_confirmation' => '',
            ]);

        $response->assertSessionHasErrors('password');
        $this->assertTrue(Hash::check('password', $user->refresh()->password));
    }
}
