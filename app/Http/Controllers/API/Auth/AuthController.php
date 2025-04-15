<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use App\Services\Auth\AuthService;

class AuthController extends Controller
{
    /**
     * Available JSON response methods from RespondsWithJson trait:
     * 
     * @method respondSuccess(string $message = 'Success', mixed $data = null)
     *   - Returns 200 success response with optional data
     * 
     * @method respondValidationError(string $message = 'Validation Error', mixed $data = null)
     *   - Returns 422 validation error response
     * 
     * @method respondUnauthorized(string $message = 'Unauthorized', mixed $data = null)
     *   - Returns 401 unauthorized error response
     * 
     * @method respondForbidden(string $message = 'Forbidden', mixed $data = null)
     *   - Returns 403 forbidden error response
     * 
     * @method respondNotFound(string $message = 'Not Found', mixed $data = null)
     *   - Returns 404 not found error response
     * 
     * @method respondError(string $message = 'Something went wrong', mixed $data = null)
     *   - Returns 500 generic error response
     */

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
