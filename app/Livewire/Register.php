<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository;
use App\Services\User\AuthService;

class Register extends Component
{
    // Properties for the registration form
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    protected AuthService $authService;

    /**
     * Inject the AuthService.
     */
    public function boot(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Handle the registration process.
     */
    public function register()
    {
        // 1. Validation (Stays in the component because it's UI-related)
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        // 2. Use the Service to handle the logic
        if ($this->authService->registerUser($validated)) {
            return redirect()->route('chat');
        }
    }

    public function render()
    {
        return view('livewire.register');
    }
}
