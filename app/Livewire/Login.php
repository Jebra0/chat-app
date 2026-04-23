<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    // These are public properties.
    // They are automatically available to your Blade view.
    public string $email = '';
    public string $password = '';

    /**
     * This method handles the login logic.
     * It is called when you submit the form in the frontend.
     */
    public function authenticate()
    {
        // 1. Validation
        // This checks if the data is correct before trying to log in.
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Attempt to log in
        // Auth::attempt is a standard Laravel way to check credentials.
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            // Success! Redirect to the chat page.
            return redirect()->intended('/chat');
        }

        // 3. Handle Failure
        // If it fails, we add an error message to the email field.
        $this->addError('email', 'These credentials do not match our records.');
    }

    /**
     * This defines which Blade file should be used for the UI.
     */
    public function render()
    {
        return view('livewire.login');
    }
}
