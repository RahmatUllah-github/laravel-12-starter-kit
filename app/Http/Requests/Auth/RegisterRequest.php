<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Traits\RespondsWithJson;

class RegisterRequest extends FormRequest
{
    use RespondsWithJson;
    
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
            'name'     => ['required', 'string', maxString()],
            'email'    => ['required', 'email', 'unique:users,email', maxString()],
            'password' => ['required', 'min:'.config('auth.passwords.users.password_length'), 'confirmed'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            // Add custom messages as needed
        ];
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->respondValidationError($validator->errors()->first(), [
                'errors' => $validator->errors()->all()
            ])
        );
    }
}
