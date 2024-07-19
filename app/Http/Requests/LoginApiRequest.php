<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;


class LoginApiRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'email'      =>  'required|email',
            'password'   =>  'required|min:8',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json(['error' => $validator->errors(), "message" => null, "status" => false, "data" => null], 422);
        throw new ValidationException($validator, $response);
    }
}
