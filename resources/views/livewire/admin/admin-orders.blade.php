<div>
	{{-- Filters --}}
	<div class="flex flex-col sm:flex-row gap-3 mb-5">
    <div class="relative flex-1 max-w-sm">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input wire:model.live.debounce.400ms="search" type="text"
            placeholder="Search by customer or order #..."
            class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm
                outline-none focus:border-purple-400 transition bg-white" />
    </div>
    <select wire:model.live="statusFilter"
        class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm outline-none bg-white">
        <option value="">All Statuses</option>
        <option value="pending">Pending</option>
        <option value="processing">Processing</option>
        <option value="completed">Completed</option>
        <option value="cancelled">Cancelled</option>
    </select>
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
	            <tr class="text-xs text-gray-500 uppercase tracking-wide">
	                <th class="px-5 py-3 text-left font-semibold">Order #</th>
	                <th class="px-5 py-3 text-left font-semibold">Customer</th>
	                <th class="px-5 py-3 text-left font-semibold">Amount</th>
	                <th class="px-5 py-3 text-left font-semibold">Status</th>
	                <th class="px-5 py-3 text-left font-semibold">Address</th>
	                <th class="px-5 py-3 text-left font-semibold">Date</th>
	                <th class="px-5 py-3 text-left font-semibold">Approval</th>
                <th class="px-5 py-3 text-left font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($orders as $order)
                @php
                    $approvalStatus = $order->approval_status
                        ?? ($order->approved_at ? 'approved' : ($order->rejected_at ? 'rejected' : 'pending'));
                @endphp
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-5 py-3 font-mono font-semibold text-gray-700 text-xs">
                        #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                    </td>
                    <td class="px-5 py-3">
                        <p class="font-semibold text-sm text-gray-700">{{ $order->user->name }}</p>
                        <p class="text-xs text-gray-400">{{ $order->user->email }}</p>
                    </td>
                    <td class="px-5 py-3 font-bold text-sm" style="color: #E94E77;">
                        ₱{{ number_format($order->total_amount, 2) }}
                    </td>
                    <td class="px-5 py-3">
                        @php
                            $sc = match($order->status) {
                                'pending'    => 'background:#FEF3C7;color:#92400E;',
                                'processing' => 'background:#EFF6FF;color:#1E40AF;',
                                'completed'  => 'background:#F0FDF4;color:#166534;',
                                'cancelled'  => 'background:#FEF2F2;color:#991B1B;',
                                default      => 'background:#F3F4F6;color:#374151;',
                            };
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold" style="{{ $sc }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-xs text-gray-500 max-w-[160px] truncate">
                        {{ $order->shipping_address ?? '—' }}
                    </td>
	                    <td class="px-5 py-3 text-xs text-gray-400">
	                        {{ $order->created_at->format('M d, Y') }}<br>
	                        <span class="text-gray-300">{{ $order->created_at->format('h:i A') }}</span>
	                    </td>
                    <td class="px-5 py-3">
                        @if($approvalStatus === 'approved')
                            <span class="text-xs font-semibold bg-green-50 text-green-700 px-2 py-0.5 rounded-full">
                                Approved
                            </span>
                            <div class="text-[10px] text-gray-400 mt-1 leading-tight">
                                <div>{{ $order->approved_at->format('M d, Y h:i A') }}</div>
                                @if($order->approvedBy)
                                    <div>by {{ $order->approvedBy->name }}</div>
                                @endif
                            </div>
                        @elseif($approvalStatus === 'rejected')
                            <span class="text-xs font-semibold bg-red-50 text-red-700 px-2 py-0.5 rounded-full">
                                Rejected
                            </span>
                            @if($order->rejected_at)
                                <div class="text-[10px] text-gray-400 mt-1 leading-tight">
                                    <div>{{ $order->rejected_at->format('M d, Y h:i A') }}</div>
                                    @if($order->rejectedBy)
                                        <div>by {{ $order->rejectedBy->name }}</div>
                                    @endif
                                </div>
                            @endif
                        @else
                            <span class="text-xs font-semibold bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">
                                Not approved
                            </span>
                        @endif
                    </td>
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2">
                            @if($approvalStatus === 'pending')
                                <button type="button" wire:click="approveOrder({{ $order->id }})"
                                    class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-purple-600 text-white hover:bg-purple-700 transition"
                                    wire:loading.attr="disabled">
                                    Approve
                                </button>
                                <button type="button" wire:click="rejectOrder({{ $order->id }})"
                                    class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-red-600 text-white hover:bg-red-700 transition"
                                    wire:loading.attr="disabled">
                                    Reject
                                </button>
                            @elseif($approvalStatus === 'approved')
                                <span class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-green-50 text-green-700">
                                    Approved
                                </span>
                            @else
                                <span class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-red-50 text-red-700">
                                    Rejected
                                </span>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
	                    <td colspan="8" class="text-center py-16 text-gray-400">
	                        <p class="text-4xl mb-2">📭</p>
	                        <p class="text-sm">No orders found.</p>
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
