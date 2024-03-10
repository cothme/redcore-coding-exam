<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'role_id' => 'required',
            'full_name' => 'required|string|regex:/^[a-zA-Z\s]*$/',
            'email' => 'required|email|max:191|unique:users',
            'password' => 'required|string|min:8|max:20|confirmed',
            'password_confirmation' => ['required','same:password'],
        ];
    }
}
