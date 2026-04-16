<div>
<div class="flex items-center justify-between mb-5">
    <div class="relative max-w-sm flex-1">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input wire:model.live.debounce.400ms="search" type="text"
            placeholder="Search by name or email..."
            class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm
                outline-none focus:border-purple-400 transition bg-white" />
    </div>
    <span class="text-sm text-gray-500 ml-4">
        <strong style="color:#5A2A6E;">{{ $customers->total() }}</strong> customers
    </span>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr class="text-xs text-gray-500 uppercase tracking-wide">
                <th class="px-5 py-3 text-left font-semibold">Customer</th>
                <th class="px-5 py-3 text-left font-semibold">Email</th>
                <th class="px-5 py-3 text-left font-semibold">Orders</th>
                <th class="px-5 py-3 text-left font-semibold">Total Spent</th>
                <th class="px-5 py-3 text-left font-semibold">Joined</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($customers as $customer)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <div style="background: #F3EDF7; color: #5A2A6E;"
                                class="w-9 h-9 rounded-full flex items-center justify-center
                                    text-sm font-bold shrink-0">
                                {{ strtoupper(substr($customer->name, 0, 1)) }}
                            </div>
                            <span class="font-semibold text-gray-700">{{ $customer->name }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-gray-500 text-sm">{{ $customer->email }}</td>
                    <td class="px-5 py-3">
                        <span class="font-semibold text-gray-700">{{ $customer->orders_count }}</span>
                        <span class="text-xs text-gray-400 ml-1">orders</span>
                    </td>
                    <td class="px-5 py-3 font-bold text-sm" style="color: #E94E77;">
                        ₱{{ number_format($customer->orders_sum_total_amount ?? 0, 2) }}
                    </td>
                    <td class="px-5 py-3 text-xs text-gray-400">
                        {{ $customer->created_at->format('M d, Y') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-16 text-gray-400">
                        <p class="text-4xl mb-2">👥</p>
                        <p class="text-sm">No customers yet.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @if($customers->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $customers->links() }}
        </div>
	    @endif
	</div>
</div>
