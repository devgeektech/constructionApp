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
    Route::post('forget-password','submitForget'); 
    Route::post('social-login','social_login'); 
});



Route::middleware('auth.sanctum')->group( function () {

    //home api
    Route::get('home', [App\Http\Controllers\Api\HomeController::class,'index']);  
    /**
     * Product Routes
     */
    Route::resource('products', 'App\Http\Controllers\Api\Product\IndexController');
    Route::post('search-products', [App\Http\Controllers\Api\Product\IndexController::class,'search_and_filter_products']);
    /**
     * Categories Routes
     */
    Route::get('categories', [App\Http\Controllers\Api\Category\IndexController::class,'index']);

    /**
     * Store Routes
     */
    Route::post('store', [App\Http\Controllers\Api\Store\IndexController::class,'store']);
    Route::get('store', [App\Http\Controllers\Api\Store\IndexController::class,'index']);
    Route::get('store/{id}', [App\Http\Controllers\Api\Store\IndexController::class,'show']);

    /**
     * Banner Routes
     */
    Route::get('banners', [App\Http\Controllers\Api\Banner\IndexController::class,'index']);
    Route::post('store-banner', [App\Http\Controllers\Api\Banner\IndexController::class,'store']);

    /**
     * Profile
     */
    Route::post('update-profile',[App\Http\Controllers\Api\RegisterController::class,'update_profile']); 
    Route::get('get-profile',[App\Http\Controllers\Api\RegisterController::class,'get_profile']); 

    /**
     * Wishlist
     */
    Route::get('wishlist',[App\Http\Controllers\Api\Wishlist\IndexController::class,'index']);
    Route::post('wishlist',[App\Http\Controllers\Api\Wishlist\IndexController::class,'store']);
});

