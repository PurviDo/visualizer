<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ProfileUpdateApiRequest extends FormRequest
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
            'first_name'    => 'required|string|min:2',
            'last_name'     => 'required|string|min:2',
            'mobile_no'  => 'required|string|min:9|max:10|nullable|regex:/[0-9]{9}/',
            'email'         => [
                                'required',
                                'string',
                                'email',
                                'max:255',
                                Rule::unique('users')->ignore(Auth::id(),'_id')
                            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $error = $validator->errors()->toArray();
        $response = response()->json(['error' => $validator->errors(), "message" => current($error)[0], "status" => 422, "data" => null], 422);
        throw new ValidationException($validator, $response);
    }
}
