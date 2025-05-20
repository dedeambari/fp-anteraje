<?php

use App\Http\Livewire\Profile;
use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Dashboard;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/profile', Profile::class)->name('profile');

});

include __DIR__."/../auth/auth.routes.php";
include __DIR__."/../staf/staf.routes.php";
include __DIR__.'/../kategori/kategori.routes.php';
include __DIR__.'/../barang/barang.routes.php';