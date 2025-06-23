<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->routeIs('admin.blogs.update')) {
            return [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ];
        }

        $id = $this->route('id');
        if ($this->routeIs('admin.users.update')) {
            return [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'user_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ];
        }
    }
}
