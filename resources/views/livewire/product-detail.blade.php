<x-layout :title="$product->title . ' — BookBerry'">

    {{-- Breadcrumb --}}
    <div class="max-w-6xl mx-auto px-4 pt-6 pb-2">
        <nav class="flex items-center gap-2 text-xs text-gray-400">
            <a href="{{ route('home') }}" class="hover:text-purple-700 transition">Home</a>
            <span>›</span>
            <a href="{{ route('products') }}" class="hover:text-purple-700 transition">Books</a>
            <span>›</span>
            <a href="{{ route('products') }}?category={{ $product->category }}"
                class="hover:text-purple-700 transition capitalize">
                {{ $product->category }}
            </a>
            <span>›</span>
            <span class="text-gray-600 truncate max-w-[200px]">{{ $product->title }}</span>
        </nav>
    </div>

    {{-- Main Product Section --}}
    <div class="max-w-6xl mx-auto px-4 py-6">
        <div class="flex flex-col lg:flex-row gap-10">

            {{-- ===== LEFT: Book Cover ===== --}}
            <div class="w-full lg:w-[420px] shrink-0">

                {{-- Main image --}}
                <div class="bg-white rounded-2xl border border-purple-100 p-6 flex items-center
                    justify-center shadow-sm mb-3" style="min-height: 420px;">
                    <img
                        src="{{ $product->image_url }}"
                        alt="{{ $product->title }}"
                        class="max-h-96 w-auto object-contain rounded-xl shadow-lg"
                    />
                </div>

                {{-- Share row --}}
                <div class="flex items-center gap-3 px-1">
                    <span class="text-xs text-gray-400 font-medium">Share:</span>
                    <div class="flex gap-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                            target="_blank"
                            class="w-7 h-7 rounded-full bg-blue-600 flex items-center justify-center hover:opacity-80 transition">
                            <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
                            </svg>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($product->title) }}"
                            target="_blank"
                            class="w-7 h-7 rounded-full bg-sky-500 flex items-center justify-center hover:opacity-80 transition">
                            <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/>
                            </svg>
                        </a>
                        <a href="https://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&media={{ urlencode($product->image_url) }}"
                            target="_blank"
                            class="w-7 h-7 rounded-full bg-red-600 flex items-center justify-center hover:opacity-80 transition">
                            <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C5.373 0 0 5.373 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738a.36.36 0 01.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.632-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- ===== RIGHT: Product Info + Cart Panel ===== --}}
            <div class="flex-1 min-w-0">

                {{-- Title --}}
                <h1 class="text-2xl font-bold leading-tight mb-4" style="color: #2E2E2E;">
                    {{ $product->title }}
                    <span class="block text-sm font-normal text-gray-400 mt-1 capitalize">
                        {{ $product->category === 'manga' ? '🎌 Manga' : '📚 Wattpad Book' }}
                    </span>
                </h1>

                {{-- Rating --}}
                <div class="flex items-center gap-2 mb-5">
                    <div class="flex gap-0.5">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4" fill="{{ $i <= round($product->rating) ? '#F59E0B' : '#E5E7EB' }}"
                                viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <span class="text-sm text-gray-500">({{ number_format($product->rating, 1) }})</span>
                </div>

                {{-- ===== PURCHASE PANEL ===== --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                    {{-- SKU / ID --}}
                    <div class="px-5 pt-4 pb-0">
                        <span class="text-xs font-mono bg-gray-100 text-gray-500 px-2.5 py-1 rounded-md">
                            S{{ str_pad($product->id, 12, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>

                    {{-- Price --}}
                    <div class="px-5 pt-3 pb-4 border-b border-gray-100">
                        <p class="text-3xl font-bold" style="color: #E94E77;">
                            ₱{{ number_format($product->price, 2) }}
                        </p>

                        {{-- Stock status --}}
                        <div class="flex items-center gap-2 mt-2">
                            <span class="w-2 h-2 rounded-full inline-block"
                                style="background: {{ $product->stockStatusColor }};"></span>
                            <span class="text-sm font-semibold"
                                style="color: {{ $product->stockStatusColor }};">
                                {{ $product->stockStatus }}
                            </span>
                        </div>

                        @if($product->stock > 0)
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $product->stock }} {{ Str::plural('stock', $product->stock) }} available
                            </p>
                        @endif
                    </div>

                    {{-- Quantity + Add to Cart --}}
                    <div class="px-5 py-5 border-b border-gray-100">

                        @if($product->stock > 0)
                            {{-- Qty label --}}
                            <p class="text-sm font-semibold text-gray-600 mb-3">Qty:</p>

                            <div class="flex items-center gap-4 mb-4">
                                {{-- Qty controls --}}
                                <div class="flex items-center border-2 border-gray-200 rounded-xl overflow-hidden">
                                    <button
                                        wire:click="decrementQty"
                                        class="w-10 h-11 flex items-center justify-center text-lg font-bold
                                            text-gray-600 hover:bg-gray-50 transition
                                            disabled:opacity-40 disabled:cursor-not-allowed"
                                        {{ $quantity <= 1 ? 'disabled' : '' }}>
                                        −
                                    </button>
                                    <span class="w-12 text-center font-semibold text-gray-800 text-base">
                                        {{ $quantity }}
                                    </span>
                                    <button
                                        wire:click="incrementQty"
                                        class="w-10 h-11 flex items-center justify-center text-lg font-bold
                                            text-gray-600 hover:bg-gray-50 transition
                                            disabled:opacity-40 disabled:cursor-not-allowed"
                                        {{ $quantity >= $product->stock ? 'disabled' : '' }}>
                                        +
                                    </button>
                                </div>

                                {{-- Max stock hint --}}
                                @if($quantity >= $product->stock)
                                    <span class="text-xs text-orange-500 font-medium">
                                        Max available
                                    </span>
                                @endif
                            </div>

                            {{-- Subtotal hint --}}
                            @if($quantity > 1)
                                <p class="text-xs text-gray-400 mb-3">
                                    Subtotal:
                                    <span class="font-semibold text-gray-600">
                                        ₱{{ number_format($product->price * $quantity, 2) }}
                                    </span>
                                </p>
                            @endif

                            {{-- Add to Cart + Wishlist --}}
                            <div class="flex items-center gap-3">
                                @auth
                                    <button
                                        wire:click="addToCart"
                                        wire:loading.attr="disabled"
                                        wire:target="addToCart"
                                        class="flex-1 flex items-center justify-center gap-2 text-white
                                            font-semibold py-3.5 rounded-xl transition text-sm
                                            disabled:opacity-60"
                                        style="background: {{ $addedToCart ? '#16A34A' : '#E94E77' }};">
                                        <span wire:loading.remove wire:target="addToCart">
                                            @if($addedToCart)
                                                <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                Added to Cart!
                                            @else
                                                <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>
                                                Add to Cart
                                            @endif
                                        </span>
                                        <span wire:loading wire:target="addToCart"
                                            class="flex items-center gap-2">
                                            <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"/>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                                            </svg>
                                            Adding...
                                        </span>
                                    </button>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="flex-1 flex items-center justify-center gap-2 text-white
                                            font-semibold py-3.5 rounded-xl transition text-sm"
                                        style="background: #E94E77;">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        Login to Buy
                                    </a>
                                @endauth

                                {{-- Wishlist button --}}
                                <button
                                    class="w-12 h-12 rounded-xl border-2 border-gray-200 flex items-center
                                        justify-center text-gray-400 hover:border-pink-300 hover:text-pink-400
                                        transition group"
                                    title="Add to Wishlist">
                                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </button>
                            </div>

                            {{-- Go to cart link (shows after added) --}}
                            @if($addedToCart)
                                <a href="{{ route('cart') }}"
                                    class="flex items-center justify-center gap-2 text-sm font-semibold
                                        mt-3 py-2.5 rounded-xl border-2 border-purple-200 hover:bg-purple-50
                                        transition"
                                    style="color: #5A2A6E;">
                                    View Cart →
                                </a>
                            @endif

                        @else
                            {{-- Out of stock state --}}
                            <div class="text-center py-4">
                                <p class="text-red-500 font-semibold mb-2">Out of Stock</p>
                                <p class="text-sm text-gray-400">
                                    This item is currently unavailable.
                                </p>
                            </div>
                        @endif
                    </div>

                    {{-- Safe & Secure --}}
                    <div class="px-5 py-3 border-b border-gray-100 flex items-center gap-2">
                        <span class="text-lg">🔒</span>
                        <span class="text-sm font-medium text-gray-600">Safe and Secure Checkout</span>
                    </div>

                    {{-- Payment Methods --}}
                    <div class="px-5 py-4">
                        <p class="text-xs font-semibold text-gray-500 mb-3">You can pay through:</p>
                        <div class="grid grid-cols-3 gap-2">

                            {{-- Visa --}}
                            <div class="border border-gray-100 rounded-xl px-3 py-2.5 flex items-center
                                justify-center hover:border-gray-200 transition">
                                <svg viewBox="0 0 60 20" class="h-5 w-auto">
                                    <text x="0" y="16" font-family="Arial" font-size="18"
                                        font-weight="bold" fill="#1A1F71">VISA</text>
                                </svg>
                            </div>

                            {{-- Mastercard --}}
                            <div class="border border-gray-100 rounded-xl px-3 py-2.5 flex items-center
                                justify-center gap-1 hover:border-gray-200 transition">
                                <div class="w-5 h-5 rounded-full bg-red-500 opacity-90"></div>
                                <div class="w-5 h-5 rounded-full bg-yellow-400 opacity-90 -ml-2.5"></div>
                            </div>

                            {{-- Cash on Delivery --}}
                            <div class="border border-gray-100 rounded-xl px-2 py-2 flex items-center
                                justify-center hover:border-gray-200 transition">
                                <div class="text-center">
                                    <p class="text-xs font-bold leading-tight" style="color: #1A73E8; font-size: 9px;">
                                        CASH ON<br>DELIVERY
                                    </p>
                                </div>
                            </div>

                            {{-- GCash --}}
                            <div class="border border-gray-100 rounded-xl px-3 py-2.5 flex items-center
                                justify-center hover:border-gray-200 transition">
                                <span class="text-xs font-bold" style="color: #007DFF;">G</span>
                                <span class="text-xs font-bold text-gray-700 ml-0.5">GCash</span>
                            </div>

                            {{-- Maya --}}
                            <div class="border border-gray-100 rounded-xl px-3 py-2.5 flex items-center
                                justify-center hover:border-gray-200 transition">
                                <span class="text-xs font-bold italic" style="color: #00B140;">maya</span>
                            </div>

                            {{-- GrabPay --}}
                            <div class="border border-gray-100 rounded-xl px-3 py-2.5 flex items-center
                                justify-center hover:border-gray-200 transition">
                                <span class="text-xs font-bold" style="color: #00B14F;">Grab</span>
                                <span class="text-xs font-bold text-gray-700">Pay</span>
                            </div>

                        </div>
                    </div>

                </div>{{-- end purchase panel --}}
            </div>
        </div>

        {{-- ===== DESCRIPTION + DETAILS SECTION ===== --}}
        <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Description --}}
            <div class="md:col-span-2 bg-white rounded-2xl border border-gray-100 p-6">
                <h2 class="font-bold text-lg mb-4" style="color: #5A2A6E;">About this Book</h2>
                <p class="text-gray-600 text-sm leading-relaxed">
                    {{ $product->description ?? 'No description available for this product.' }}
                </p>
            </div>

            {{-- Book details --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h2 class="font-bold text-lg mb-4" style="color: #5A2A6E;">Details</h2>
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-400">Category</dt>
                        <dd class="font-semibold text-gray-700 capitalize">{{ $product->category }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-400">Format</dt>
                        <dd class="font-semibold text-gray-700">Trade Paperback</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-400">Rating</dt>
                        <dd class="font-semibold text-yellow-500">
                            ★ {{ number_format($product->rating, 1) }} / 5.0
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-400">Availability</dt>
                        <dd class="font-semibold" style="color: {{ $product->stockStatusColor }};">
                            {{ $product->stockStatus }}
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-400">Price</dt>
                        <dd class="font-bold" style="color: #E94E77;">
                            ₱{{ number_format($product->price, 2) }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- ===== RELATED PRODUCTS ===== --}}
        @php
            $related = \App\Models\Product::where('category', $product->category)
                ->where('id', '!=', $product->id)
                ->where('is_active', true)
                ->take(4)
                ->get();
        @endphp

        @if($related->count() > 0)
            <div class="mt-10">
                <h2 class="text-xl font-bold mb-5" style="color: #5A2A6E;">
                    More {{ $product->category === 'manga' ? 'Manga' : 'Wattpad Books' }}
                </h2>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @foreach($related as $rel)
                        <a href="{{ route('product.show', $rel) }}"
                            class="bg-white rounded-2xl overflow-hidden border border-purple-100 group
                                hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
                            <img src="{{ $rel->image_url }}" alt="{{ $rel->title }}"
                                class="w-full aspect-[2/3] object-cover
                                    group-hover:scale-105 transition-transform duration-300" />
                            <div class="p-3">
                                <p class="text-xs font-semibold truncate text-gray-700">{{ $rel->title }}</p>
                                <p class="text-sm font-bold mt-1" style="color: #E94E77;">
                                    ₱{{ number_format($rel->price, 2) }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    {{-- Reset addedToCart after 3s --}}
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('resetAddedToCart', () => {
                setTimeout(() => {
                    @this.set('addedToCart', false);
                }, 3000);
            });
        });
    </script>

</x-layout>