<?php

namespace Tests\Feature;

use App\Livewire\CheckoutComponent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CheckoutPaymentSelectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_one_payment_method_is_selected_at_a_time(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Livewire::test(CheckoutComponent::class)
            ->assertSet('payment_method', 'cod')
            ->call('selectPaymentMethod', 'gcash')
            ->assertSet('payment_method', 'gcash')
            ->call('selectPaymentMethod', 'bank')
            ->assertSet('payment_method', 'bank')
            ->call('selectPaymentMethod', 'cod')
            ->assertSet('payment_method', 'cod');
    }
}
