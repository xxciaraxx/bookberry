<?php

namespace Tests\Feature;

use App\Livewire\ProductList;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ProductFiltersTest extends TestCase
{
    use RefreshDatabase;

    public function test_filters_apply_and_reset_correctly(): void
    {
        Product::create([
            'title' => 'Cheap Wattpad',
            'category' => 'wattpad',
            'description' => 'Cheap story',
            'price' => 120,
            'image_path' => null,
            'rating' => 3,
            'is_active' => true,
        ]);

        Product::create([
            'title' => 'Mid Wattpad',
            'category' => 'wattpad',
            'description' => 'Mid story',
            'price' => 180,
            'image_path' => null,
            'rating' => 4,
            'is_active' => true,
        ]);

        Product::create([
            'title' => 'Premium Manga',
            'category' => 'manga',
            'description' => 'Premium manga',
            'price' => 300,
            'image_path' => null,
            'rating' => 5,
            'is_active' => true,
        ]);

        Livewire::test(ProductList::class)
            ->set('category', 'manga')
            ->assertSee('Premium Manga')
            ->assertDontSee('Cheap Wattpad')
            ->set('minPrice', '250')
            ->assertSee('Premium Manga')
            ->set('maxPrice', '350')
            ->assertSee('Premium Manga')
            ->set('search', 'Premium')
            ->assertSee('Premium Manga')
            ->set('sort', 'price_desc')
            ->call('resetFilters')
            ->assertSet('search', '')
            ->assertSet('category', 'all')
            ->assertSet('minPrice', '')
            ->assertSet('maxPrice', '')
            ->assertSet('sort', 'latest')
            ->assertSee('Cheap Wattpad')
            ->assertSee('Mid Wattpad')
            ->assertSee('Premium Manga');
    }

    public function test_clicking_the_same_category_again_resets_it_to_all_books(): void
    {
        Livewire::test(ProductList::class)
            ->assertSet('category', 'all')
            ->call('toggleCategory', 'manga')
            ->assertSet('category', 'manga')
            ->call('toggleCategory', 'manga')
            ->assertSet('category', 'all')
            ->call('toggleCategory', 'wattpad')
            ->assertSet('category', 'wattpad')
            ->call('resetFilters')
            ->assertSet('category', 'all');
    }
}
