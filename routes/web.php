<?php

use App\Http\Controllers\AppartementController;
use App\Http\Controllers\Categories\CategorieAppartementController;
use App\Http\Controllers\Categories\CategorieTerrainController;
use App\Http\Controllers\Categories\TypeClientController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContratController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProprietaireController;
use App\Http\Controllers\TerrainController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('proprietaire')->name('proprietaire.')->group(function () {
        Route::get('/', [ProprietaireController::class, 'index'])->name('index');
        Route::get('trashed', [ProprietaireController::class, 'trashed'])->name('trashed');
        Route::get('create', [ProprietaireController::class, 'create'])->name('create');
        Route::get('edit/{id}', [ProprietaireController::class, 'edit'])->name('edit');
        Route::get('restore/{id}', [ProprietaireController::class, 'restore'])->name('restore');
        Route::get('trash/{id}', [ProprietaireController::class, 'trash'])->name('trash');
        Route::delete('destroy/{id}', [ProprietaireController::class, 'destroy'])->name('destroy');
        Route::get('export', [ProprietaireController::class, 'export'])->name('export');
        Route::post('search', [ProprietaireController::class, 'search'])->name('search');
        Route::post('search-trashed', [ProprietaireController::class, 'searchTrashed'])->name('searchTrashed');
        Route::post('store', [ProprietaireController::class, 'store'])->name('store');
        Route::post('update', [ProprietaireController::class, 'update'])->name('update');
    });
    Route::prefix('contrat')->name('contrat.')->group(function () {
        Route::get('/', [ContratController::class, 'index'])->name('index');
        Route::get('aborted', [ContratController::class, 'aborted'])->name('aborted');
        Route::get('create', [ContratController::class, 'create'])->name('create');
        Route::get('edit/{id}', [ContratController::class, 'edit'])->name('edit');
        Route::get('export', [ContratController::class, 'export'])->name('export');
        Route::post('search', [ContratController::class, 'search'])->name('search');
        Route::post('search-trashed', [ContratController::class, 'searchTrashed'])->name('searchTrashed');
        Route::post('store', [ContratController::class, 'store'])->name('store');
        Route::post('update', [ContratController::class, 'update'])->name('update');
    });
    Route::prefix('terrains')->name('terrain.')->group(function () {
        Route::get('/', [TerrainController::class, 'index'])->name('index');
        Route::get('trashed', [TerrainController::class, 'trashed'])->name('trashed');
        Route::get('create', [TerrainController::class, 'create'])->name('create');
        Route::get('edit/{id}', [TerrainController::class, 'edit'])->name('edit');
        Route::get('restore/{id}', [TerrainController::class, 'restore'])->name('restore');
        Route::get('trash/{id}', [TerrainController::class, 'trash'])->name('trash');
        Route::delete('destroy/{id}', [TerrainController::class, 'destroy'])->name('destroy');
        Route::get('export', [TerrainController::class, 'export'])->name('export');
        Route::post('search', [TerrainController::class, 'search'])->name('search');
        Route::post('search-trashed', [TerrainController::class, 'searchTrashed'])->name('searchTrashed');
        Route::post('store', [TerrainController::class, 'store'])->name('store');
        Route::post('update', [TerrainController::class, 'update'])->name('update');
        Route::prefix('types')->name('type.')->group(function () {
            Route::get('/', [CategorieTerrainController::class, 'index'])->name('index');
            Route::get('trashed', [CategorieTerrainController::class, 'trashed'])->name('trashed');
            Route::get('create', [CategorieTerrainController::class, 'create'])->name('create');
            Route::get('edit/{id}', [CategorieTerrainController::class, 'edit'])->name('edit');
            Route::get('restore/{id}', [CategorieTerrainController::class, 'restore'])->name('restore');
            Route::get('trash/{id}', [CategorieTerrainController::class, 'trash'])->name('trash');
            Route::delete('destroy/{id}', [CategorieTerrainController::class, 'destroy'])->name('destroy');
            Route::get('export', [CategorieTerrainController::class, 'export'])->name('export');
            Route::post('search', [CategorieTerrainController::class, 'search'])->name('search');
            Route::post('search-trashed', [CategorieTerrainController::class, 'searchTrashed'])->name('searchTrashed');
            Route::post('store', [CategorieTerrainController::class, 'store'])->name('store');
            Route::post('update', [CategorieTerrainController::class, 'update'])->name('update');
        });
    });
    Route::prefix('appartements')->name('appartement.')->group(function () {
        Route::get('/', [AppartementController::class, 'index'])->name('index');
        Route::get('trashed', [AppartementController::class, 'trashed'])->name('trashed');
        Route::get('create', [AppartementController::class, 'create'])->name('create');
        Route::get('edit/{id}', [AppartementController::class, 'edit'])->name('edit');
        Route::get('restore/{id}', [AppartementController::class, 'restore'])->name('restore');
        Route::get('trash/{id}', [AppartementController::class, 'trash'])->name('trash');
        Route::delete('destroy/{id}', [AppartementController::class, 'destroy'])->name('destroy');
        Route::get('export', [AppartementController::class, 'export'])->name('export');
        Route::post('search', [AppartementController::class, 'search'])->name('search');
        Route::post('search-trashed', [AppartementController::class, 'searchTrashed'])->name('searchTrashed');
        Route::post('store', [AppartementController::class, 'store'])->name('store');
        Route::post('update', [AppartementController::class, 'update'])->name('update');
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
            Route::delete('destroy/{id}', [CategorieAppartementController::class, 'destroy'])->name('destroy');
            Route::post('store', [CategorieAppartementController::class, 'store'])->name('store');
            Route::post('update', [CategorieAppartementController::class, 'update'])->name('update');
        });
    });
    Route::prefix('clients')->name('client.')->group(function () {
        Route::get('/', [ClientController::class, 'index'])->name('index');
        Route::get('trashed', [ClientController::class, 'trashed'])->name('trashed');
        Route::get('create', [ClientController::class, 'create'])->name('create');
        Route::get('edit/{id}', [ClientController::class, 'edit'])->name('edit');
        Route::get('restore/{id}', [ClientController::class, 'restore'])->name('restore');
        Route::get('trash/{id}', [ClientController::class, 'trash'])->name('trash');
        Route::get('export', [ClientController::class, 'export'])->name('export');
        Route::post('search', [ClientController::class, 'search'])->name('search');
        Route::post('search-trashed', [ClientController::class, 'searchTrashed'])->name('searchTrashed');
        Route::delete('destroy/{id}', [ClientController::class, 'destroy'])->name('destroy');
        Route::post('store', [ClientController::class, 'store'])->name('store');
        Route::post('update', [ClientController::class, 'update'])->name('update');
        Route::prefix('types')->name('type.')->group(function () {
            Route::get('/', [TypeClientController::class, 'index'])->name('index');
            Route::get('trashed', [TypeClientController::class, 'trashed'])->name('trashed');
            Route::get('create', [TypeClientController::class, 'create'])->name('create');
            Route::get('edit/{id}', [TypeClientController::class, 'edit'])->name('edit');
            Route::get('restore/{id}', [TypeClientController::class, 'restore'])->name('restore');
            Route::get('trash/{id}', [TypeClientController::class, 'trash'])->name('trash');
            Route::get('export', [TypeClientController::class, 'export'])->name('export');
            Route::post('search', [TypeClientController::class, 'search'])->name('search');
            Route::post('search-trashed', [TypeClientController::class, 'searchTrashed'])->name('searchTrashed');
            Route::delete('destroy/{id}', [TypeClientController::class, 'destroy'])->name('destroy');
            Route::post('store', [TypeClientController::class, 'store'])->name('store');
            Route::post('update', [TypeClientController::class, 'update'])->name('update');
        });
    });
    Route::prefix('utilisateurs')->group(function () {
        Route::name('user.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('create', [UserController::class, 'create'])->name('create');
            Route::get('edit/{id}', [UserController::class, 'edit'])->name('edit');
            Route::post('patch', [UserController::class, 'patch'])->name('patch');
            Route::get('show/{id}', [UserController::class, 'show'])->name('show');
            Route::get('trashed', [UserController::class, 'trashed'])->name('trashed');
            Route::get('export', [UserController::class, 'export'])->name('export');
            Route::post('search', [UserController::class, 'search'])->name('search');
            Route::post('search-trashed', [UserController::class, 'searchTrashed'])->name('searchTrashed');
            Route::get('restore/{id}', [UserController::class, 'restore'])->name('restore');
            Route::get('trash/{id}', [UserController::class, 'trash'])->name('trash');
            Route::delete('destroy/{id}', [UserController::class, 'destroy'])->name('destroy');
            Route::post('store', [UserController::class, 'store'])->name('store');
            Route::post('update', [UserController::class, 'update'])->name('update');
        });
    });
});

Auth::routes();
