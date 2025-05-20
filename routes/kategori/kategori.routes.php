<?php

use App\Http\Livewire\KategoriBarang\Kategori;
use App\Http\Livewire\KategoriBarang\AddKategori;
use App\Http\Livewire\KategoriBarang\EditKategori;

use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {

	// Kategori
	Route::get('/kategori', Kategori::class)->name('kategori');
	Route::get('/kategori/add', AddKategori::class)->name('kategori.add');
	Route::get('/kategori/edit/{kategoriId}', EditKategori::class)->name('kategori.edit');
});