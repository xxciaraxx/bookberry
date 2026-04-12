<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:100',
                'regex:/^[a-zA-Z\s\.\-]+$/',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'Your full name is required.',
            'name.min'       => 'Name must be at least 2 characters.',
            'name.regex'     => 'Name may only contain letters, spaces, dots and hyphens.',
            'email.required' => 'An email address is required.',
            'email.email'    => 'Please enter a valid email address.',
            'email.unique'   => 'This email is already registered. Try logging in.',
            'password.required'  => 'A password is required.',
            'password.confirmed' => 'Passwords do not match.',
        ];
    }
}