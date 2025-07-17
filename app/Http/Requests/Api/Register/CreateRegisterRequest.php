<?php

namespace App\Http\Requests\Api\Register;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateRegisterRequest extends FormRequest
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
            'name'             => 'required|max:50',
            'email'            => 'required|email|unique:users,email',
            'mobile_number'    => 'required|integer|digits_between:7,15|regex:/^(\+?\d{1,3}[- ]?)?\d{10}$/|unique:users,mobile_number',
            'password'         => 'required|min:8|max:15|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'confirm_password' => 'required|same:password',
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
