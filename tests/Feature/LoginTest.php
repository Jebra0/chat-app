<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use App\Livewire\Auth\Login;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_accessible()
    {
        $this->get('/login')->assertStatus(200);
    }

    /** @test */
    public function test_can_login_with_correct_credentials()
    {
        $user = User::factory()->create([
            'email' => 'jane@example.com',
            'password' => bcrypt('password123'),
        ]);

        Livewire::test(Login::class)
            ->set('email', 'jane@example.com')
            ->set('password', 'password123')
            ->call('authenticate')
            ->assertRedirect('/chat');

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function test_cannot_login_with_wrong_credentials()
    {
        User::factory()->create(['email' => 'jane@example.com']);

        Livewire::test(Login::class)
            ->set('email', 'jane@example.com')
            ->set('password', 'wrong-password')
            ->call('authenticate')
            ->assertHasErrors(['email']);

        $this->assertGuest();
    }

    /** @test */
    public function test_validation_errors_on_login()
    {
        Livewire::test(Login::class)
            ->set('email', '')
            ->set('password', '')
            ->call('authenticate')
            ->assertHasErrors(['email', 'password']);
    }
}
