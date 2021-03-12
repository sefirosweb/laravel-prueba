<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\TownController;

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

Route::get('/', [TownController::class, 'home'])->name('home');

Route::get('/town', [TownController::class, 'index']);
Route::get('/town/crud', [TownController::class, 'getAll']);
Route::post('/town/crud', [TownController::class, 'store']);
Route::put('/town/crud', [TownController::class, 'update']);
Route::delete('/town/crud', [TownController::class, 'destroy']);

Route::get('/province/{towns_id}', [ProvinceController::class, 'index']);
Route::get('/province/{towns_id}/crud', [ProvinceController::class, 'getAll']);
Route::post('/province/crud', [ProvinceController::class, 'store']);
Route::put('/province/crud', [ProvinceController::class, 'update']);
Route::delete('/province/crud', [ProvinceController::class, 'destroy']);
