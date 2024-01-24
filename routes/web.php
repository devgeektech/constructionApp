<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LangController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Web\Auth\AuthController;
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
Route::get('dashboard', [AuthController::class, 'dashboard']); 
Route::get('logout', [AuthController::class, 'logout'])->name('logout');


Route::get('lang', [LangController::class, 'index']);
Route::get('lang/change', [LangController::class, 'change'])->name('changeLang');


Route::get('/login/{provider}', [RegisterController::class,'redirectToProvider']);
Route::get('/login/{provider}/callback', [RegisterController::class,'handleProviderCallback']);


Route::get('reset-password/{token}', [RegisterController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [RegisterController::class, 'submitResetPasswordForm'])->name('reset.password.post');
Auth::routes();

/*All Normal Users Routes List*/
Route::middleware(['auth', 'user-access:3'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});
  
/*All Admin Routes List*/
Route::middleware(['auth', 'user-access:1'])->group(function () {
  
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
});
  
/*All Vendor Routes List*/
Route::middleware(['auth', 'user-access:2'])->group(function () {
  
    Route::get('/manager/home', [HomeController::class, 'vendorHome'])->name('vendor.home');
});
