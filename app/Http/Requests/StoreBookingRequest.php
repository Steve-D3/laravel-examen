<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    /**
     * Determine if the user is authorized to make this request.
     */
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // No additional authorization needed as we handle token validation in rules
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'trip_id' => ['required', 'integer', 'exists:trips,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'], // Removed strict RFC and DNS validation
            'number_of_people' => ['required', 'integer', 'min:1'],
            'token' => ['required', 'string', 'size:32', function ($attribute, $value, $fail) {
                // Custom validation rule for token
                if (!$this->has('email')) {
                    return; // Email validation will handle this case
                }
                
                $expectedToken = md5($this->input('email') . 'canadarocks');
                if ($value !== $expectedToken) {
                    $fail('The token is invalid.');
                }
            }],
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        
        // Check for missing token specifically to return 401
        if ($errors->has('token') && $this->input('token') === null) {
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Authentication token is required.',
                    'errors' => ['token' => ['The token field is required.']]
                ], 401)
            );
        }
        
        // Check for invalid token specifically to return 403
        if ($errors->has('token') && $this->input('token') !== null) {
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Invalid authentication token.',
                    'errors' => ['token' => ['The provided token is invalid.']]
                ], 403)
            );
        }
        
        // For all other validation errors, return 422
        throw new HttpResponseException(
            response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $errors->toArray()
            ], 422)
        );
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'trip_id.exists' => 'The selected trip does not exist.',
            'token.invalid' => 'The provided token is invalid.',
        ];
    }
}
