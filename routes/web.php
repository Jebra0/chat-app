<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Login;
use App\Livewire\Register;

Route::get('/chat', function () {
    return view('welcome');
})->name('chat');

Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');
