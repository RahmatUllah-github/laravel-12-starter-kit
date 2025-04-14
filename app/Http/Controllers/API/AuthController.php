<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use App\Traits\RespondsWithJson;

class AuthController extends Controller
{
    use RespondsWithJson;

    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $data = $this->authService->register($request->validated());

        return $this->respondSuccess('Registration successful', $data);
    }

    public function login(LoginRequest $request)
    {
        $data = $this->authService->login($request->validated());

        if (! $data) {
            return $this->respondUnauthorized('Invalid credentials');
        }

        return $this->respondSuccess('Login successful', $data);
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return $this->respondSuccess('Logged out successfully');
    }
}
