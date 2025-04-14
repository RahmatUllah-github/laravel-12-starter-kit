<?php

namespace App\Traits;

use App\Services\JsonResponseService;

trait RespondsWithJson
{
    protected function respondSuccess(string $message = 'Success', $data = null)
    {
        return JsonResponseService::successResponse($message, $data);
    }

    protected function respondValidationError(string $message = 'Validation Error', $data = null)
    {
        return JsonResponseService::validationErrorResponse($message, $data);
    }

    protected function respondUnauthorized(string $message = 'Unauthorized', $data = null)
    {
        return JsonResponseService::unauthorizedErrorResponse($message, $data);
    }

    protected function respondForbidden(string $message = 'Forbidden', $data = null)
    {
        return JsonResponseService::forbiddenErrorResponse($message, $data);
    }

    protected function respondNotFound(string $message = 'Not Found', $data = null)
    {
        return JsonResponseService::notFoundErrorResponse($message, $data);
    }

    protected function respondError(string $message = 'Something went wrong', $data = null)
    {
        return JsonResponseService::errorResponse($message, $data);
    }
}
