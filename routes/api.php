<?php

use App\Http\Controllers\ApiCategoryController;
use App\Http\Controllers\ApiProductController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\NaviconController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShippingController;
use App\Http\Resources\UserResource;
use App\Jobs\CheckTokenExpiration;
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

Route::post('login', [AuthenticationController::class, 'login']);
Route::post('register', [AuthenticationController::class, 'register']);

Route::get('test', function () {
    $par = request()->input('par');
    return redirect($par);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function () {
        return UserResource::make(auth()->user());
    });
    Route::post('logout', [AuthenticationController::class, 'logout']);
    Route::post('product-checkout', [CheckoutController::class, 'checkout']);
});

Route::get('categories', [ApiCategoryController::class, 'index']);
Route::get('categories/{category}', [ApiCategoryController::class, 'show']);
Route::get('products', [ApiCategoryController::class, 'products']);
Route::get('products/{product}', [ApiProductController::class, 'show']);
Route::get('shipping-address/countries', [ShippingController::class, 'getCountries']);
Route::get('shipping-address/cities', [ShippingController::class, 'getCities']);

Route::get('banners', [BannerController::class, 'apiIndex']);
Route::get('nav-icons', [NaviconController::class, 'apiIndex']);



Route::get('/checkout-cancel', function () {
    return redirect('https://smaster.live');
})->name('checkout-cancel');

Route::get('/checkout-success', [CheckoutController::class, 'checkoutSuccess'])->name('checkout-success');


Route::get('refresh-token', function () {
    $checkToken = new CheckTokenExpiration();
    $checkToken->handle();
    return 'refreshed';
});
