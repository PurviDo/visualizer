<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SocialLoginRequest;
use App\Models\LinkedSocialAccount;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as ProviderUser;

class SocialLoginController extends Controller
{
    public function login(SocialLoginRequest $request)
    {
        try {
            $accessToken = $request->get('access_token');
            $provider = $request->get('provider');
            $providerUser = Socialite::driver($provider)->userFromToken($accessToken);
        } catch (Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ]);
        }

        if (filled($providerUser)) {
            $user = $this->findOrCreate($providerUser, $provider);
        } else {
            $user = $providerUser;
        }
        
        auth()->login($user);

        if (auth()->check()) {
            $token = Helper::createToken();
            $user->access_token = $token;
            $user->save();

            $user = User::find(auth()->user()->id);

            return response()->json([
                "message"=> "User Logged In successfully.",
                "status" => 1,
                'data' => $user,
            ]);
        } else {
            return $this->error(
                message: 'Failed to Login try again',
                code: 401
            );
        }
    }

    protected function findOrCreate(ProviderUser $providerUser, string $provider): User
    {
        $linkedSocialAccount = LinkedSocialAccount::query()->where('provider_name', $provider)
            ->where('provider_id', $providerUser->getId())
            ->first();

        if ($linkedSocialAccount) {
            return $linkedSocialAccount->user;
        } else {
            $user = null;

            if ($email = $providerUser->getEmail()) {
                $user = User::where('email', $email)->first();
            }

            if (!$user) {
                $nameParts = $this->splitName($providerUser->getName());
                $firstName = $nameParts['first_name'];
                $lastName = $nameParts['last_name'];

                $userId = DB::connection('mongodb')->collection('users')->insertGetId([
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $providerUser->getEmail(),
                    'is_active' => 1,
                    'user_type' => 0,
                ]);
                
                // Retrieve the user model after insertion
                $user = User::find($userId);
                
                if ($user) {
                    $user->markEmailAsVerified();
                }
            }

            $user->linkedSocialAccounts()->create([
                'provider_id' => $providerUser->getId(),
                'provider_name' => $provider,
            ]);

            return $user;
        }
    }

    protected function splitName($fullName)
    {
        $nameParts = explode(' ', $fullName, 2);
        $firstName = $nameParts[0];
        $lastName = isset($nameParts[1]) ? $nameParts[1] : '';

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
        ];
    }

    protected function error(string $message, int $code)
    {
        return response()->json([
            'message' => $message
        ], $code);
    }
}
