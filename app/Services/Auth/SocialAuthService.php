<?php

namespace App\Services\Auth;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SocialAuthService
{
    public function handleGoogleLogin(string $token)
    {
        $googleUser = Socialite::driver('google')->stateless()->userFromToken($token);

        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'email_verified_at' => now(),
                'provider' => 'google',
                'provider_id' => $googleUser->getId(),
            ]
        );

        $token = $user->createAuthToken();

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}
