<div>
    <style>
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #000000;
            padding: 24px;
            font-family: 'Inter', sans-serif;
        }
        .auth-card {
            width: 100%;
            max-width: 400px;
            background-color: #121212;
            border: 1px solid #333;
            border-radius: 24px;
            padding: 32px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .auth-title {
            font-size: 28px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 8px;
            text-align: center;
        }
        .auth-subtitle {
            color: #a0a0a0;
            text-align: center;
            margin-bottom: 32px;
            font-size: 14px;
        }
        .form-group {
            margin-bottom: 16px;
        }
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #d1d1d1;
            margin-bottom: 8px;
        }
        .form-input {
            width: 100%;
            background-color: #1a1a1a;
            border: 1px solid #333;
            border-radius: 12px;
            padding: 12px 16px;
            color: #ffffff;
            font-size: 15px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-sizing: border-box;
        }
        .form-input:focus {
            border-color: #0084FF;
            box-shadow: 0 0 0 2px rgba(0, 132, 255, 0.2);
        }
        .error-text {
            color: #ff4d4d;
            font-size: 12px;
            margin-top: 4px;
            display: block;
        }
        .btn-submit {
            width: 100%;
            background-color: #0084FF;
            color: white;
            font-weight: 600;
            padding: 14px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.2s, transform 0.1s;
            margin-top: 16px;
        }
        .btn-submit:hover {
            background-color: #0073e6;
        }
        .btn-submit:active {
            transform: scale(0.98);
        }
        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        .auth-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: #888;
        }
        .auth-link {
            color: #0084FF;
            text-decoration: none;
            font-weight: 500;
        }
        .auth-link:hover {
            text-decoration: underline;
        }
    </style>

    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-title">Create Account</h1>
                <p class="auth-subtitle">Join our chat community today</p>
            </div>

            <form wire:submit.prevent="register">
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input 
                        type="text" 
                        id="name" 
                        wire:model="name" 
                        placeholder="John Doe"
                        class="form-input"
                    >
                    @error('name') 
                        <span class="error-text">{{ $message }}</span> 
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        wire:model="email" 
                        placeholder="you@example.com"
                        class="form-input"
                    >
                    @error('email') 
                        <span class="error-text">{{ $message }}</span> 
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        wire:model="password" 
                        placeholder="••••••••"
                        class="form-input"
                    >
                    @error('password') 
                        <span class="error-text">{{ $message }}</span> 
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        wire:model="password_confirmation" 
                        placeholder="••••••••"
                        class="form-input"
                    >
                </div>

                <button type="submit" class="btn-submit" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="register">Create Account</span>
                    <span wire:loading wire:target="register">Processing...</span>
                </button>
            </form>

            <p class="auth-footer">
                Already have an account? 
                <a href="{{ route('login') }}" class="auth-link" wire:navigate>Log in</a>
            </p>
        </div>
    </div>
</div>