<?php

use App\Http\Livewire\Staf\Staf;
use App\Http\Livewire\Staf\EditStaf;
use App\Http\Livewire\Staf\AddStaf;

use Illuminate\Support\Facades\Route;


Route::prefix('staf')->middleware('auth')->group(function () {
    // Staf
    Route::get('/', Staf::class)->name('staf');
    Route::get('/add', AddStaf::class)->name('staf.add');
    Route::get('/edit/{stafId}', EditStaf::class)->name('staf.edit');

    include __DIR__.'/staf-export.routes.php';
});