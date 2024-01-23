<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});
        
Route::middleware('auth:sanctum')->group( function () {
    /**
     * Product Routes
     */
    Route::resource('products', 'App\Http\Controllers\Api\Product\IndexController');
    /**
     * Categories Routes
     */
    Route::get('categories', [App\Http\Controllers\Api\Category\IndexController::class,'index']);

    /**
     * Store Routes
     */
    Route::post('store', [App\Http\Controllers\Api\Store\IndexController::class,'store']);
    Route::get('store', [App\Http\Controllers\Api\Store\IndexController::class,'index']);
});
