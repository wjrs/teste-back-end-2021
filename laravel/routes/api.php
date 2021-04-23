<?php

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

Route::prefix('auth/')->middleware('api')->group(function() {

    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::get('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('refresh', [\App\Http\Controllers\AuthController::class, 'refresh']);
    Route::get('me', [\App\Http\Controllers\AuthController::class, 'me']);

});

Route::middleware('auth:api')->group(function() {

    Route::resource('products', '\App\Http\Controllers\ProductController');

});
