<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class Register extends Component
{
    public string $name            = '';
    public string $email           = '';
    public string $password        = '';
    public string $password_confirmation = '';
    public bool   $showPassword    = false;
    public bool   $showConfirm     = false;
    public bool   $agreedToTerms   = false;

    // Live password strength indicators
    public bool $hasMinLength  = false;
    public bool $hasUppercase  = false;
    public bool $hasLowercase  = false;
    public bool $hasNumber     = false;
    public bool $hasSymbol     = false;

    public function updatedPassword(string $value): void
    {
        $this->hasMinLength = strlen($value) >= 8;
        $this->hasUppercase = (bool) preg_match('/[A-Z]/', $value);
        $this->hasLowercase = (bool) preg_match('/[a-z]/', $value);
        $this->hasNumber    = (bool) preg_match('/[0-9]/', $value);
        $this->hasSymbol    = (bool) preg_match('/[\W_]/', $value);
    }

    public function getPasswordStrengthProperty(): int
    {
        return (int) $this->hasMinLength
             + (int) $this->hasUppercase
             + (int) $this->hasLowercase
             + (int) $this->hasNumber
             + (int) $this->hasSymbol;
    }

    public function getStrengthLabelProperty(): string
    {
        return match (true) {
            $this->passwordStrength <= 1 => 'Very Weak',
            $this->passwordStrength == 2 => 'Weak',
            $this->passwordStrength == 3 => 'Fair',
            $this->passwordStrength == 4 => 'Strong',
            default                      => 'Very Strong',
        };
    }

    public function getStrengthColorProperty(): string
    {
        return match (true) {
            $this->passwordStrength <= 1 => '#EF4444',
            $this->passwordStrength == 2 => '#F97316',
            $this->passwordStrength == 3 => '#EAB308',
            $this->passwordStrength == 4 => '#22C55E',
            default                      => '#16A34A',
        };
    }

    protected function rules(): array
    {
        return [
            'name'  => ['required', 'string', 'min:2', 'max:100', 'regex:/^[a-zA-Z\s\.\-]+$/'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
            'agreedToTerms' => ['accepted'],
        ];
    }

    protected $messages = [
        'name.required'       => 'Please enter your full name.',
        'name.min'            => 'Name must be at least 2 characters.',
        'name.regex'          => 'Name may only contain letters, spaces, dots, and hyphens.',
        'email.required'      => 'Email address is required.',
        'email.email'         => 'Please enter a valid email address.',
        'email.unique'        => 'This email is already taken. Try logging in instead.',
        'password.required'   => 'Please create a password.',
        'password.confirmed'  => 'Passwords do not match.',
        'agreedToTerms.accepted' => 'You must agree to the Terms of Service.',
    ];

    public function register(): void
    {
        $validated = $this->validate();

        $user = User::create([
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => Hash::make($this->password),
            'is_admin' => false,
        ]);

        event(new Registered($user));
        Auth::login($user);

        $this->redirect(route('home'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register')
            ->layout('components.auth-layout', ['title' => 'Create Account — BookBerry']);
    }
}