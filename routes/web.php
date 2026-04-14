<?php

use App\Livewire\Actions\Logout;
use App\Livewire\Admin\AdminCustomers;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\AdminOrders;
use App\Livewire\Admin\AdminProductManager;
use App\Livewire\CartComponent;
use App\Livewire\CheckoutComponent;
use App\Livewire\LandingPage;
use App\Livewire\ProductDetail;
use App\Livewire\ProductList;
use Illuminate\Support\Facades\Route;

// ── Public ────────────────────────────────────────────────────
Route::get('/', LandingPage::class)->name('home');
Route::get('/products', ProductList::class)->name('products');
Route::get('/products/{product}', ProductDetail::class)->name('product.show');

// ── Authenticated Customer ────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/cart', CartComponent::class)->name('cart');
    Route::get('/checkout', CheckoutComponent::class)->name('checkout');

    Route::post('/logout', function (Logout $logout) {
        $logout();
        return redirect()->route('home');
    })->name('logout');
});

// ── Admin ─────────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
    Route::get('/products', AdminProductManager::class)->name('products');
    Route::get('/orders', AdminOrders::class)->name('orders');
    Route::get('/customers', AdminCustomers::class)->name('customers');
});

// ── Breeze defaults (keep as-is) ──────────────────────────────
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';