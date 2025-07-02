<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'user_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'confirmed_password' => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'Email Id Already Exists!',
        ];
    }
}
