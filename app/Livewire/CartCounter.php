<?php

namespace App\Livewire;

use App\Models\Cart;
use Livewire\Attributes\On;
use Livewire\Component;

class CartCounter extends Component
{
    #[On('cart-updated')]
    public function refreshCounter(): void
    {
    }

    public function getCartCountProperty(): int
    {
        if (! auth()->check()) {
            return 0;
        }

        return (int) (Cart::with('items')
            ->where('user_id', auth()->id())
            ->first()?->items
            ->sum('quantity') ?? 0);
    }

    public function render()
    {
        return view('livewire.cart-counter', [
            'cartCount' => $this->cartCount,
        ]);
    }
}
