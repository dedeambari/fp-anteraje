<?php

use App\Models\Barang as BarangModel;
use App\Http\Livewire\Barang\Barang;
use App\Http\Livewire\Barang\AddBarang;
use App\Http\Livewire\Barang\DetailBarang;
use App\Http\Livewire\Barang\EditBarang;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::prefix('barang')->middleware('auth')->group(function () {
    Route::get('/', action: Barang::class)->name('barang');
    Route::get('/add', AddBarang::class)->name('barang.add');
    Route::get('/edit/{nomorResi}', EditBarang::class)->name('barang.edit');
    Route::get('/detail/{noResi}', DetailBarang::class)->name('barang.detail');

    include __DIR__ . '/barang-export.routes.php';

});

Route::get('barang/bukti/{nomorResi}', function ($nomorResi) {
    $barang = BarangModel::with('pemrosessan')
        ->where('nomor_resi', $nomorResi)
        ->select(['id', 'nomor_resi'])
        ->firstOrFail();

    $pemrosessan = $barang->pemrosessan;
    if (!$pemrosessan->bukti || !Storage::disk('public')->exists($pemrosessan->bukti)) {
        abort(404, 'File bukti tidak ditemukan');
    }

    return response()->file(storage_path("app/public/$pemrosessan->bukti"));
})->name('barang.bukti');