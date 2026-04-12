<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutComponent extends Component
{
    public string $name            = '';
    public string $phone           = '';
    public string $address         = '';
    public string $city            = '';
    public string $payment_method  = 'cod';
    public bool   $orderPlaced     = false;
    public ?int   $orderId         = null;

    protected $rules = [
        'name'           => 'required|string|min:2|max:100',
        'phone'          => 'required|string|min:10|max:15',
        'address'        => 'required|string|min:10|max:255',
        'city'           => 'required|string|max:100',
        'payment_method' => 'required|in:cod,gcash,bank',
    ];

    protected $messages = [
        'name.required'    => 'Full name is required.',
        'phone.required'   => 'Phone number is required.',
        'address.required' => 'Shipping address is required.',
        'address.min'      => 'Please enter a complete address.',
        'city.required'    => 'City is required.',
    ];

    public function mount(): void
    {
        // Pre-fill name from user profile
        $this->name = auth()->user()->name ?? '';
    }

    public function placeOrder(): void
    {
        $this->validate();

        $cart = Cart::with('items.product')
            ->where('user_id', auth()->id())
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            $this->addError('address', 'Your cart is empty.');
            return;
        }

        $order = Order::create([
            'user_id'          => auth()->id(),
            'total_amount'     => $cart->total,
            'status'           => 'pending',
            'shipping_address' => "{$this->address}, {$this->city}",
        ]);

        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->price,
            ]);
        }

        // Clear the cart
        $cart->items()->delete();

        $this->orderId    = $order->id;
        $this->orderPlaced = true;
    }

    public function render()
    {
        $cart = Cart::with('items.product')
            ->where('user_id', auth()->id())
            ->first();

        return view('livewire.checkout', compact('cart'))
            ->layout('components.layout', ['title' => 'Checkout — BookBerry']);
    }
}
