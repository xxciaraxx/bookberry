<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class LandingPage extends Component
{
    public string $activeTab = 'all';

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        $query = Product::where('is_active', true);

        if ($this->activeTab !== 'all') {
            $query->where('category', $this->activeTab);
        }

        $products = $query->latest()->take(8)->get();

        return view('livewire.landing-page', compact('products'))
            ->layout('components.layout', ['title' => 'BookBerry — Home']);
    }
}
