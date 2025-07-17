<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
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
            'user_id'          => 'required|integer|exists:users,id',
            'name'             => 'required|max:255',
            'email'            => 'required|email|unique:users,email,'.$this->user_id,
            'mobile_number'    => 'required|integer|digits_between:7,15|regex:/^(\+?\d{1,3}[- ]?)?\d{10}$/|unique:users,mobile_number,'.$this->user_id,
            'profile_picture'  => 'nullable|max:2048|image|mimes:jpeg,png,jpg',
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
