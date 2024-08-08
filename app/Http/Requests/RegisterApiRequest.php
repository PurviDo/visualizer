<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class RegisterApiRequest extends FormRequest
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
            'first_name'    => 'required|max:100',
            'last_name'     => 'required|max:100',
            'phone_number'  => 'required|string|min:9|max:10|unique:users,mobile_no|nullable|regex:/[0-9]{9}/',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'min:8',
            // 'package_id'    => 'required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json(['error' => $validator->errors(), "message" => null, "status" => false, "data" => null], 422);
        throw new ValidationException($validator, $response);
    }
}
