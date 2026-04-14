<div>

    <div class="max-w-5xl mx-auto px-4 py-10">

        @if($orderPlaced)
            <div class="text-center py-20 bg-white rounded-2xl border border-green-100 shadow-sm">
                <div class="text-7xl mb-4 animate-bounce">🎉</div>
                <h2 class="text-3xl font-bold text-green-700 mb-2">Order Placed!</h2>
                <p class="text-gray-500 mb-1">Thank you for shopping at <strong>BookBerry</strong>.</p>
                <p class="text-gray-400 text-sm mb-8">
                    Order #{{ str_pad($orderId, 6, '0', STR_PAD_LEFT) }} - We'll process it right away!
                </p>
                <div class="flex justify-center gap-3">
                    <a href="{{ route('products') }}" style="background: #5A2A6E;"
                        class="text-white font-semibold px-8 py-3 rounded-xl hover:opacity-90 transition inline-block">
                        Continue Shopping
                    </a>
                    <a href="{{ route('home') }}"
                        class="text-purple-700 font-semibold px-8 py-3 rounded-xl border-2 border-purple-200
                            hover:bg-purple-50 transition inline-block">
                        Back to Home
                    </a>
                </div>
            </div>
        @else
            <h1 class="text-2xl font-bold mb-6" style="color: #5A2A6E;">Checkout</h1>

            @if(!$cart || $selectedItems->isEmpty())
                <div class="text-center py-16 bg-white rounded-2xl border border-purple-100">
                    <p class="text-5xl mb-4">🛒</p>
                    <p class="font-semibold text-gray-500">Your cart is empty.</p>
                    <a href="{{ route('products') }}" style="color: #E94E77;"
                        class="text-sm mt-2 inline-block hover:underline">← Browse books</a>
                </div>
            @else
                <div class="flex flex-col lg:flex-row gap-6">

                    <div class="flex-1">
                        <div class="bg-white rounded-2xl border border-purple-100 p-6">
                            <h2 class="font-semibold text-gray-700 mb-5 flex items-center gap-2">
                                <span style="background: #5A2A6E;"
                                    class="w-6 h-6 rounded-full text-white text-xs flex items-center justify-center font-bold">
                                    1
                                </span>
                                Shipping Details
                            </h2>

                            <div class="space-y-4">
                                <div>
                                    <label class="text-xs font-semibold text-gray-400 uppercase tracking-wide block mb-1">
                                        Full Name *
                                    </label>
                                    <input wire:model="name" type="text" placeholder="Juan dela Cruz"
                                        class="w-full border border-purple-200 rounded-xl px-4 py-3 text-sm
                                            outline-none focus:border-purple-400 transition" />
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="text-xs font-semibold text-gray-400 uppercase tracking-wide block mb-1">
                                        Phone Number *
                                    </label>
                                    <input wire:model="phone" type="text" placeholder="09XX-XXX-XXXX"
                                        class="w-full border border-purple-200 rounded-xl px-4 py-3 text-sm
                                            outline-none focus:border-purple-400 transition" />
                                    @error('phone')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="text-xs font-semibold text-gray-400 uppercase tracking-wide block mb-1">
                                        Street Address *
                                    </label>
                                    <textarea wire:model="address" rows="3"
                                        placeholder="House No., Street, Barangay"
                                        class="w-full border border-purple-200 rounded-xl px-4 py-3 text-sm
                                            outline-none focus:border-purple-400 transition resize-none"></textarea>
                                    @error('address')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="text-xs font-semibold text-gray-400 uppercase tracking-wide block mb-1">
                                        City / Municipality *
                                    </label>
                                    <input wire:model="city" type="text" placeholder="Quezon City"
                                        class="w-full border border-purple-200 rounded-xl px-4 py-3 text-sm
                                            outline-none focus:border-purple-400 transition" />
                                    @error('city')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl border border-purple-100 p-6 mt-4">
                            <h2 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                                <span style="background: #5A2A6E;"
                                    class="w-6 h-6 rounded-full text-white text-xs flex items-center justify-center font-bold">
                                    2
                                </span>
                                Payment Method
                            </h2>

                            <div class="space-y-2">
                                @foreach([
                                    'cod' => ['💵', 'Cash on Delivery', 'Pay when your order arrives'],
                                    'gcash' => ['📱', 'GCash', 'Pay via GCash mobile wallet'],
                                    'bank' => ['🏦', 'Bank Transfer', 'Pay via online banking'],
                                ] as $val => [$icon, $name, $desc])
                                    <button type="button" wire:click="selectPaymentMethod('{{ $val }}')"
                                        class="w-full flex items-center gap-3 p-3 rounded-xl border-2 text-left transition
                                        {{ $payment_method === $val
                                            ? 'border-purple-500 bg-purple-50'
                                            : 'border-gray-100 hover:border-purple-200' }}">
                                        <span class="w-5 h-5 rounded-full border-2 flex items-center justify-center transition
                                            {{ $payment_method === $val ? 'border-blue-600' : 'border-gray-400' }}">
                                            @if($payment_method === $val)
                                                <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                                            @endif
                                        </span>
                                        <span class="text-xl">{{ $icon }}</span>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-700">{{ $name }}</p>
                                            <p class="text-xs text-gray-400">{{ $desc }}</p>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="w-full lg:w-80 shrink-0">
                        <div class="bg-white rounded-2xl border border-purple-100 p-5 sticky top-20">
                            <h2 class="font-semibold text-gray-700 mb-4">Order Summary</h2>

                            <div class="space-y-3 mb-4">
                                @foreach($selectedItems as $item)
                                    <div class="flex gap-3 items-start">
                                        <img src="{{ $item->product->image_url }}"
                                            alt="{{ $item->product->title }}"
                                            class="w-10 h-14 object-cover rounded-lg shrink-0" />
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-semibold truncate text-gray-700">
                                                {{ $item->product->title }}
                                            </p>
                                            <p class="text-xs text-gray-400">Qty: {{ $item->quantity }}</p>
                                        </div>
                                        <span class="text-xs font-semibold shrink-0" style="color: #E94E77;">
                                            ₱{{ number_format($item->subtotal, 2) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>

                            <div class="border-t border-purple-100 pt-4 space-y-2 text-sm">
                                <div class="flex justify-between text-gray-500">
                                    <span>Subtotal</span>
                                    <span>₱{{ number_format($selectedSubtotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-gray-500">
                                    <span>Shipping</span>
                                    <span class="{{ $selectedShipping === 0.0 && $selectedSubtotal > 0 ? 'text-green-600 font-semibold' : '' }}">
                                        {{ $selectedShipping === 0.0 ? 'FREE' : '₱50.00' }}
                                    </span>
                                </div>
                                <div class="flex justify-between font-bold text-lg pt-2 border-t border-purple-100"
                                    style="color: #5A2A6E;">
                                    <span>Total</span>
                                    <span>₱{{ number_format($selectedTotal, 2) }}</span>
                                </div>
                            </div>

                            <button
                                wire:click="placeOrder"
                                wire:loading.attr="disabled"
                                wire:target="placeOrder"
                                style="background: #E94E77;"
                                class="w-full mt-5 text-white font-semibold py-3.5 rounded-xl
                                    hover:opacity-90 transition disabled:opacity-60 text-sm">
                                <span wire:loading.remove wire:target="placeOrder">Place Order 🎉</span>
                                <span wire:loading wire:target="placeOrder">Processing...</span>
                            </button>

                            <p class="text-center text-xs text-gray-400 mt-3">
                                🔒 Your order is secure & protected
                            </p>
                        </div>
                    </div>

                </div>
            @endif
        @endif
    </div>

</div>
