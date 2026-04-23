<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Register extends Component
{
    // Properties for the registration form
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle the registration process.
     */
    public function register()
    {
        // 1. Validation
        // We add 'confirmed' to password to make sure it matches password_confirmation
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        // 2. Create the User
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // 3. Log the user in
        Auth::login($user);

        // 4. Redirect to the chat/dashboard
        return redirect()->intended('/chat');
    }

    public function render()
    {
        return view('livewire.register');
    }
}
