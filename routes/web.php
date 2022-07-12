<?php

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

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\KitsController;
use App\Http\Controllers\Admin\ReserveController as AdminReserveController;
use App\Http\Controllers\User\KitsController as UserKitsController;
use App\Http\Controllers\User\ReserveController;
use Illuminate\Support\Facades\Route;

/**
 * @description Mostra o ecra inicial
 */
Route::get('/', [HomeController::class, 'index']);

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::prefix('admin')->group(function(){
        Route::get('/home', [HomeController::class, 'adminIndex'])->name('admin.home');
        Route::prefix('kits')->group(function(){
            Route::get('/', [KitsController::class, 'index'])->name('kits.index');
            Route::get('/create', [KitsController::class, 'create'])->name('kits.create');
            Route::post('/', [KitsController::class, 'store'])->name('kits.store');
            Route::get('/{id}', [KitsController::class, 'show'])->name('kits.show');
            Route::get('/{id}/edit', [KitsController::class, 'edit'])->name('kits.edit');
            Route::put('/{id}', [KitsController::class, 'update'])->name('kits.update');
            Route::delete('{id}', [KitsController::class, 'destroy'])->name('kits.destroy');

        });

        Route::prefix('/reserves')->group(function () {
            Route::get('/', [AdminReserveController::class, 'all']);
            Route::get('/pending', [AdminReserveController::class, 'pending']);
            Route::get('/delayed', [AdminReserveController::class, 'delayed']);
            Route::livewire('/{id}', [AdminReserveController::class, 'show'])->name('reserves.show');
            
        });
    });

    Route::prefix('reserve')->group(function(){
        Route::get('/', [ReserveController::class, 'index']);
        Route::post('/create', [ReserveController::class, 'create'])->name('reserve.create');
        Route::get('/info', [ReserveController::class, 'reserveInfo']);
        Route::post('/add-kit/{id}', [ReserveController::class, 'addKit'])->name('kit.add');
        Route::post('/remove-kit/{id}', [ReserveController::class, 'removeKit'])->name('kit.remove');
        Route::post('/reserve-cancel', [ReserveController::class, 'cancelReserve'])->name('reserve.cancel');
        Route::post('/reserve-confirm', [ReserveController::class, 'confirmReserve'])->name('reserve.confirm');
    });
});

Route::get('/kit/{id}', [UserKitsController::class, 'show']);
Route::get('/categoria/{id}', [UserKitsController::class, 'index']);

Route::get('teste', function () {
    return session()->all();
});