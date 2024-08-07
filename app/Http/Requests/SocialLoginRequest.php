<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class SocialLoginRequest extends FormRequest
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
    public function rules()
    {
        return [
            'access_token' => 'required|string',
            'provider' => 'required|string|in:google,facebook', // List all your supported providers here
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $error = $validator->errors()->toArray();
        $response = response()->json(['error' => $validator->errors(), "message" => current($error)[0], "status" => 422, "data" => null], 422);
        throw new ValidationException($validator, $response);
    }
}
