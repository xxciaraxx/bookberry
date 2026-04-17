<div class="max-w-6xl mx-auto px-4 md:px-8 py-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">My Orders</h1>
            <p class="text-sm text-gray-500 mt-0.5">View your orders and cancel if it’s still pending.</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-2">
            <input wire:model.live.debounce.400ms="search" type="text" placeholder="Search by order #..."
                class="border border-gray-200 rounded-xl px-4 py-2 text-sm outline-none bg-white w-full sm:w-56" />

            <select wire:model.live="filter"
                class="border border-gray-200 rounded-xl px-4 py-2 text-sm outline-none bg-white w-full sm:w-44">
                <option value="">All</option>
                <option value="pending">For approval</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr class="text-xs text-gray-500 uppercase tracking-wide">
                    <th class="px-5 py-3 text-left font-semibold">Order #</th>
                    <th class="px-5 py-3 text-left font-semibold">Items</th>
                    <th class="px-5 py-3 text-left font-semibold">Total</th>
                    <th class="px-5 py-3 text-left font-semibold">Status</th>
                    <th class="px-5 py-3 text-left font-semibold">Placed</th>
                    <th class="px-5 py-3 text-left font-semibold">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($orders as $order)
                    @php
                        $approvalStatus = $order->approval_status
                            ?? ($order->approved_at ? 'approved' : ($order->rejected_at ? 'rejected' : 'pending'));
                        $decisionStatus = $order->status === 'cancelled' ? 'cancelled' : $approvalStatus;
                        $decisionLabel = match ($decisionStatus) {
                            'approved' => 'Approved',
                            'rejected' => 'Rejected',
                            'cancelled' => 'Cancelled',
                            default => 'For approval',
                        };
                        $decisionStyle = match ($decisionStatus) {
                            'approved' => 'background:#F0FDF4;color:#166534;',
                            'rejected' => 'background:#FEF2F2;color:#991B1B;',
                            'cancelled' => 'background:#F3F4F6;color:#374151;',
                            default => 'background:#FEF3C7;color:#92400E;',
                        };
                    @endphp
                    <tr class="hover:bg-gray-50/50 transition align-top">
                        <td class="px-5 py-3 font-mono font-semibold text-gray-700 text-xs">
                            #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-5 py-3">
                            <div class="text-xs text-gray-500">
                                {{ $order->items->sum('quantity') }} item(s)
                            </div>
                            <div class="text-[11px] text-gray-400 mt-1 leading-snug">
                                @foreach($order->items->take(2) as $item)
                                    <div class="truncate">
                                        {{ $item->quantity }}× {{ $item->product?->title ?? 'Item' }}
                                    </div>
                                @endforeach
                                @if($order->items->count() > 2)
                                    <div class="text-gray-400">+{{ $order->items->count() - 2 }} more</div>
                                @endif
                            </div>
                        </td>
                        <td class="px-5 py-3 font-bold text-sm" style="color: #E94E77;">
                            ₱{{ number_format($order->total_amount, 2) }}
                        </td>
                        <td class="px-5 py-3">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold" style="{{ $decisionStyle }}">
                                {{ $decisionLabel }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-xs text-gray-400">
                            {{ $order->created_at->format('M d, Y') }}<br>
                            <span class="text-gray-300">{{ $order->created_at->format('h:i A') }}</span>
                        </td>
                        <td class="px-5 py-3">
                            @if($decisionStatus === 'pending')
                                <button type="button"
                                    onclick="return confirm('Cancel this order?')"
                                    wire:click="cancelOrder({{ $order->id }})"
                                    class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-red-600 text-white hover:bg-red-700 transition"
                                    wire:loading.attr="disabled">
                                    Cancel
                                </button>
                            @elseif($decisionStatus === 'approved')
                                <span class="text-xs text-gray-400">Locked</span>
                            @else
                                <span class="text-xs text-gray-400">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-16 text-gray-400">
                            <p class="text-4xl mb-2">🧾</p>
                            <p class="text-sm">No orders yet.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($orders->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>

