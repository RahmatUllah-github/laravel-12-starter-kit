<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

class JsonResponseService
{
    /**
     * Generate a JSON response with a success status.
     */
    public static function successResponse(string $message, $data = null, array $meta = []): JsonResponse
    {
        return self::jsonResponse($message, $data, 200, 'success', $meta);
    }

    /**
     * Generate a JSON response for validation errors.
     */
    public static function validationErrorResponse(string $message, $data = null, array $meta = []): JsonResponse
    {
        return self::jsonResponse($message, $data, 422, 'failed', $meta);
    }

    /**
     * Generate a JSON response for unauthorized access.
     */
    public static function unauthorizedErrorResponse(string $message, $data = null, array $meta = []): JsonResponse
    {
        return self::jsonResponse($message, $data, 401, 'failed', $meta);
    }

    /**
     * Generate a JSON response for forbidden access.
     */
    public static function forbiddenErrorResponse(string $message, $data = null, array $meta = []): JsonResponse
    {
        return self::jsonResponse($message, $data, 403, 'failed', $meta);
    }

    /**
     * Generate a JSON response for internal server errors.
     */
    public static function errorResponse(string $message, $data = null, array $meta = []): JsonResponse
    {
        return self::jsonResponse($message, $data, 500, 'failed', $meta);
    }

    /**
     * Generate a JSON response for not found errors.
     */
    public static function notFoundErrorResponse(string $message, $data = null, array $meta = []): JsonResponse
    {
        return self::jsonResponse($message, $data, 404, 'failed', $meta);
    }

    /**
     * Generate a custom JSON response with any status code and message.
     */
    public static function custom(int $code, string $message, $data = null, string $status = 'success', array $meta = []): JsonResponse
    {
        return self::jsonResponse($message, $data, $code, $status, $meta);
    }

    /**
     * Helper function to generate a JSON response.
     */
    private static function jsonResponse(string $message, $data, int $code, string $status, array $meta = []): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'data' => $data,
            'meta' => $meta,
        ], $code);
    }
}
