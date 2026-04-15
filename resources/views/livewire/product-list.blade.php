<div class="max-w-7xl mx-auto px-4 py-8">

    <div class="mb-6">
        <h1 class="text-2xl font-bold" style="color: #5A2A6E;">Browse Books</h1>
        <p class="text-sm text-gray-500 mt-1">Click any book to view details, or add directly to cart.</p>
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

                <div class="mb-5">
                    <label class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2 block">Category</label>
                    <div class="space-y-2">
                        @foreach(['all' => 'All Books', 'wattpad' => 'Wattpad', 'manga' => 'Manga'] as $val => $label)
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

                <div class="mb-5">
                    <label class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2 block">Price Range (PHP)</label>
                    <div class="flex gap-2">
                        <input wire:model.live.debounce.500ms="minPrice" type="number" placeholder="Min" min="0"
                            class="w-full border border-purple-200 rounded-xl px-3 py-2 text-sm outline-none
                                focus:border-purple-400 transition" />
                        <input wire:model.live.debounce.500ms="maxPrice" type="number" placeholder="Max" min="0"
                            class="w-full border border-purple-200 rounded-xl px-3 py-2 text-sm outline-none
                                focus:border-purple-400 transition" />
                    </div>
                </div>

                <div class="mb-5">
                    <label class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2 block">Sort By</label>
                    <select wire:model.live="sort"
                        class="w-full border border-purple-200 rounded-xl px-3 py-2 text-sm outline-none
                            focus:border-purple-400 transition">
                        <option value="latest">Latest</option>
                        <option value="price_asc">Price: Low to High</option>
                        <option value="price_desc">Price: High to Low</option>
                        <option value="rating">Top Rated</option>
                    </select>
                </div>

                <button wire:click="resetFilters"
                    class="w-full text-sm py-2 rounded-xl border border-purple-200 text-purple-700
                        hover:bg-purple-50 transition font-medium">
                    Reset All Filters
                </button>
            </div>
        </aside>

        {{-- ===== PRODUCT AREA ===== --}}
        <div class="flex-1 min-w-0">

            <div class="flex flex-col sm:flex-row gap-3 mb-5">
                <div class="relative flex-1 max-w-sm">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input wire:model.live.debounce.400ms="search" type="text"
                        placeholder="Search titles..."
                        class="w-full pl-10 pr-4 py-2 border border-purple-200 rounded-xl text-sm
                            outline-none focus:border-purple-400 transition" />
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <span wire:loading class="text-purple-500">Searching...</span>
                    <span wire:loading.remove>
                        <strong style="color: #5A2A6E;">{{ $products->total() }}</strong> result(s) found
                    </span>
                </div>
            </div>

            {{-- ===== PRODUCT GRID ===== --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @forelse($products as $product)

                    {{-- ===== CLICKABLE BOOK CARD ===== --}}
                    <div
                        wire:click="$dispatch('openProductModal', { productId: {{ $product->id }} })"
                        class="bg-white rounded-2xl overflow-hidden border border-purple-100 group
                            hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">

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
                                {{ ucfirst($product->category) }}
                            </span>

                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10
                                transition-all duration-300 flex items-center justify-center">
                                <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300
                                    bg-white/90 text-purple-800 text-xs font-semibold px-3 py-1.5 rounded-full shadow">
                                    Quick View
                                </span>
                            </div>
                        </div>

                        <div class="p-3">
                            <p class="text-sm font-semibold truncate" title="{{ $product->title }}">
                                {{ $product->title }}
                            </p>
                            <div class="flex items-center gap-0.5 my-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <span style="color: {{ $i <= round($product->rating) ? '#F59E0B' : '#E5E7EB' }}"
                                        class="text-xs">*</span>
                                @endfor
                            </div>
                            <div class="flex items-center justify-between">
                                <span style="color: #E94E77;" class="font-bold text-base">
                                    PHP {{ number_format($product->price, 2) }}
                                </span>
                                @if(isset($product->stock) && $product->stock <= 3 && $product->stock > 0)
                                    <span class="text-xs text-orange-500 font-medium">Low stock</span>
                                @elseif(isset($product->stock) && $product->stock === 0)
                                    <span class="text-xs text-red-400 font-medium">Out of stock</span>
                                @endif
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="col-span-4 text-center py-20">
                        <p class="text-5xl mb-4">No results</p>
                        <p class="font-semibold text-gray-500">No books found.</p>
                        <button wire:click="resetFilters" class="mt-3 text-sm hover:underline" style="color: #E94E77;">
                            Clear filters
                        </button>
                    </div>
                @endforelse
            </div>

            @if($products->hasPages())
                <div class="mt-8">{{ $products->links() }}</div>
            @endif
        </div>
    </div>
</div>
