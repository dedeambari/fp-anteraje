<?php

use App\Http\Livewire\ResetPassword;
use App\Http\Livewire\ForgotPassword;
use App\Http\Livewire\Auth\Login;

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/login', Login::class)->name('login');

// Route::get('/forgot-password', ForgotPassword::class)->name('forgot-password');

// Route::get('/reset-password/{id}', ResetPassword::class)->name('reset-password')->middleware('signed');
