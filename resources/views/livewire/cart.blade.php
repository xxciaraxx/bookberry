<div>

    <div class="max-w-5xl mx-auto px-4 py-10">

        <h1 class="text-2xl font-bold mb-6 flex items-center gap-2" style="color: #5A2A6E;">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            My Cart
        </h1>

        @if(!$cart || $cart->items->isEmpty())

            {{-- Empty cart --}}
            <div class="text-center py-24 bg-white rounded-2xl border border-purple-100">
                <div class="text-7xl mb-4">🛒</div>
                <h2 class="text-xl font-bold mb-2" style="color: #5A2A6E;">Your cart is empty</h2>
                <p class="text-gray-400 text-sm mb-6">You haven't added any books yet.</p>
                <a href="{{ route('products') }}"
                    style="background: #E94E77;"
                    class="text-white font-semibold px-8 py-3 rounded-xl hover:opacity-90 transition inline-block">
                    Browse Books
                </a>
            </div>

        @else

            <div class="flex flex-col lg:flex-row gap-6">

                {{-- ===== CART ITEMS ===== --}}
                <div class="flex-1">
                    <div class="bg-white rounded-2xl border border-purple-100 overflow-hidden">

                        <div class="px-5 py-4 border-b border-purple-50 flex items-center justify-between">
                            <h2 class="font-semibold text-gray-700">
                                {{ $cart->count }} {{ Str::plural('item', $cart->count) }}
                            </h2>
                            <span class="text-sm text-gray-400">Manage your selections</span>
                        </div>

                        @foreach($cart->items as $item)
                            <div class="flex items-start gap-4 p-5 border-b border-purple-50 last:border-0
                                hover:bg-purple-50/30 transition">

                                {{-- Book cover --}}
                                <img
                                    src="{{ $item->product->image_url }}"
                                    alt="{{ $item->product->title }}"
                                    class="w-16 h-24 object-cover rounded-xl shrink-0 shadow-sm"
                                />

                                {{-- Book info --}}
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-gray-800 truncate">
                                        {{ $item->product->title }}
                                    </h3>
                                    <span class="text-xs px-2 py-0.5 rounded-full font-medium inline-block mt-1"
                                        style="{{ $item->product->category === 'manga'
                                            ? 'background:#EEF2FF; color:#4338CA;'
                                            : 'background:#FDF2F8; color:#9D174D;' }}">
                                        {{ ucfirst($item->product->category) }}
                                    </span>
                                    <p class="text-xs text-gray-400 mt-1">
                                        Unit price: ₱{{ number_format($item->product->price, 2) }}
                                    </p>

                                    {{-- Quantity controls --}}
                                    <div class="flex items-center gap-3 mt-3">
                                        <button wire:click="decrement({{ $item->id }})"
                                            class="w-8 h-8 rounded-full border-2 border-purple-200 font-bold
                                                text-purple-700 hover:bg-purple-100 transition flex items-center justify-center">
                                            −
                                        </button>
                                        <span class="font-semibold w-6 text-center text-gray-800">
                                            {{ $item->quantity }}
                                        </span>
                                        <button wire:click="increment({{ $item->id }})"
                                            class="w-8 h-8 rounded-full border-2 border-purple-200 font-bold
                                                text-purple-700 hover:bg-purple-100 transition flex items-center justify-center">
                                            +
                                        </button>
                                    </div>
                                </div>

                                {{-- Subtotal + remove --}}
                                <div class="text-right shrink-0">
                                    <p style="color: #E94E77;" class="font-bold text-lg">
                                        ₱{{ number_format($item->subtotal, 2) }}
                                    </p>
                                    <button wire:click="remove({{ $item->id }})"
                                        wire:confirm="Remove this item from cart?"
                                        class="text-xs text-red-400 hover:text-red-600 transition mt-2 flex items-center gap-1 ml-auto">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Remove
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <a href="{{ route('products') }}"
                        style="color: #5A2A6E;"
                        class="inline-flex items-center gap-2 text-sm font-medium mt-4 hover:underline">
                        ← Continue Shopping
                    </a>
                </div>

                {{-- ===== ORDER SUMMARY ===== --}}
                <div class="w-full lg:w-80 shrink-0">
                    <div class="bg-white rounded-2xl border border-purple-100 p-5 sticky top-20">
                        <h2 class="font-semibold text-gray-700 mb-4">Order Summary</h2>

                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between text-gray-500">
                                <span>Subtotal ({{ $cart->count }} items)</span>
                                <span>₱{{ number_format($cart->total, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-500">
                                <span>Shipping</span>
                                <span class="{{ $cart->total >= 500 ? 'text-green-600 font-semibold' : '' }}">
                                    {{ $cart->total >= 500 ? 'FREE' : '₱50.00' }}
                                </span>
                            </div>
                            @if($cart->total < 500)
                                <p class="text-xs text-gray-400">
                                    Add ₱{{ number_format(500 - $cart->total, 2) }} more for free shipping!
                                </p>
                            @endif
                        </div>

                        <div class="border-t border-purple-100 mt-4 pt-4 flex justify-between font-bold text-lg"
                            style="color: #5A2A6E;">
                            <span>Total</span>
                            <span>₱{{ number_format($cart->total + ($cart->total >= 500 ? 0 : 50), 2) }}</span>
                        </div>

                        <a href="{{ route('checkout') }}"
                            style="background: #E94E77;"
                            class="block text-center text-white font-semibold py-3 rounded-xl mt-5
                                hover:opacity-90 transition text-sm">
                            Proceed to Checkout →
                        </a>

                        {{-- Trust badges --}}
                        <div class="mt-4 pt-4 border-t border-purple-50 space-y-2">
                            <div class="flex items-center gap-2 text-xs text-gray-400">
                                <span>🔒</span> <span>Secure checkout</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-400">
                                <span>🚚</span> <span>Free shipping on ₱500+</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-400">
                                <span>↩️</span> <span>Easy returns</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endif
    </div>

</div>
