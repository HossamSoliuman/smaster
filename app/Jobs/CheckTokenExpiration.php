<?php

namespace App\Jobs;

use App\Models\CjAuth;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckTokenExpiration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
    }
    public function handle()
    {
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
    }
}
