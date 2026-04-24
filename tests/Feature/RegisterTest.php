<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use App\Livewire\Auth\Register;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_page_is_accessible()
    {
        $this->get('/register')->assertStatus(200);
    }

    /** @test */
    public function test_can_register_a_user()
    {
        Livewire::test(Register::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.com')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->call('register')
            ->assertRedirect('/chat');

        $this->assertTrue(User::whereEmail('john@example.com')->exists());
        $this->assertAuthenticated();
    }

    /** @test */
    public function test_validation_errors_on_registration()
    {
        Livewire::test(Register::class)
            ->set('name', '')
            ->set('email', 'not-an-email')
            ->set('password', 'short')
            ->call('register')
            ->assertHasErrors(['name', 'email', 'password']);
    }

    /** @test */
    public function test_cannot_register_with_duplicate_email()
    {
        User::factory()->create(['email' => 'john@example.com']);

        Livewire::test(Register::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.com')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->call('register')
            ->assertHasErrors(['email' => 'unique']);
    }
}
