<?php

use App\Http\Controllers\Staf\StafExportController;

/**
 * Barang Export Routes 
 */
Route::get(
    '/export',
    [StafExportController::class, 'exportStaf']
)->name('staf.pdf');


Route::get(
    '/export/excel',
    [StafExportController::class, 'exportExcelStaf']
)->name('staf.excel');
