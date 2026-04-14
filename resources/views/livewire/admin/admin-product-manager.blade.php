<div>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold" style="color: #5A2A6E;">Product Management</h1>
                <p class="text-sm text-gray-400 mt-0.5">Add, edit, and manage your BookBerry catalog</p>
            </div>
            <button
                wire:click="openCreate"
                style="background: #E94E77;"
                class="text-white font-semibold px-5 py-2.5 rounded-xl hover:opacity-90 transition flex items-center gap-2 text-sm self-start"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Product
            </button>
        </div>

        <div class="relative mb-5 max-w-sm">
            <svg
                class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                />
            </svg>
            <input
                wire:model.live.debounce.400ms="search"
                type="text"
                placeholder="Search products..."
                class="w-full pl-10 pr-4 py-2.5 border border-purple-200 rounded-xl text-sm outline-none focus:border-purple-400 transition"
            />
        </div>

        <div class="bg-white rounded-2xl border border-purple-100 overflow-hidden shadow-sm">
            <table class="w-full text-sm">
                <thead style="background: #F9F3FF;">
                    <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="px-5 py-3.5">Cover</th>
                        <th class="px-5 py-3.5">Title</th>
                        <th class="px-5 py-3.5">Category</th>
                        <th class="px-5 py-3.5">Price</th>
                        <th class="px-5 py-3.5">Rating</th>
                        <th class="px-5 py-3.5">Stock</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-purple-50">
                    @forelse($products as $product)
                        <tr class="hover:bg-purple-50/30 transition">
                            <td class="px-5 py-3">
                                <img src="{{ $product->image_url }}" alt="{{ $product->title }}" class="w-10 h-14 object-cover rounded-lg shadow-sm" />
                            </td>
                            <td class="px-5 py-3">
                                <p class="font-semibold text-gray-800 max-w-[200px] truncate">{{ $product->title }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">ID: #{{ $product->id }}</p>
                            </td>
                            <td class="px-5 py-3">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold"
                                    style="{{ $product->category === 'manga' ? 'background:#EEF2FF; color:#4338CA;' : 'background:#FDF2F8; color:#9D174D;' }}"
                                >
                                    {{ $product->category === 'manga' ? 'Manga' : 'Wattpad' }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <span style="color: #E94E77;" class="font-bold">P{{ number_format($product->price, 2) }}</span>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-1">
                                    <span class="text-yellow-400">*</span>
                                    <span class="text-sm font-medium">{{ number_format($product->rating, 1) }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3">
                                <div class="font-medium" style="color: {{ $product->stock_status_color }};">
                                    {{ $product->stock }}
                                </div>
                                <p class="text-xs text-gray-400">{{ $product->stock_status }}</p>
                            </td>
                            <td class="px-5 py-3">
                                <button
                                    wire:click="toggleActive({{ $product->id }})"
                                    class="px-3 py-1 rounded-full text-xs font-semibold transition"
                                    style="{{ $product->is_active ? 'background:#DCFCE7; color:#166534;' : 'background:#FEE2E2; color:#991B1B;' }}"
                                >
                                    {{ $product->is_active ? 'Active' : 'Hidden' }}
                                </button>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2">
                                    <button
                                        wire:click="openEdit({{ $product->id }})"
                                        class="px-3 py-1.5 text-xs rounded-lg border border-purple-200 text-purple-700 hover:bg-purple-50 transition font-medium"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        wire:click="delete({{ $product->id }})"
                                        wire:confirm="Are you sure you want to delete '{{ $product->title }}'? This cannot be undone."
                                        class="px-3 py-1.5 text-xs rounded-lg border border-red-200 text-red-500 hover:bg-red-50 transition font-medium"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-16 text-gray-400">
                                <p class="text-4xl mb-2">No products found.</p>
                                <button wire:click="openCreate" style="color: #E94E77;" class="text-sm mt-2 hover:underline">
                                    Add your first product
                                </button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($products->hasPages())
                <div class="px-5 py-4 border-t border-purple-50">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>

    @if($showModal)
        <div class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4" x-data x-on:keydown.escape.window="$wire.set('showModal', false)">
            <div class="bg-white rounded-2xl w-full max-w-lg shadow-2xl max-h-screen overflow-y-auto">
                <div class="flex items-center justify-between p-6 border-b border-purple-100">
                    <h2 class="text-lg font-bold" style="color: #5A2A6E;">
                        {{ $editingId ? 'Edit Product' : 'Add New Product' }}
                    </h2>
                    <button
                        wire:click="$set('showModal', false)"
                        class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 transition text-lg leading-none"
                    >
                        x
                    </button>
                </div>

                <div class="p-6 space-y-4">
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1">Book Title *</label>
                        <input
                            wire:model="title"
                            type="text"
                            placeholder="Enter book title..."
                            class="w-full border border-purple-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-purple-400 transition"
                        />
                        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1">Category *</label>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="flex items-center gap-2 p-3 rounded-xl border-2 cursor-pointer transition {{ $category === 'wattpad' ? 'border-pink-400 bg-pink-50' : 'border-gray-100' }}">
                                <input type="radio" wire:model.live="category" value="wattpad" class="accent-pink-600" />
                                <span class="text-sm font-medium text-gray-700">Wattpad</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 rounded-xl border-2 cursor-pointer transition {{ $category === 'manga' ? 'border-blue-400 bg-blue-50' : 'border-gray-100' }}">
                                <input type="radio" wire:model.live="category" value="manga" class="accent-blue-600" />
                                <span class="text-sm font-medium text-gray-700">Manga</span>
                            </label>
                        </div>
                        @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1">Price (P) *</label>
                            <input
                                wire:model="price"
                                type="number"
                                step="0.01"
                                min="0"
                                placeholder="0.00"
                                class="w-full border border-purple-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-purple-400 transition"
                            />
                            @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1">Rating (0-5)</label>
                            <input
                                wire:model="rating"
                                type="number"
                                step="0.1"
                                min="0"
                                max="5"
                                placeholder="4.5"
                                class="w-full border border-purple-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-purple-400 transition"
                            />
                            @error('rating') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1">Stock *</label>
                            <input
                                wire:model="stock"
                                type="number"
                                min="0"
                                placeholder="10"
                                class="w-full border border-purple-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-purple-400 transition"
                            />
                            @error('stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1">Description</label>
                        <textarea
                            wire:model="description"
                            rows="3"
                            placeholder="Brief description of the book..."
                            class="w-full border border-purple-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-purple-400 transition resize-none"
                        ></textarea>
                        @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1">
                            Cover Image {{ $editingId ? '(leave empty to keep current)' : '' }}
                        </label>
                        <div class="border-2 border-dashed border-purple-200 rounded-xl p-4 text-center hover:border-purple-400 transition">
                            <input wire:model="image" type="file" accept="image/*" class="w-full text-sm text-gray-500" />
                            <p class="text-xs text-gray-400 mt-1">PNG, JPG, WEBP - Max 2MB</p>
                        </div>
                        @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                        @if($image)
                            <div class="mt-2 flex items-center gap-2">
                                <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="w-12 h-16 object-cover rounded-lg" />
                                <span class="text-xs text-gray-400">Preview</span>
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center gap-3">
                        <label class="text-sm font-medium text-gray-700">Active (visible to customers)</label>
                        <input wire:model="is_active" type="checkbox" class="w-4 h-4 accent-purple-700 cursor-pointer" />
                    </div>
                </div>

                <div class="flex gap-3 p-6 border-t border-purple-100">
                    <button
                        wire:click="save"
                        wire:loading.attr="disabled"
                        style="background: #5A2A6E;"
                        class="flex-1 text-white font-semibold py-3 rounded-xl hover:opacity-90 transition disabled:opacity-60 text-sm"
                    >
                        <span wire:loading.remove>{{ $editingId ? 'Save Changes' : 'Create Product' }}</span>
                        <span wire:loading>Saving...</span>
                    </button>
                    <button
                        wire:click="$set('showModal', false)"
                        class="flex-1 border-2 border-purple-200 text-purple-700 font-semibold py-3 rounded-xl hover:bg-purple-50 transition text-sm"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
