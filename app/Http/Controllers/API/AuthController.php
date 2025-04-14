<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use App\Services\AuthService;


class AuthController extends Controller
{
    public function __construct(public AuthService $authService) {}

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

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $user = User::findByEmail($request->email);
        $this->authService->sendEmailVerificationOtp($user);

        return $this->respondSuccess('OTP sent to your email.');
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = User::findByEmail($request->email);

        if (! $user || ! $this->authService->verifyPasswordResetOtp($user, $request->otp)) {
            return $this->respondValidationError('Invalid or expired OTP.');
        }

        $this->authService->resetPassword($user, $request->password);

        return $this->respondSuccess('Password reset successfully.');
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return $this->respondSuccess('Logged out successfully');
    }
}
