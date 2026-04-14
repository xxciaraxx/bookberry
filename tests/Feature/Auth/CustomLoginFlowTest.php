<?php

namespace Tests\Feature\Auth;

use App\Livewire\Auth\Login;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CustomLoginFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_customers_are_redirected_to_home_after_login(): void
    {
        $user = User::factory()->create([
            'is_admin' => false,
        ]);

        Livewire::test(Login::class)
            ->set('email', $user->email)
            ->set('password', 'password')
            ->call('login')
            ->assertHasNoErrors()
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);
    }
}
