<?php

use App\Http\Livewire\Barang\Barang;
use App\Http\Livewire\Barang\AddBarang;
use App\Http\Livewire\Barang\DetailBarang;
use App\Http\Livewire\Barang\EditBarang;

use App\Http\Livewire\KategoriBarang\Kategori;
use App\Http\Livewire\KategoriBarang\AddKategori;
use App\Http\Livewire\KategoriBarang\EditKategori;

use App\Http\Livewire\Staf\Staf;
use App\Http\Livewire\Staf\EditStaf;
use App\Http\Livewire\Staf\AddStaf;

use App\Http\Livewire\ResetPassword;
use App\Http\Livewire\ForgotPassword;
use App\Http\Livewire\Auth\Login;
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

Route::redirect('/', '/login');

Route::get('/login', Login::class)->name('login');

Route::get('/forgot-password', ForgotPassword::class)->name('forgot-password');

Route::get('/reset-password/{id}', ResetPassword::class)->name('reset-password')->middleware('signed');

Route::middleware('auth')->group(function () {

    // Route::middleware('role:1')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    
    // Staf
    Route::get('/staf', Staf::class)->name('staf');
    Route::get('/staf/add', AddStaf::class)->name('staf.add');
    Route::get('/staf/edit/{stafId}', EditStaf::class)->name('staf.edit');

    // Kategori
    Route::get('/kategori', Kategori::class)->name('kategori');
    Route::get('/kategori/add', AddKategori::class)->name('kategori.add');
    Route::get('/kategori/edit/{kategoriId}', EditKategori::class)->name('kategori.edit');

    // Barang
    Route::get('/barang', action: Barang::class)->name('barang');
    Route::get('/barang/add', AddBarang::class)->name('barang.add');
    Route::get('/barang/edit/{barangId}', EditBarang::class)->name('barang.edit');
    Route::get('/barang/detail/{barangId}', DetailBarang::class)->name('barang.detail');

});
