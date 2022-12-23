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
        Route::get('trashed', [CategorieTerrainController::class, 'trashed'])->name('trashed');
        Route::get('create', [CategorieTerrainController::class, 'create'])->name('create');
        Route::get('edit/{id}', [CategorieTerrainController::class, 'edit'])->name('edit');
        Route::get('restore/{id}', [CategorieTerrainController::class, 'restore'])->name('restore');
        Route::get('trash/{id}', [CategorieTerrainController::class, 'trash'])->name('trash');
        Route::get('delete/{id}', [CategorieTerrainController::class, 'delete'])->name('delete');
        Route::post('search', [CategorieTerrainController::class, 'search'])->name('search');
        Route::post('search-trashed', [CategorieTerrainController::class, 'searchTrashed'])->name('searchTrashed');
        Route::post('store', [CategorieTerrainController::class, 'store'])->name('store');
        Route::post('update', [CategorieTerrainController::class, 'update'])->name('update');
    });
});
