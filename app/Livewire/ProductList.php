<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;

class ProductList extends Component
{
    use WithPagination;

    public string $search   = '';
    public string $category = '';
    public string $minPrice = '';
    public string $maxPrice = '';
    public string $sort     = 'latest';

    protected $queryString = [
        'search'   => ['except' => ''],
        'category' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingCategory(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'category', 'minPrice', 'maxPrice', 'sort']);
        $this->resetPage();
    }

    public function addToCart(int $productId): void
    {
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->first();

        if ($item) {
            $item->increment('quantity');
        } else {
            CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $productId,
                'quantity'   => 1,
            ]);
        }

        $this->dispatch('notify', message: 'Added to cart! 🛒');
    }

    public function render()
    {
        $query = Product::where('is_active', true);

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->category) {
            $query->where('category', $this->category);
        }

        if ($this->minPrice !== '') {
            $query->where('price', '>=', (float) $this->minPrice);
        }

        if ($this->maxPrice !== '') {
            $query->where('price', '<=', (float) $this->maxPrice);
        }

        match ($this->sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'rating'     => $query->orderBy('rating', 'desc'),
            default      => $query->latest(),
        };

        $products = $query->paginate(12);

        return view('livewire.product-list', compact('products'))
            ->layout('components.layout', ['title' => 'Browse Books — BookBerry']);
    }
}
