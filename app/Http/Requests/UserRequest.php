<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;


class UserRequest extends FormRequest
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
    public function rules(): array
    {
        $id = $this->request->get('id');
        if (empty($id)) {
            return [
                'first_name' => 'required|max:25|regex:/^[a-zA-Z ]*$/|string',
                'last_name' => 'required|max:25|regex:/^[a-zA-Z ]*$/|string',
                'email' => ['required', 'string', 'email', Rule::unique('users')->whereNull('deleted_at')],
                'phone_number' => ['required', 'min:10', 'max:10', Rule::unique('users')->whereNull('deleted_at')],
                'password' => ['required', 'string', 'min:6', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'],
                'role' => 'required'
            ];
        } else {
            return [
                'id' => 'required',
                'first_name' => 'required|max:25|regex:/^[a-zA-Z ]*$/|string',
                'last_name' => 'required|max:25|regex:/^[a-zA-Z ]*$/|string',
                'email' => [
                    'required', 'string', 'email', 'max:255',
                    Rule::unique('users')->ignore($id)->whereNull('deleted_at')
                ],
                'phone_number' => ['required', 'min:10', 'max:10', Rule::unique('users')->ignore($id)->whereNull('deleted_at')],
                'role' => 'required'

            ];
        }
    }

    public function messages()
    {
        $messages = array(
            'name.required' => trans(
                'validation.custom.common_required',
                ["attribute" => "Name"]
            ),
            'name.max' => trans(
                'validation.custom.max_25_validation',
                ["attribute" => "Name"]
            ),
            'email.required' => trans(
                'validation.custom.email_required',
                ["attribute" => "Email"]
            ),
            'email.exists' => trans(
                'validation.custom.common_exists',
                ["attribute" => "Email"]
            ),
            'password.min' => trans(
                'validation.custom.min_6_validation',
                ["attribute" => "password"]
            ),
        );

        return $messages;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'errors' => $validator->errors()->all()[0],
                'status' => false
            ], 422)
        );
    }
}
