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

    //Banners
    Route::get('banners', [App\Http\Controllers\Web\Banners\IndexController::class, 'index'])->name('admin.banners');
    Route::get('banner', [App\Http\Controllers\Web\Banners\IndexController::class, 'create'])->name('admin.banner.add');
    Route::post('banner', [App\Http\Controllers\Web\Banners\IndexController::class, 'store'])->name('admin.banner.store');
    Route::get('banner/edit/{id}', [App\Http\Controllers\Web\Banners\IndexController::class, 'edit'])->name('admin.banner.edit');
    Route::post('banner/update/{id}', [App\Http\Controllers\Web\Banners\IndexController::class, 'update'])->name('admin.banner.update');
    Route::get('/changeBannerStatus', [App\Http\Controllers\Web\Banners\IndexController::class, 'changeBannerStatus']);
    

    //Stores
    Route::get('stores', [IndexController::class, 'index'])->name('admin.stores');
    Route::get('store/view/{id}', [IndexController::class, 'view'])->name('store.view');
    Route::get('store/edit/{id}', [IndexController::class, 'edit'])->name('store.edit');
    Route::post('store/update/{id}', [IndexController::class, 'update'])->name('store.update');
    Route::get('/changeStatus', [IndexController::class, 'changeStatus']);
    Route::get('/isFeatured', [IndexController::class, 'isFeatured']);
    
    //Products
    Route::get('products', [App\Http\Controllers\Web\Products\IndexController::class, 'index'])->name('admin.products');

    Route::get('product/view/{id}', [App\Http\Controllers\Web\Products\IndexController::class, 'view'])->name('product.view');
    Route::get('/changeProductStatus', [App\Http\Controllers\Web\Products\IndexController::class, 'change_product_status']);

    //Categories
    Route::get('categories', [App\Http\Controllers\Web\Categories\IndexController::class, 'index'])->name('admin.categories');
    Route::get('category', [App\Http\Controllers\Web\Categories\IndexController::class, 'create'])->name('admin.category.add');
    Route::post('category', [App\Http\Controllers\Web\Categories\IndexController::class, 'store'])->name('admin.category.store');
    Route::get('category/edit/{id}', [App\Http\Controllers\Web\Categories\IndexController::class, 'edit'])->name('admin.category.edit');
    Route::post('category/update/{id}', [App\Http\Controllers\Web\Categories\IndexController::class, 'update'])->name('admin.category.update');
    Route::delete('/category/{id}', [App\Http\Controllers\Web\Categories\IndexController::class, 'destroy'])->name('admin.category.destroy');
    Route::get('/changeCategoryStatus', [App\Http\Controllers\Web\Categories\IndexController::class, 'changeCategoryStatus']);

    //Customers
    Route::get('customers', [App\Http\Controllers\Web\Customers\IndexController::class, 'index'])->name('admin.customers');
    Route::get('customer/edit/{id}', [App\Http\Controllers\Web\Customers\IndexController::class, 'edit'])->name('admin.customer.edit');
    Route::post('customer/update/{id}', [App\Http\Controllers\Web\Customers\IndexController::class, 'update'])->name('admin.customer.update');

    //Vendors
    Route::get('vendors', [App\Http\Controllers\Web\Vendors\IndexController::class, 'index'])->name('admin.vendors');
    Route::get('vendor/edit/{id}', [App\Http\Controllers\Web\Vendors\IndexController::class, 'edit'])->name('admin.vendor.edit');
    Route::post('vendor/update/{id}', [App\Http\Controllers\Web\Vendors\IndexController::class, 'update'])->name('admin.vendor.update');
});


