<?php

namespace App\Http\Requests\Auth;

use App\Services\JsonResponseService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email', maxString()],
            'otp'   => ['required', 'digits:'.config('auth.passwords.users.otp_length')],
            'password' => ['required', 'min:'.config('auth.passwords.users.password_length'), 'confirmed'],
        ];
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            JsonResponseService::validationErrorResponse($validator->errors()->first(), [
                'errors' => $validator->errors()->all()
            ])
        );
    }
}
