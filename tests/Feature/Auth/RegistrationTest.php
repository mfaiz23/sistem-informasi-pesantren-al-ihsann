<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Models\User;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;
    
    
    #[Test]
    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->withoutVite()->get('/register');

        $response->assertStatus(200);
    }

    #[Test]
    public function test_new_users_can_register(): void
    {
        $response = $this->withoutVite()->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'no_telp' => '081234567891',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [ // Pastikan data tersimpan di database
            'name' => 'Test User',
            'email' => 'test@example.com',
            'no_telp' => '081234567891',
        ]);
        $response->assertRedirect(route('dashboard', absolute: false));
    }


    #[Test]
    public function test_register_with_the_same_email()
    {
        User::factory()->create([
            'email'=>'test@example.com'
        ]);
        $response = $this->withoutVite()->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'no_telp' => '081234567891',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertSessionHasErrors('email');
        $this->assertDatabaseCount('users', 1);
        $this->assertGuest();
    }

    #[Test]
    public function test_confirm_pass_not_valid()
    {
        $response = $this->withoutVite()->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'no_telp' => '081234567891',
            'password' => 'password',
            'password_confirmation' => 'password berbeda',
        ]);
        $response->assertSessionHasErrors('password');
        $this->assertDatabaseCount('users', 0);
        $this->assertGuest();
    }

}
