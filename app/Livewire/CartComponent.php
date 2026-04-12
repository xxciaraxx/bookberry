<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;
use App\Models\CartItem;

class CartComponent extends Component
{
    public function increment(int $itemId): void
    {
        $item = CartItem::find($itemId);

        if ($item && $item->cart->user_id === auth()->id()) {
            $item->increment('quantity');
        }
    }

    public function decrement(int $itemId): void
    {
        $item = CartItem::find($itemId);

        if ($item && $item->cart->user_id === auth()->id()) {
            if ($item->quantity > 1) {
                $item->decrement('quantity');
            } else {
                $item->delete();
            }
        }
    }

    public function remove(int $itemId): void
    {
        $item = CartItem::find($itemId);

        if ($item && $item->cart->user_id === auth()->id()) {
            $item->delete();
        }
    }

    public function render()
    {
        $cart = Cart::with('items.product')
            ->where('user_id', auth()->id())
            ->first();

        return view('livewire.cart', compact('cart'))
            ->layout('components.layout', ['title' => 'My Cart — BookBerry']);
    }
}
