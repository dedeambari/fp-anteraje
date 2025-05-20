<?php

use App\Http\Controllers\Api\StafHomeController;
use App\Http\Controllers\Api\StafProfileController;
use App\Http\Controllers\Api\StafTaskController;
use App\Http\Controllers\Api\TrackingResiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Tracking Barang 
Route::post('/tracking', [TrackingResiController::class, 'trackResi']);


/**
 * Auth Staf Login, Logout & Forgot Password
 */
include __DIR__ . '/auth/auth.api.routes.php';


/**
 * Home Api Staf
 */
Route::prefix('staf')->middleware('auth:sanctum')->group(function () {
    Route::get('/home', [StafHomeController::class, 'index'])
        ->name('api.staf.home');

    // Task Staf
    Route::get('/task', [StafTaskController::class, 'index'])
        ->name('api.staf.task');
    Route::get('/task/detail-barang', [StafTaskController::class, 'detailBarang'])
        ->name('api.staf.task.detail-barang');
    Route::put('/task/update-prosess', [StafTaskController::class, 'updateProsessBarang'])
        ->name('api.staf.task.update-prosess');

    // Profile Staf
    Route::get('/profile', [StafProfileController::class, 'index'])
        ->name('api.staf.profile');
    Route::put('/profile/update', [StafProfileController::class, 'updateProfile'])
        ->name('api.staf.profile.update');

});
