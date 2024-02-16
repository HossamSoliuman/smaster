<?php

use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CategoryController as ControllersCategoryController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\SocialiteController;
use App\Jobs\CheckTokenExpiration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

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

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('logout', [AuthenticationController::class, 'logout']);
});

Route::get('categories', [CategoryController::class, 'index']);
Route::post('products', [CategoryController::class, 'products']);

Route::get('test/categories', [ControllersCategoryController::class, 'index']);
Route::get('test/products', [ControllersCategoryController::class, 'products']);

Route::get('refresh-token', function () {
    $checkToken = new CheckTokenExpiration();
    $checkToken->handle();
    return 'refreshed';
});
