<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Services\User\AuthService;

class Login extends Component
{
    // These are public properties.
    // They are automatically available to your Blade view.
    public string $email = '';
    public string $password = '';

    protected AuthService $authService;

    /**
     * Inject the AuthService.
     */
    public function boot(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * This method handles the login logic.
     */
    public function authenticate()
    {
        // 1. Validation
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Use the Service to handle the login
        if ($this->authService->attemptLogin($credentials)) {
            return redirect()->route('chat');
        }
    }

    /**
     * This defines which Blade file should be used for the UI.
     */
    public function render()
    {
        return view('livewire.auth.login');
    }
}
