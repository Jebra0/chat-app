<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;

Route::get('/chat', function () {
    return view('chat');
})->name('chat');

Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');
