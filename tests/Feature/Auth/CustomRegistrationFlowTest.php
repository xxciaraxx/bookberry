<?php

namespace Tests\Feature\Auth;

use App\Livewire\Auth\Register;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CustomRegistrationFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_users_are_redirected_to_login(): void
    {
        Livewire::test(Register::class)
            ->set('name', 'Test User')
            ->set('email', 'test@example.com')
            ->set('password', 'Password123!')
            ->set('password_confirmation', 'Password123!')
            ->set('agreedToTerms', true)
            ->call('register')
            ->assertHasNoErrors()
            ->assertRedirect(route('login', absolute: false));

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);

        $this->assertGuest();
    }
}
