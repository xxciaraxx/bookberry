<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Collection;
use Livewire\Component;

class CartComponent extends Component
{
    public array $selectedItemIds = [];

    public function mount(): void
    {
        $cart = $this->getCart();

        $availableItemIds = $cart?->items->pluck('id')->map(fn ($id) => (int) $id)->all() ?? [];
        $hasStoredSelection = session()->has('checkout_item_ids');
        $storedItemIds = collect(session('checkout_item_ids', []))
            ->map(fn ($id) => (int) $id)
            ->intersect($availableItemIds)
            ->values()
            ->all();

        $this->selectedItemIds = $hasStoredSelection ? $storedItemIds : $availableItemIds;
        $this->persistSelectedItems();
    }

    public function increment(int $itemId): void
    {
        $item = CartItem::with('cart')->find($itemId);

        if ($item && $item->cart->user_id === auth()->id()) {
            $item->increment('quantity');
            $this->dispatch('cart-updated');
        }
    }

    public function decrement(int $itemId): void
    {
        $item = CartItem::with('cart')->find($itemId);

        if (! $item || $item->cart->user_id !== auth()->id()) {
            return;
        }

        if ($item->quantity > 1) {
            $item->decrement('quantity');
        } else {
            $item->delete();
            $this->selectedItemIds = array_values(array_diff($this->selectedItemIds, [$itemId]));
            $this->persistSelectedItems();
        }

        $this->dispatch('cart-updated');
    }

    public function remove(int $itemId): void
    {
        $item = CartItem::with('cart')->find($itemId);

        if ($item && $item->cart->user_id === auth()->id()) {
            $item->delete();
            $this->selectedItemIds = array_values(array_diff($this->selectedItemIds, [$itemId]));
            $this->persistSelectedItems();
            $this->dispatch('cart-updated');
        }
    }

    public function updatedSelectedItemIds(): void
    {
        $this->selectedItemIds = array_values(array_unique(array_map('intval', $this->selectedItemIds)));
        $this->persistSelectedItems();
    }

    public function proceedToCheckout()
    {
        if ($this->selectedItemIds === []) {
            $this->dispatch('notify', message: 'Select at least one item to continue to checkout.');
            return null;
        }

        $this->persistSelectedItems();

        return $this->redirectRoute('checkout', navigate: true);
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

        if ($cart) {
            $availableItemIds = $cart->items->pluck('id')->map(fn ($id) => (int) $id)->all();
            $this->selectedItemIds = array_values(array_intersect($this->selectedItemIds, $availableItemIds));

            $this->persistSelectedItems();
        } else {
            $this->selectedItemIds = [];
            session()->forget('checkout_item_ids');
        }

        return view('livewire.cart', [
            'cart' => $cart,
            'selectedItems' => $this->selectedItems,
            'selectedItemCount' => $this->selectedItemCount,
            'selectedSubtotal' => $this->selectedSubtotal,
            'selectedShipping' => $this->selectedShipping,
            'selectedTotal' => $this->selectedTotal,
        ])->layout('components.layout', ['title' => 'My Cart - BookBerry']);
    }

    private function getCart(): ?Cart
    {
        return Cart::with('items.product')
            ->where('user_id', auth()->id())
            ->first();
    }

    private function persistSelectedItems(): void
    {
        session(['checkout_item_ids' => $this->selectedItemIds]);
    }
}
