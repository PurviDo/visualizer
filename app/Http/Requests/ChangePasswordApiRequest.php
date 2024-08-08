<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ChangePasswordApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'current_password'      => 'min:8|required',
            'password'              => 'min:8|required|confirmed',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $error = $validator->errors()->toArray();
        $response = response()->json(['error' => $validator->errors(), "message" => current($error)[0], "status" => 422, "data" => null], 422);
        throw new ValidationException($validator, $response);
    }
}
