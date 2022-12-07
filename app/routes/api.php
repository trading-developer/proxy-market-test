<?php

use App\Http\Controllers\ProxyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::apiResource('proxies', ProxyController::class);
    Route::post('proxies/list', [ProxyController::class, 'index'])->name('proxies.list');
    Route::post('proxies/export', [ProxyController::class, 'export'])->name('proxies.export');
});

Route::post('login', [AuthController::class, 'login']);
Route::post('signup', [AuthController::class, 'signup']);
