<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ResetPasswordApiRequest extends FormRequest
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
            'user_id'               => 'required|numeric',
            'new_password'          => 'min:8|required_with:new_password_confirm|same:new_password_confirm',
            'new_password_confirm'  => 'min:8|required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json(['error' => $validator->errors(), "message" => null, "status" => false, "data" => null], 422);
        throw new ValidationException($validator, $response);
    }
}
