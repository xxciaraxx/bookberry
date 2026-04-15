<div>
    {{-- ===== HERO ===== --}}
    <section style="background: linear-gradient(135deg, #5A2A6E 0%, #7B3F8E 60%, #9B5FAD 100%);"
        class="py-16 px-4">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center gap-10">
            <div class="text-white flex-1">
                <span style="background: rgba(203,160,217,0.25); color: #CBA0D9;"
                    class="text-xs font-semibold px-3 py-1 rounded-full inline-block mb-4">
                    Filipino and Japanese Reads
                </span>
                <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-4">
                    Your Cozy Corner<br>for Books and Manga
                </h1>
                <p style="color: #CBA0D9;" class="text-lg mb-8 leading-relaxed">
                    Discover Filipino Wattpad stories and Japanese manga, all in one place.
                </p>
	                <div class="flex flex-wrap gap-3">
	                    @guest
	                        <a href="{{ route('register') }}" style="background: #E94E77;"
	                            class="text-white font-semibold px-8 py-3 rounded-xl hover:opacity-90 transition text-sm inline-flex items-center gap-2">
	                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
	                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
	                            </svg>
	                            Get Started
	                        </a>
	                        <a href="{{ route('login') }}"
	                            class="text-white/80 font-semibold px-8 py-3 rounded-xl border border-white/30
	                                hover:bg-white/10 transition text-sm inline-flex items-center gap-2">
	                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
	                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.314 0-6 1.79-6 4v1h12v-1c0-2.21-2.686-4-6-4z"/>
	                            </svg>
	                            Sign In
	                        </a>
	                    @endguest
	                    @auth
	                        <a href="{{ route('products') }}" style="background: #E94E77;"
	                            class="text-white font-semibold px-8 py-3 rounded-xl hover:opacity-90 transition text-sm inline-flex items-center gap-2">
	                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
	                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
	                            </svg>
	                            Browse All Books
	                        </a>
	                    @endauth
	                </div>
                <div class="flex flex-wrap gap-2 mt-6">
                    <span class="text-xs px-3 py-1 rounded-full border border-white/20 text-white/70">Wattpad Books</span>
                    <span class="text-xs px-3 py-1 rounded-full border border-white/20 text-white/70">Japanese Manga</span>
                    <span class="text-xs px-3 py-1 rounded-full border border-white/20 text-white/70">Free Ship 500+</span>
                    <span class="text-xs px-3 py-1 rounded-full border border-white/20 text-white/70">Cash on Delivery</span>
                </div>
            </div>
	            <div class="hidden md:flex items-end gap-3 shrink-0">
	                @php $rotations = ['-5deg', '2deg', '-2deg', '4deg']; @endphp

	                @if(($heroProducts ?? collect())->count())
	                    @foreach($heroProducts as $idx => $hero)
	                        <div style="transform: rotate({{ $rotations[$idx] ?? '0deg' }});"
	                            class="w-20 h-28 rounded-xl shadow-2xl overflow-hidden bg-white/10 border border-white/20">
	                            <img
	                                src="{{ $hero->image_url }}"
	                                alt="{{ $hero->title }}"
	                                class="w-full h-full object-cover"
	                                loading="lazy"
	                            />
	                        </div>
	                    @endforeach
	                @else
	                    @foreach([
	                        ['Ang Probinsyano', '#E94E77', '-5deg'],
	                        ['One Piece', '#3B82F6', '2deg'],
	                        ['Mahal Kita Boss', '#059669', '-2deg'],
	                        ['Demon Slayer', '#7C3AED', '4deg'],
	                    ] as [$title, $color, $rotate])
	                        <div style="background: {{ $color }}; transform: rotate({{ $rotate }});"
	                            class="w-20 h-28 rounded-xl shadow-2xl flex items-center justify-center
	                                text-white text-xs font-semibold text-center p-2 leading-tight">
	                            {{ $title }}
	                        </div>
	                    @endforeach
	                @endif
	            </div>
	        </div>
	    </section>

    {{-- ===== CATEGORY BANNERS ===== --}}
    <section class="max-w-6xl mx-auto px-4 py-8">
	        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
	            <a href="{{ route('products') }}?category=wattpad"
	                class="relative overflow-hidden rounded-2xl p-6 flex items-center gap-4 hover:opacity-95 transition"
	                style="background: linear-gradient(135deg, #9D174D 0%, #E94E77 100%);">
		                <div class="text-5xl flex items-center gap-3">
		                    <span class="opacity-90" aria-hidden="true">📚</span>
		                </div>
	                <div class="text-white">
	                    <h3 class="font-bold text-xl">Wattpad Books</h3>
	                    <p class="text-sm text-white/80">Filipino romance and fiction stories</p>
	                </div>
	                <span class="ml-auto text-white/80">
	                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
	                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
	                    </svg>
	                </span>
	            </a>
	            <a href="{{ route('products') }}?category=manga"
	                class="relative overflow-hidden rounded-2xl p-6 flex items-center gap-4 hover:opacity-95 transition"
	                style="background: linear-gradient(135deg, #1e3a5f 0%, #3B82F6 100%);">
		                <div class="text-5xl flex items-center gap-3">
		                    <span class="opacity-90" aria-hidden="true">🇯🇵</span>
		                </div>
	                <div class="text-white">
	                    <h3 class="font-bold text-xl">Japanese Manga</h3>
	                    <p class="text-sm text-white/80">Action, romance, fantasy and more</p>
	                </div>
	                <span class="ml-auto text-white/80">
	                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
	                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
	                    </svg>
	                </span>
	            </a>
	        </div>
	    </section>

    {{-- ===== JUST FOR YOU ===== --}}
    <section class="max-w-6xl mx-auto px-4 pb-12">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold" style="color: #5A2A6E;">Just For You</h2>
            <a href="{{ route('products') }}" style="color: #E94E77;" class="text-sm hover:underline font-medium">
                See all
            </a>
        </div>

        <div class="flex gap-2 mb-6 flex-wrap">
            @foreach(['all' => 'All Books', 'wattpad' => 'Wattpad', 'manga' => 'Manga'] as $key => $label)
                <button wire:click="setTab('{{ $key }}')"
                    class="px-5 py-2 rounded-full text-sm font-medium border-2 transition"
                    style="{{ $activeTab === $key
                        ? 'background:#5A2A6E; color:white; border-color:#5A2A6E;'
                        : 'background:white; color:#5A2A6E; border-color:#CBA0D9;' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @forelse($products as $product)
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
                            {{ $product->category === 'manga' ? 'Manga' : 'Wattpad' }}
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
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center py-16 text-gray-400">
                    <p class="text-4xl mb-3">No books</p>
                    <p>No books available yet.</p>
                </div>
            @endforelse
        </div>

        @guest
            <div class="mt-10 text-center py-12 bg-white rounded-2xl border-2 border-dashed border-purple-200">
                <p class="text-2xl font-bold mb-2" style="color: #5A2A6E;">Ready to start reading?</p>
                <p class="text-gray-500 mb-6 text-sm">Create a free account to add books to your cart and checkout.</p>
                <div class="flex justify-center gap-3">
                    <a href="{{ route('register') }}" style="background: #E94E77;"
                        class="text-white font-semibold px-8 py-3 rounded-xl hover:opacity-90 transition">
                        Create Free Account
                    </a>
                    <a href="{{ route('login') }}"
                        class="text-purple-700 font-semibold px-8 py-3 rounded-xl border-2 border-purple-200
                            hover:bg-purple-50 transition">
                        Sign In
                    </a>
                </div>
            </div>
        @endguest
    </section>
</div>
