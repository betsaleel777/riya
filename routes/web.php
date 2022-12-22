<?php

use App\Http\Controllers\Categories\CategorieTerrainController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::prefix('terrains')->name('terrain.')->group(function () {
    Route::prefix('types')->name('type.')->group(function () {
        Route::get('/', [CategorieTerrainController::class, 'index'])->name('index');
        Route::get('/create', [CategorieTerrainController::class, 'create'])->name('create');
        Route::get('show/{id}', [CategorieTerrainController::class, 'show'])->name('show');
        Route::get('store', [CategorieTerrainController::class, 'store'])->name('store');
    });
});
