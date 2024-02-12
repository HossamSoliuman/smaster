<?php

use App\Http\Controllers\CjAuthController;
use App\Http\Controllers\ExtractionController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\TableController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Finder\Iterator\FilecontentFilterIterator;

use App\Models\CjAuth;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
// Route::get('t', function () {
//     $user = User::create([
//         'name' => 'Admin',
//         'email' => 'admin@gmail.com',
//         'email_verified_at' => now(),
//         'password' => Hash::make('password'),
//         'role' => 'admin',
//         'remember_token' => 'jklj;joijklnkn',
//     ]);
//     return $user;
// });

Route::get('api/auth/{provider}', [SocialiteController::class, 'redirectToProvider']);
Route::get('auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback']);
Route::view('tm', 'tm');
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/', [HomeController::class, 'index'])->name('index');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('cj-auths', CjAuthController::class);
});

Route::get('te', function () {
    $tokenInfo = CjAuth::first();

    if ($tokenInfo) {
        $currentDateTime = Carbon::now();
        $refreshTokenExpiryDate = Carbon::parse($tokenInfo->refresh_token_expiry_date);

        if ($currentDateTime->gte($refreshTokenExpiryDate) || !$tokenInfo->refresh_token_expiry_date) {
            $response = Http::post('https://developers.cjdropshipping.com/api2.0/v1/authentication/getAccessToken', [
                'email' => $tokenInfo->email,
                'password' => $tokenInfo->key,
            ]);

            if ($response->successful()) {
                $responseData = $response->json()['data'] ?? null;
                if ($responseData) {
                    $accessToken = data_get($responseData, 'accessToken');
                    $accessTokenExpiryDate = Carbon::parse(data_get($responseData, 'accessTokenExpiryDate'))->format('Y-m-d H:i:s');
                    $refreshToken = data_get($responseData, 'refreshToken');
                    $refreshTokenExpiryDate = Carbon::parse(data_get($responseData, 'refreshTokenExpiryDate'))->format('Y-m-d H:i:s');

                    $tokenInfo->update([
                        'access_token' => $accessToken,
                        'access_token_expiry_date' => $accessTokenExpiryDate,
                        'refresh_token' => $refreshToken,
                        'refresh_token_expiry_date' => $refreshTokenExpiryDate
                    ]);
                    Log::info('Access token refreshed successfully.');
                } else {
                    Log::error('Failed to refresh access token: Missing required properties in response.');
                }
            } else {

                Log::error('Failed to refresh access token: ' . $response->status());
            }
        } else {
            $expiryDate = Carbon::parse($tokenInfo->access_token_expiry_date);
            $threeDaysBeforeExpiry = Carbon::now()->addDays(3);
            if ($threeDaysBeforeExpiry->gte($expiryDate)) {
                $response = Http::post('https://developers.cjdropshipping.com/api2.0/v1/authentication/refreshAccessToken', [
                    'refreshToken' => $tokenInfo->refresh_token,
                ]);

                if ($response->successful()) {
                    $responseData = $response->json()['data'] ?? null;
                    if ($responseData) {
                        $accessToken = data_get($responseData, 'accessToken');
                        $accessTokenExpiryDate = Carbon::parse(data_get($responseData, 'accessTokenExpiryDate'))->format('Y-m-d H:i:s');
                        $refreshToken = data_get($responseData, 'refreshToken');
                        $refreshTokenExpiryDate = Carbon::parse(data_get($responseData, 'refreshTokenExpiryDate'))->format('Y-m-d H:i:s');

                        $tokenInfo->update([
                            'access_token' => $accessToken,
                            'access_token_expiry_date' => $accessTokenExpiryDate,
                            'refresh_token' => $refreshToken,
                            'refresh_token_expiry_date' => $refreshTokenExpiryDate
                        ]);
                        Log::info('Access token refreshed successfully.');
                    } else {
                        Log::error('Failed to refresh access token: Missing required properties in response.');
                    }
                } else {
                    return now();
                    Log::error('Failed to refresh access token: ' . $response->status());
                }
            } else {
                return 'three'; ///three
                Log::info('Access token does not need to be refreshed yet.');
            }
        }
    }
});
