<div>
    <div class="min-h-screen flex items-center justify-center bg-slate-950 p-6">
        <div class="w-full max-w-md bg-slate-900 border border-slate-800 rounded-3xl p-8 shadow-2xl">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">Welcome Back</h1>
                <p class="text-slate-400">Please enter your details to sign in</p>
            </div>

            <!-- Login Form -->
            <!-- wire:submit.prevent tells Livewire to run the authenticate method and stop the page from refreshing -->
            <form wire:submit.prevent="authenticate" class="space-y-6">
                
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        wire:model="email" 
                        placeholder="you@example.com"
                        class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"
                    >
                    @error('email') 
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        wire:model="password" 
                        placeholder="••••••••"
                        class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"
                    >
                    @error('password') 
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password (Optional) -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center text-slate-400">
                        <input type="checkbox" class="mr-2 rounded border-slate-700 bg-slate-800 text-blue-500 focus:ring-blue-500">
                        Remember me
                    </label>
                    <a href="#" class="text-blue-400 hover:text-blue-300 transition-colors">Forgot password?</a>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    wire:loading.attr="disabled"
                    class="w-full bg-blue-600 hover:bg-blue-500 disabled:opacity-70 disabled:cursor-not-allowed text-white font-semibold py-3 rounded-xl shadow-lg shadow-blue-900/20 transition-all flex items-center justify-center gap-2 group"
                >
                    <!-- Normal State -->
                    <span wire:loading.remove wire:target="authenticate" class="flex items-center gap-2">
                        Sign In
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </span>

                    <!-- Loading State -->
                    <span wire:loading wire:target="authenticate">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </button>
            </form>

            <!-- Footer -->
            <p class="text-center text-slate-500 text-sm mt-8">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 font-medium" wire:navigate>Sign up for free</a>
            </p>
        </div>
    </div>
</div>
