<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LangController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Web\Stores\IndexController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
/**
 * Custom Login Register
 */
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 
Route::get('logout', [AuthController::class, 'logout'])->name('custom.logout');


Route::get('reset-password/{token}', [RegisterController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [RegisterController::class, 'submitResetPasswordForm'])->name('reset.password.post');
// Auth::routes();

/**
 * Change Language Routes
 */
Route::get('lang', [LangController::class, 'index']);
Route::get('lang/change', [LangController::class, 'change'])->name('changeLang');

/*All Admin Routes List*/

Route::middleware(['auth', 'user-access:1'])->group(function () { 
    Route::get('admin', [HomeController::class, 'index'])->name('home');
    //Stores
    Route::get('stores', [IndexController::class, 'index'])->name('stores');
    Route::get('store/edit/{id}', [IndexController::class, 'edit'])->name('store.edit');
    Route::post('store/update/{id}', [IndexController::class, 'update'])->name('store.update');

    Route::get('products', [App\Http\Controllers\Web\Products\IndexController::class, 'index'])->name('products');

});
