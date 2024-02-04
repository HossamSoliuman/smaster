<?php

use App\Http\Controllers\MatchController;
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
//cj auth email key access_token access_token_expiry_date refresh_token
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('test', function (Request $request) {
    $response = Http::post('https://developers.cjdropshipping.com/api2.0/v1/authentication/getAccessToken', [
        'email' => $request->email,
        'password' => 'd322d52c442a4b37840072a265c7ea12',
    ]);
    if ($response->successful()) {
        return $response;
    } else {
        return $response;
    }
});
