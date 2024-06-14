<?php

use App\Http\Controllers\api\CategoryController as ApiCategoryController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CjAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\NaviconController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\SocialiteController;
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

Auth::routes([
    'register' => false
]);

Route::get('api/auth/{provider}', [SocialiteController::class, 'redirectToProvider']);
Route::get('auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback']);

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/', [HomeController::class, 'index'])->name('index');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('index', IndexController::class)->name('admin.index');
    Route::get('/orders/{order}/export', [OrderController::class, 'export'])->name('orders.export');
    Route::resource('cj-auths', CjAuthController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('product', ProductController::class);
    Route::resource('product-images', ProductImageController::class)->only(['store', 'destroy']);
    Route::resource('nav-icons', NaviconController::class);
});
