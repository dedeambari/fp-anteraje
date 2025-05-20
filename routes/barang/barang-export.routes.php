<?php

use App\Http\Controllers\Barang\BarangExportController;

/**
 * Barang Export Routes 
 */
Route::get(
    '/export',
    [BarangExportController::class, 'exportBarang']
)->name('barang.pdf');

Route::get(
    "/export/excel",
    [BarangExportController::class, 'exportBarangExcel']
)->name('barang.excel');

Route::get(
    '/export/detail',
    [BarangExportController::class, 'exportDetailBarang']
)->name('barang.detail.pdf');

Route::get(
    '/struk/detail/{id}',
    [BarangExportController::class, 'exportStrukDetailBarang']
)->name('barang.detail.struk.pdf');
