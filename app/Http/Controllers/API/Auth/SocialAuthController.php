<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SocialLoginRequest;
use App\Services\Auth\SocialAuthService;
use Illuminate\Http\Request;

class SocialAuthController extends Controller
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

    public function __construct(public SocialAuthService $socialAuthService) {}

    public function googleLogin(SocialLoginRequest $request)
    {
        try {
            $result = $this->socialAuthService->handleGoogleLogin($request->token);

            return $this->respondSuccess('Login successful.', [
                'user' => $result['user'],
                'token' => $result['token'],
            ]);
        } catch (\Exception $e) {
            return $this->respondError('Google login failed.', [
                'error' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
        }
    }
}
