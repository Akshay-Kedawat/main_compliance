<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateUserRequest extends FormRequest
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
            'name'             => 'required|max:255',
            'email'            => 'required|email|unique:users,email',
            'mobile_number'    => 'required|integer|digits_between:7,15|regex:/^(\+?\d{1,3}[- ]?)?\d{10}$/|unique:users,mobile_number',
            'password'         => 'required|min:8|max:15|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'confirm_password' => 'required|same:password',
            'profile_picture'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'role_name'        => 'required|exists:roles,name',
        ];
    }
    public function messages()
    {
        return [
            'password.regex'   => trans('message.valid_password', ['attribute' => 'password']),
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status'  => false,
            'message' => $validator->errors()->first(),
            'data'    => (object)[]
        ]));
    }
}
