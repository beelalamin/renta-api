<?php

namespace App\Http\Controllers\api\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\JsonResponse;


class OAuthController extends Controller
{
    /**
     * Validate the provider name.
     *
     * @param string $provider
     * @return JsonResponse|null
     */
    protected function validateProvider(string $provider): ?JsonResponse
    {
        if (!in_array($provider, ['github', 'google'])) {
            return response()->json(['error' => 'Please login using GitHub or Google.'], 422);
        }

        return null;
    }

    /**
     * Redirect to the provider's OAuth page.
     *
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse|JsonResponse
     */
    public function redirectToProvider(string $provider)
    {
        if ($validationResponse = $this->validateProvider($provider)) {
            return $validationResponse;
        }

        return Socialite::driver($provider)->stateless()->redirect();
    }

    /**
     * Handle the OAuth provider callback.
     *
     * @param string $provider
     * @return JsonResponse
     */
    public function handleProviderCallback(string $provider): JsonResponse
    {
        if ($validationResponse = $this->validateProvider($provider)) {
            return $validationResponse;
        }

        try {
            $socialiteUser = Socialite::driver($provider)->stateless()->user();
        } catch (ClientException $exception) {
            return response()->json(['error' => 'Invalid credentials provided.'], 422);
        }

        $user = User::firstOrCreate(
            ['email' => $socialiteUser->getEmail()],
            [
                'name' => $socialiteUser->getName(),
                'email_verified_at' => now(),
                'status' => true,
            ]
        );

        $user->providers()->updateOrCreate(
            [
                'provider' => $provider,
                'provider_id' => $socialiteUser->getId(),
            ],
            ['avatar' => $socialiteUser->getAvatar()]
        );

        $token = $user->createToken('authToken', ['*'], now()->addWeek())->plainTextToken;
        
        return response()->json(['user' => $user, 'token' => $token], 200);
    }
}

