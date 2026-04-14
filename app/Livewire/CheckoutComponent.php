<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Collection;
use Livewire\Component;

class CheckoutComponent extends Component
{
    public string $name = '';
    public string $phone = '';
    public string $address = '';
    public string $city = '';
    public string $payment_method = 'cod';
    public bool $orderPlaced = false;
    public ?int $orderId = null;
    public array $selectedItemIds = [];

    protected $rules = [
        'name' => 'required|string|min:2|max:100',
        'phone' => 'required|string|min:10|max:15',
        'address' => 'required|string|min:10|max:255',
        'city' => 'required|string|max:100',
        'payment_method' => 'required|in:cod,gcash,bank',
    ];

    protected $messages = [
        'name.required' => 'Full name is required.',
        'phone.required' => 'Phone number is required.',
        'address.required' => 'Shipping address is required.',
        'address.min' => 'Please enter a complete address.',
        'city.required' => 'City is required.',
    ];

    public function mount(): void
    {
        $this->name = auth()->user()->name ?? '';

        $cart = $this->getCart();
        $availableItemIds = $cart?->items->pluck('id')->map(fn ($id) => (int) $id)->all() ?? [];
        $hasStoredSelection = session()->has('checkout_item_ids');
        $storedItemIds = collect(session('checkout_item_ids', []))
            ->map(fn ($id) => (int) $id)
            ->intersect($availableItemIds)
            ->values()
            ->all();

        $this->selectedItemIds = $hasStoredSelection ? $storedItemIds : $availableItemIds;
    }

    public function selectPaymentMethod(string $method): void
    {
        $this->payment_method = $method;
    }

    public function placeOrder(): void
    {
        $this->validate();

        $cart = $this->getCart();

        if (! $cart || $cart->items->isEmpty()) {
            $this->addError('address', 'Your cart is empty.');
            return;
        }

        $selectedItems = $cart->items->whereIn('id', $this->selectedItemIds)->values();

        if ($selectedItems->isEmpty()) {
            $this->addError('address', 'Select at least one cart item before placing your order.');
            return;
        }

        $subtotal = (float) $selectedItems->sum(fn ($item) => $item->subtotal);

        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $subtotal,
            'status' => 'pending',
            'shipping_address' => "{$this->address}, {$this->city}",
        ]);

        foreach ($selectedItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        $cart->items()->whereIn('id', $selectedItems->pluck('id'))->delete();

        session()->forget('checkout_item_ids');
        $this->selectedItemIds = [];
        $this->orderId = $order->id;
        $this->orderPlaced = true;
        $this->dispatch('cart-updated');
    }

    public function getSelectedItemsProperty(): Collection
    {
        return $this->getCart()?->items
            ?->whereIn('id', $this->selectedItemIds)
            ->values() ?? collect();
    }

    public function getSelectedItemCountProperty(): int
    {
        return $this->selectedItems->sum('quantity');
    }

    public function getSelectedSubtotalProperty(): float
    {
        return (float) $this->selectedItems->sum(fn ($item) => $item->subtotal);
    }

    public function getSelectedShippingProperty(): float
    {
        return $this->selectedSubtotal >= 500 || $this->selectedSubtotal === 0.0 ? 0.0 : 50.0;
    }

    public function getSelectedTotalProperty(): float
    {
        return $this->selectedSubtotal + $this->selectedShipping;
    }

    public function render()
    {
        $cart = $this->getCart();

        return view('livewire.checkout', [
            'cart' => $cart,
            'selectedItems' => $this->selectedItems,
            'selectedItemCount' => $this->selectedItemCount,
            'selectedSubtotal' => $this->selectedSubtotal,
            'selectedShipping' => $this->selectedShipping,
            'selectedTotal' => $this->selectedTotal,
        ])->layout('components.layout', ['title' => 'Checkout - BookBerry']);
    }

    private function getCart(): ?Cart
    {
        return Cart::with('items.product')
            ->where('user_id', auth()->id())
            ->first();
    }
}
