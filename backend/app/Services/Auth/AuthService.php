<?php

namespace App\Services\Auth;

use App\Exceptions\AuthorizationException;
use App\Http\Requests\Auth\AuthRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Models\User;
use Illuminate\Support\Str;

class AuthService
{
    /**
     * @param AuthRequest $authRequest
     * @return string
     * @throws AuthorizationException
     */
    public function login(AuthRequest $authRequest): string
    {
        if(!auth()->attempt(['email' => $authRequest->get('email'), 'password' => $authRequest->get('password')])) {
            throw new AuthorizationException();
        }
        /**
         * @var $user User
         */
        $user = auth()->user();
        return $user->createToken($user->id)->accessToken;
    }

    /**
     * @param RegistrationRequest $registrationRequest
     * @return string
     */
    public function registration(RegistrationRequest $registrationRequest): string
    {
        $user = new User();

        $user->email = $registrationRequest->get('email');
        $user->password = bcrypt($registrationRequest->get('password'));
        $user->email_verified_at = now();
        $user->remember_token = Str::random(10);
        $user->save();

        return $user->createToken($user->id)->accessToken;
    }

    /**
     * @return bool
     */
    public function logout(): bool
    {
        /**
         * @var $user User
         */
        $user = auth()->user();

        $token = $user->token();
        return $token->revoke();
    }
}
