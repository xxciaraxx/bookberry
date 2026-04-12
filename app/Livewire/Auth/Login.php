<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class Login extends Component
{
    public string $email       = '';
    public string $password    = '';
    public bool   $remember    = false;
    public bool   $showPassword = false;

    protected $rules = [
        'email'    => ['required', 'email'],
        'password' => ['required', 'string'],
    ];

    protected $messages = [
        'email.required'    => 'Please enter your email address.',
        'email.email'       => 'Please enter a valid email address.',
        'password.required' => 'Please enter your password.',
    ];

    public function login(): void
    {
        $this->validate();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            throw ValidationException::withMessages([
                'email' => 'These credentials do not match our records.',
            ]);
        }

        session()->regenerate();

        // Redirect admin to dashboard, customer to home
        if (Auth::user()->isAdmin()) {
            $this->redirect(route('admin.dashboard'), navigate: true);
        } else {
            $this->redirect(route('home'), navigate: true);
        }
    }

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('components.auth-layout', ['title' => 'Sign In — BookBerry']);
    }
}