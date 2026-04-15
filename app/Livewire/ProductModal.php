<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;

class ProductModal extends Component
{
    public bool     $show        = false;
    public ?int     $productId   = null;
    public ?Product $product     = null;
    public int      $quantity    = 1;
    public bool     $addedToCart = false;

    protected $listeners = [
        'openProductModal' => 'open',
    ];

    public function open(int $productId): void
    {
        $this->product     = Product::findOrFail($productId);
        $this->productId   = $productId;
        $this->quantity    = 1;
        $this->addedToCart = false;
        $this->show        = true;
    }

    public function close(): void
    {
        $this->show      = false;
        $this->product   = null;
        $this->productId = null;
        $this->quantity  = 1;
    }

    public function incrementQty(): void
    {
        if ($this->product && $this->quantity < $this->product->stock) {
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

        if (!$this->product || $this->product->stock < 1) {
            $this->dispatch('notify', message: 'Sorry, this item is out of stock.');
            return;
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
        $this->dispatch('notify', message: "Added to cart! 🛒");
    }

    public function render()
    {
        return view('livewire.product-modal');
    }
}