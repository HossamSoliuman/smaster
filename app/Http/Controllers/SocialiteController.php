<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
// use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Redirect the user to the provider authentication page.
     *
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse
     */


    public function redirectToProvider(string $provider)
    {
        // Get the authentication URL for the specified provider
        $authUrl = Socialite::driver($provider)->redirect()->getTargetUrl();

        // Return the authentication URL to the frontend
        return response()->json(['authUrl' => $authUrl]);
    }

    /**
     * Obtain the user information from provider.
     *
     * @param string $provider
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleProviderCallback(string $provider)
    {
        $socialite_user = Socialite::driver($provider)->user();

        $user = User::where('email', $socialite_user->getEmail())->first();

        if (!$user) {
            $user = User::where('socialite->' . $provider . '->id', $socialite_user->getId())->first();

            if (!$user) {
                $initial_password = Hash::make(Str::random(16));
                $user = User::create([
                    'name' => $socialite_user->getName(),
                    'email' => $socialite_user->getEmail(),
                    'password' => $initial_password,
                    'socialite' => json_encode([
                        $provider => [
                            'id' => $socialite_user->getId(),
                        ],
                    ]),
                ]);

                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'token' => $token,
                    'user' => UserResource::make($user),
                    'initial_password' => $initial_password,
                ]);
            } else {
                // User exists with socialite provider ID, but not with email
                $user->email = $socialite_user->getEmail();
                $user->save();
            }
        } else {
            // User exists with email, check if socialite provider ID exists
            $socialite = json_decode($user->socialite, true);

            if (!isset($socialite[$provider])) {
                $socialite[$provider] = ['id' => $socialite_user->getId()];
                $user->socialite = json_encode($socialite);
                $user->save();
            }
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => UserResource::make($user),
        ]);
    }
}
