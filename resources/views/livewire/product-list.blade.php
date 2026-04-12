<div>

    <div class="max-w-7xl mx-auto px-4 py-8">

        {{-- Page header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold" style="color: #5A2A6E;">Browse Books</h1>
            <p class="text-sm text-gray-500 mt-1">
                Discover Filipino Wattpad stories and Japanese manga
            </p>
        </div>

        <div class="flex flex-col md:flex-row gap-6">

            {{-- ===== SIDEBAR FILTERS ===== --}}
            <aside class="w-full md:w-60 shrink-0">
                <div class="bg-white rounded-2xl border border-purple-100 p-5 sticky top-20">
                    <h3 class="font-semibold mb-4 flex items-center gap-2" style="color: #5A2A6E;">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 010 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h10a1 1 0 010 2H4a1 1 0 01-1-1zM3 16a1 1 0 011-1h6a1 1 0 010 2H4a1 1 0 01-1-1z"/>
                        </svg>
                        Filters
                    </h3>

                    {{-- Category --}}
                    <div class="mb-5">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2 block">
                            Category
                        </label>
                        <div class="space-y-2">
                            @foreach(['' => 'All Books', 'wattpad' => '📚 Wattpad', 'manga' => '🎌 Manga'] as $val => $label)
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="radio" wire:model.live="category" value="{{ $val }}"
                                        class="accent-purple-700" />
                                    <span class="text-sm text-gray-700 group-hover:text-purple-700 transition">
                                        {{ $label }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Price Range --}}
                    <div class="mb-5">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2 block">
                            Price Range (₱)
                        </label>
                        <div class="flex gap-2">
                            <input wire:model.live.debounce.500ms="minPrice"
                                type="number" placeholder="Min" min="0"
                                class="w-full border border-purple-200 rounded-xl px-3 py-2 text-sm
                                    outline-none focus:border-purple-400 transition" />
                            <input wire:model.live.debounce.500ms="maxPrice"
                                type="number" placeholder="Max" min="0"
                                class="w-full border border-purple-200 rounded-xl px-3 py-2 text-sm
                                    outline-none focus:border-purple-400 transition" />
                        </div>
                    </div>

                    {{-- Sort By --}}
                    <div class="mb-5">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2 block">
                            Sort By
                        </label>
                        <select wire:model.live="sort"
                            class="w-full border border-purple-200 rounded-xl px-3 py-2 text-sm
                                outline-none focus:border-purple-400 transition">
                            <option value="latest">Latest</option>
                            <option value="price_asc">Price: Low → High</option>
                            <option value="price_desc">Price: High → Low</option>
                            <option value="rating">Top Rated</option>
                        </select>
                    </div>

                    {{-- Reset --}}
                    <button wire:click="resetFilters"
                        class="w-full text-sm py-2 rounded-xl border border-purple-200 text-purple-700
                            hover:bg-purple-50 transition font-medium">
                        Reset All Filters
                    </button>
                </div>
            </aside>

            {{-- ===== PRODUCT AREA ===== --}}
            <div class="flex-1 min-w-0">

                {{-- Search + result count --}}
                <div class="flex flex-col sm:flex-row gap-3 mb-5">
                    <div class="relative flex-1 max-w-sm">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input
                            wire:model.live.debounce.400ms="search"
                            type="text"
                            placeholder="Search titles..."
                            class="w-full pl-10 pr-4 py-2 border border-purple-200 rounded-xl text-sm
                                outline-none focus:border-purple-400 transition"
                        />
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <span wire:loading class="text-purple-500">Searching...</span>
                        <span wire:loading.remove>
                            <strong style="color: #5A2A6E;">{{ $products->total() }}</strong> result(s) found
                        </span>
                    </div>
                </div>

                {{-- Product Grid --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                    @forelse($products as $product)
                        <div class="bg-white rounded-2xl overflow-hidden border border-purple-100 group
                            hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

                            <div class="relative overflow-hidden">
                                <img
                                    src="{{ $product->image_url }}"
                                    alt="{{ $product->title }}"
                                    class="w-full aspect-[2/3] object-cover
                                        group-hover:scale-105 transition-transform duration-300"
                                    loading="lazy"
                                />
                                <span class="absolute top-2 left-2 text-xs font-semibold px-2 py-0.5 rounded-full"
                                    style="{{ $product->category === 'manga'
                                        ? 'background:#EEF2FF; color:#4338CA;'
                                        : 'background:#FDF2F8; color:#9D174D;' }}">
                                    {{ $product->category === 'manga' ? '🎌' : '📚' }} {{ ucfirst($product->category) }}
                                </span>
                            </div>

                            <div class="p-3">
                                <p class="text-sm font-semibold truncate" title="{{ $product->title }}">
                                    {{ $product->title }}
                                </p>

                                {{-- Stars --}}
                                <div class="flex items-center gap-0.5 my-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span style="color: {{ $i <= round($product->rating) ? '#F59E0B' : '#E5E7EB' }}"
                                            class="text-xs">★</span>
                                    @endfor
                                </div>

                                <div class="flex items-center justify-between mb-2">
                                    <span style="color: #E94E77;" class="font-bold text-base">
                                        ₱{{ number_format($product->price, 2) }}
                                    </span>
                                </div>

                                <button
                                    wire:click="addToCart({{ $product->id }})"
                                    wire:loading.attr="disabled"
                                    wire:target="addToCart({{ $product->id }})"
                                    style="background: #5A2A6E;"
                                    class="w-full text-white text-xs font-semibold py-2 rounded-xl
                                        hover:opacity-90 transition disabled:opacity-60">
                                    <span wire:loading.remove wire:target="addToCart({{ $product->id }})">
                                        🛒 Add to Cart
                                    </span>
                                    <span wire:loading wire:target="addToCart({{ $product->id }})">
                                        Adding...
                                    </span>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-4 text-center py-20">
                            <p class="text-5xl mb-4">🔍</p>
                            <p class="font-semibold text-gray-500">No books found.</p>
                            <button wire:click="resetFilters"
                                class="mt-3 text-sm hover:underline"
                                style="color: #E94E77;">
                                Clear filters
                            </button>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if($products->hasPages())
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>
