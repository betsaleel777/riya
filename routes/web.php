<?php

use App\Http\Controllers\Categories\CategorieAppartementController;
use App\Http\Controllers\Categories\CategorieTerrainController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
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
        Route::get('export', [CategorieTerrainController::class, 'export'])->name('export');
        Route::post('search', [CategorieTerrainController::class, 'search'])->name('search');
        Route::post('search-trashed', [CategorieTerrainController::class, 'searchTrashed'])->name('searchTrashed');
        Route::post('store', [CategorieTerrainController::class, 'store'])->name('store');
        Route::post('update', [CategorieTerrainController::class, 'update'])->name('update');
    });
});
Route::prefix('appartements')->name('appartement.')->group(function () {
    Route::prefix('types')->name('type.')->group(function () {
        Route::get('/', [CategorieAppartementController::class, 'index'])->name('index');
        Route::get('trashed', [CategorieAppartementController::class, 'trashed'])->name('trashed');
        Route::get('create', [CategorieAppartementController::class, 'create'])->name('create');
        Route::get('edit/{id}', [CategorieAppartementController::class, 'edit'])->name('edit');
        Route::get('restore/{id}', [CategorieAppartementController::class, 'restore'])->name('restore');
        Route::get('trash/{id}', [CategorieAppartementController::class, 'trash'])->name('trash');
        Route::get('export', [CategorieAppartementController::class, 'export'])->name('export');
        Route::post('search', [CategorieAppartementController::class, 'search'])->name('search');
        Route::post('search-trashed', [CategorieAppartementController::class, 'searchTrashed'])->name('searchTrashed');
        Route::get('delete/{id}', [CategorieAppartementController::class, 'delete'])->name('delete');
        Route::post('store', [CategorieAppartementController::class, 'store'])->name('store');
        Route::post('update', [CategorieAppartementController::class, 'update'])->name('update');
    });
});
Route::prefix('utilisateurs')->name('user.')->group(function () {
    Route::resource('users', UserController::class);
    Route::get('trashed', [UserController::class, 'trashed'])->name('trashed');
    Route::get('restore/{id}', [UserController::class, 'restore'])->name('restore');
    Route::get('trash/{id}', [UserController::class, 'trash'])->name('trash');
    Route::get('export', [UserController::class, 'export'])->name('export');
    Route::post('search', [UserController::class, 'search'])->name('search');
    Route::post('search-trashed', [UserController::class, 'searchTrashed'])->name('searchTrashed');
});
