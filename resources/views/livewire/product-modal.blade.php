{{-- ============================================================
     BookBerry Product Modal
     Include this component once in layout.blade.php:
     <livewire:product-modal />
     Then dispatch from any card: $dispatch('openProductModal', { productId: id })
     ============================================================ --}}

<div>
	    @if($show && $product)
	        <div
	            x-data="{
	                lockScroll() { document.documentElement.classList.add('overflow-hidden') },
	                unlockScroll() { document.documentElement.classList.remove('overflow-hidden') },
	                close() { this.unlockScroll(); $wire.close() },
	            }"
	            x-init="lockScroll()"
	            x-on:keydown.escape.window="close()"
	        >
	            <div
	                class="fixed inset-0 z-40 bg-[#2a1438]/55 backdrop-blur-md"
	                x-transition:enter="transition ease-out duration-200"
	                x-transition:enter-start="opacity-0"
	                x-transition:enter-end="opacity-100"
	                x-transition:leave="transition ease-in duration-150"
	                x-transition:leave-start="opacity-100"
	                x-transition:leave-end="opacity-0"
	                @click="close()"
	            ></div>

	            <div
	                class="fixed inset-0 z-50 flex items-center justify-center px-4 py-10 sm:px-6 sm:py-12"
	            >
		            <div
		                class="relative w-full max-w-4xl overflow-hidden rounded-[2rem] border border-white/60 bg-[#fffaf5] shadow-[0_28px_90px_rgba(65,22,83,0.22)] 2xl:max-w-5xl"
		                x-transition:enter="transition ease-out duration-250"
		                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
		                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
		                x-transition:leave="transition ease-in duration-150"
		                x-transition:leave-start="opacity-100 scale-100"
		                x-transition:leave-end="opacity-0 scale-95"
		                @click.stop
		            >
                <div class="absolute inset-x-0 top-0 h-28 bg-gradient-to-r from-[#6d327e] via-[#8c58ab] to-[#ef5b87] opacity-10"></div>

	                <button
	                    type="button"
	                    @click="close()"
	                    class="absolute right-5 top-5 z-10 flex h-10 w-10 items-center justify-center rounded-full border border-[#eadff0] bg-white/90 text-lg font-semibold leading-none text-[#6b5179] shadow-sm transition hover:bg-white hover:text-[#43204f]"
	                    aria-label="Close product modal"
	                >
	                    x
	                </button>

		                <div class="grid gap-0 lg:grid-cols-[320px_minmax(0,1fr)]">
		                    <div class="relative flex items-center justify-center bg-gradient-to-br from-[#f6e7f5] via-[#e7d4ef] to-[#d7c0e8] p-6 md:p-8">
		                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(255,255,255,0.8),_transparent_52%)]"></div>
		                        <div class="absolute left-6 top-6 rounded-full border border-white/70 bg-white/75 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.22em] text-[#7a5a89] backdrop-blur">
		                            BookBerry Pick
		                        </div>

                        <div class="relative w-full max-w-[220px]">
                            <div class="absolute -inset-4 rounded-[2rem] bg-white/35 blur-2xl"></div>
                            <div class="relative overflow-hidden rounded-[1.7rem] border border-white/60 bg-white/40 p-3 shadow-[0_18px_45px_rgba(83,40,104,0.18)]">
                                <div class="rounded-[1.2rem] bg-gradient-to-br from-[#9b72bb] to-[#5f2d7a] p-3">
                                    <img
                                        src="{{ $product->image_url }}"
                                        alt="{{ $product->title }}"
                                        class="aspect-[2/3] w-full rounded-[0.9rem] object-cover shadow-lg"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="relative p-6 sm:p-8 lg:p-10">
                        <div class="mb-5 flex flex-wrap items-center gap-3 pr-12">
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold"
                                style="{{ $product->category === 'manga'
                                    ? 'background:#eef2ff; color:#4338ca;'
                                    : 'background:#fde7ef; color:#c53868;' }}">
                                {{ $product->category === 'manga' ? 'Manga' : 'Wattpad' }}
                            </span>

                            <span class="inline-flex items-center rounded-full border border-[#ead9ef] bg-white px-3 py-1 text-xs font-medium text-[#7f678c]">
                                SKU {{ str_pad($product->id, 6, '0', STR_PAD_LEFT) }}
                            </span>
	                        </div>
	
	                        <div class="max-w-2xl">
	                            <h2 class="text-3xl font-black leading-tight tracking-tight text-[#4d245f] sm:text-4xl">
	                                <span class="[display:-webkit-box] [-webkit-box-orient:vertical] [-webkit-line-clamp:2] overflow-hidden">
	                                    {{ $product->title }}
	                                </span>
	                            </h2>

                            <div class="mt-3 flex flex-wrap items-center gap-3">
                                <div class="flex items-center gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="h-4 w-4"
                                            fill="{{ $i <= round($product->rating) ? '#f5b301' : '#e7dcea' }}"
                                            viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>

                                <span class="text-sm font-medium text-[#866f90]">
                                    {{ number_format($product->rating, 1) }} rating
                                </span>

                                <span class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1 text-sm font-medium text-[#6f5a7d] shadow-sm">
                                    <span class="h-2.5 w-2.5 rounded-full" style="background: {{ $product->stockStatusColor }};"></span>
                                    {{ $product->stockStatus }}
                                </span>
                            </div>

                            <div class="mt-6 flex flex-wrap items-end gap-4">
                                <p class="text-4xl font-black tracking-tight text-[#eb4e7c] sm:text-5xl">
                                    PHP {{ number_format($product->price, 2) }}
                                </p>

                                @if($product->stock > 0)
                                    <p class="pb-1 text-sm font-medium text-[#867189]">
                                        {{ $product->stock }} {{ Str::plural('copy', $product->stock) }} ready to ship
                                    </p>
                                @else
                                    <p class="pb-1 text-sm font-medium text-[#d14f64]">
                                        Currently unavailable
                                    </p>
                                @endif
                            </div>

	                            @if($product->description)
	                                <p class="mt-5 max-w-2xl text-[15px] leading-7 text-[#6c5c75] [display:-webkit-box] [-webkit-box-orient:vertical] [-webkit-line-clamp:3] overflow-hidden">
	                                    {{ Str::limit(trim(str_replace("\n", ' ', $product->description)), 160) }}
	                                </p>
	                            @endif
	                        </div>

                        @if($product->stock > 0)
                            <div class="mt-8 rounded-[1.5rem] border border-[#f0e3f1] bg-white/85 p-5 shadow-[0_12px_30px_rgba(111,74,128,0.08)]">
                                <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#9c8aa4]">Quantity</p>
                                        <div class="mt-3 inline-flex items-center gap-3 rounded-full bg-[#f8f1f8] p-2 shadow-inner">
                                            <button
                                                wire:click="decrementQty"
                                                class="flex h-11 w-11 items-center justify-center rounded-full bg-white text-xl font-bold text-[#6f4e7f] shadow-sm transition hover:bg-[#f4ebf6] disabled:cursor-not-allowed disabled:opacity-40"
                                                {{ $quantity <= 1 ? 'disabled' : '' }}
                                            >
                                                -
                                            </button>
                                            <span class="min-w-[2rem] text-center text-xl font-bold text-[#452151]">
                                                {{ $quantity }}
                                            </span>
                                            <button
                                                wire:click="incrementQty"
                                                class="flex h-11 w-11 items-center justify-center rounded-full bg-white text-xl font-bold text-[#6f4e7f] shadow-sm transition hover:bg-[#f4ebf6] disabled:cursor-not-allowed disabled:opacity-40"
                                                {{ $quantity >= $product->stock ? 'disabled' : '' }}
                                            >
                                                +
                                            </button>
                                        </div>
                                    </div>

                                    <div class="sm:text-right">
                                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#9c8aa4]">Subtotal</p>
                                        <p class="mt-2 text-2xl font-black text-[#4f245f]">
                                            PHP {{ number_format($product->price * $quantity, 2) }}
                                        </p>
                                    </div>
                                </div>

	                                <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:items-center">
	                                    <button
	                                        type="button"
	                                        @click="close()"
	                                        class="flex w-full items-center justify-center rounded-[1.15rem] border border-[#eadcf0] bg-white px-6 py-4 text-base font-bold text-[#5a2a6e] shadow-sm transition hover:bg-[#fff8fd] sm:w-auto sm:px-7"
	                                    >
	                                        Close
	                                    </button>

	                                    @auth
	                                        <button
	                                            wire:click="addToCart"
	                                            wire:loading.attr="disabled"
	                                            wire:target="addToCart"
	                                            class="flex w-full flex-1 items-center justify-center rounded-[1.15rem] bg-gradient-to-r from-[#ef4f7f] to-[#db4672] px-6 py-4 text-base font-bold text-white shadow-[0_16px_32px_rgba(232,79,124,0.28)] transition hover:translate-y-[-1px] hover:shadow-[0_18px_34px_rgba(232,79,124,0.34)] disabled:opacity-60"
	                                        >
	                                            <span wire:loading.remove wire:target="addToCart">
	                                                {{ $addedToCart ? 'Added to Cart' : 'Add to Cart' }}
	                                            </span>
	                                            <span wire:loading wire:target="addToCart">
	                                                Adding...
	                                            </span>
	                                        </button>
	                                    @else
	                                        <a
	                                            href="{{ route('login') }}"
	                                            @click="unlockScroll()"
	                                            class="flex w-full flex-1 items-center justify-center rounded-[1.15rem] bg-gradient-to-r from-[#ef4f7f] to-[#db4672] px-6 py-4 text-base font-bold text-white shadow-[0_16px_32px_rgba(232,79,124,0.28)] transition hover:translate-y-[-1px] hover:shadow-[0_18px_34px_rgba(232,79,124,0.34)]"
	                                        >
	                                            Login to Buy
	                                        </a>
	                                    @endauth
	                                </div>

	                                @if($addedToCart)
	                                    <a
	                                        href="{{ route('cart') }}"
	                                        @click="unlockScroll()"
	                                        class="mt-3 flex w-full items-center justify-center rounded-[1.15rem] border border-[#eadcf0] bg-[#fff8fd] px-6 py-3 text-sm font-semibold text-[#5a2a6e] transition hover:bg-white"
	                                    >
	                                        View Cart
	                                    </a>
	                                @endif
                            </div>
                        @else
                            <div class="mt-8 rounded-[1.5rem] border border-red-100 bg-red-50 px-5 py-4">
                                <p class="text-sm font-semibold text-red-600">Out of Stock</p>
                                <p class="mt-1 text-sm text-red-500">This title is not available for purchase right now.</p>
                            </div>
                        @endif

	                    </div>
	                </div>
	            </div>
	        </div>
	        </div>
	    @endif
	</div>
