<?php

namespace App\Services\User;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    protected UserRepository $userRepository;

    /**
     * Inject the UserRepository.
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Handle user registration.
     * 
     * @param array $data
     * @return bool
     */
    public function registerUser(array $data): bool
    {
        // 1. Create the user using our Repository
        $user = $this->userRepository->create($data);

        if ($user) {
            // 2. Log the user in
            Auth::login($user);
            return true;
        }

        return false;
    }

    /**
     * Handle user authentication.
     * 
     * @param array $credentials
     * @return bool
     * @throws ValidationException
     */
    public function attemptLogin(array $credentials): bool
    {
        if (Auth::attempt($credentials)) {
            return true;
        }

        // If it fails, we throw a validation exception that Livewire can catch
        throw ValidationException::withMessages([
            'email' => ['These credentials do not match our records.'],
        ]);
    }
}
