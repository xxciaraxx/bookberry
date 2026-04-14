<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;

class ProductDetail extends Component
{
    public Product $product;
    public int     $quantity     = 1;
    public bool    $addedToCart  = false;

    public function mount(Product $product): void
    {
        // 404 if product is not active
        abort_unless($product->is_active, 404);
        $this->product = $product;
    }

    public function incrementQty(): void
    {
        if ($this->quantity < $this->product->stock) {
            $this->quantity++;
        }
    }

    public function decrementQty(): void
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart(): void
    {
        if (!auth()->check()) {
            $this->redirect(route('login'));
            return;
        }

        if ($this->product->stock < 1) {
            $this->dispatch('notify', message: 'Sorry, this item is out of stock.');
            return;
        }

        if ($this->quantity > $this->product->stock) {
            $this->quantity = $this->product->stock;
        }

        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $this->product->id)
            ->first();

        if ($item) {
            $newQty = min($item->quantity + $this->quantity, $this->product->stock);
            $item->update(['quantity' => $newQty]);
        } else {
            CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $this->product->id,
                'quantity'   => $this->quantity,
            ]);
        }

        $this->addedToCart = true;
        $this->dispatch('notify', message: "Added {$this->quantity} item(s) to cart! 🛒");
        $this->dispatch('cart-updated');

        // Reset after 3 seconds
        $this->dispatch('resetAddedToCart');
    }

    public function render()
    {
        return view('livewire.product-detail')
            ->layout('components.layout', ['title' => $this->product->title . ' — BookBerry']);
    }
}
