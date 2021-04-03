<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\AuthorizationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Http\Resources\Auth\LoginResource;
use App\Http\Resources\Auth\LogoutResource;
use App\Http\Resources\Auth\RegistrationResource;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param AuthRequest $authRequest
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function login(AuthRequest $authRequest) : JsonResponse
    {
        return $this->response(
            'Авторизация пользователя',
            new LoginResource(['token' => $this->authService->login($authRequest)])
        );
    }

    /**
     * @param RegistrationRequest $registrationRequest
     * @return JsonResponse
     */
    public function registration(RegistrationRequest $registrationRequest) : JsonResponse
    {
        return $this->response(
            'Регистрация пользователя',
            new RegistrationResource(['token' => $this->authService->registration($registrationRequest)])
        );
    }

    /**
     * @return JsonResponse
     */
    public function logout() : JsonResponse
    {
        return $this->response(
            'Выход пользователя из приложения',
            new LogoutResource(['success' => $this->authService->logout()])
        );
    }
}
