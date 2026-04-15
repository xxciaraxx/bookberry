        {{-- Period selector --}}
<div>
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening') }}, {{ explode(' ', auth()->user()->name)[0] }}! ðŸ‘‹</h2>
                <p class="text-sm text-gray-500 mt-0.5">Here's what's happening with your store.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-500">Showing:</span>
                <select wire:model.live="period"
                    class="border border-gray-200 rounded-xl px-3 py-2 text-sm outline-none bg-white">
                    <option value="7">Last 7 days</option>
                    <option value="30" selected>Last 30 days</option>
                    <option value="90">Last 90 days</option>
                    <option value="365">This year</option>
                </select>
            </div>
        </div>
        {{-- ===== STAT CARDS ===== --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

            {{-- Total Revenue --}}
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                        style="background: #F3EDF7;">
                        <svg class="w-5 h-5" style="color:#5A2A6E;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-xs text-green-600 font-semibold bg-green-50 px-2 py-0.5 rounded-full">Revenue</span>
                </div>
                <p class="text-2xl font-bold text-gray-800">â‚±{{ number_format($totalRevenue, 0) }}</p>
                <p class="text-xs text-gray-400 mt-1">Last {{ $period }} days</p>
            </div>

            {{-- Total Orders --}}
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                        style="background: #FDF2F8;">
                        <svg class="w-5 h-5" style="color:#E94E77;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    @if($pendingOrders > 0)
                        <span class="text-xs text-red-600 font-semibold bg-red-50 px-2 py-0.5 rounded-full">
                            {{ $pendingOrders }} pending
                        </span>
                    @endif
                </div>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($totalOrders) }}</p>
                <p class="text-xs text-gray-400 mt-1">Total orders</p>
            </div>

            {{-- New Customers --}}
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-blue-50">
                        <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span class="text-xs text-blue-600 font-semibold bg-blue-50 px-2 py-0.5 rounded-full">Customers</span>
                </div>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($newCustomers) }}</p>
                <p class="text-xs text-gray-400 mt-1">New this period</p>
            </div>

            {{-- Products --}}
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-amber-50">
                        <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <span class="text-xs text-amber-600 font-semibold bg-amber-50 px-2 py-0.5 rounded-full">
                        {{ $activeProducts }} active
                    </span>
                </div>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($totalProducts) }}</p>
                <p class="text-xs text-gray-400 mt-1">Total products</p>
            </div>
        </div>

        {{-- ===== MIDDLE ROW ===== --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">

            {{-- Category Revenue --}}
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <h3 class="font-semibold text-gray-700 mb-4 text-sm">Revenue by Category</h3>

                @foreach(['wattpad' => ['ðŸ“š', '#9D174D', '#FDF2F8'], 'manga' => ['ðŸŽŒ', '#4338CA', '#EEF2FF']] as $cat => [$icon, $color, $bg])
                    @php
                        $data = $revenueByCategory[$cat] ?? null;
                        $rev = $data?->revenue ?? 0;
                        $units = $data?->units ?? 0;
                        $totalRev = $revenueByCategory->sum('revenue') ?: 1;
                        $pct = round(($rev / $totalRev) * 100);
                    @endphp
                    <div class="mb-4 last:mb-0">
                        <div class="flex justify-between items-center mb-1.5">
                            <span class="text-sm font-medium text-gray-700">{{ $icon }} {{ ucfirst($cat) }}</span>
                            <div class="text-right">
                                <span class="text-sm font-bold text-gray-800">â‚±{{ number_format($rev, 0) }}</span>
                                <span class="text-xs text-gray-400 ml-1">({{ $units }} sold)</span>
                            </div>
                        </div>
                        <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-500"
                                style="width: {{ $pct }}%; background: {{ $color }};"></div>
                        </div>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $pct }}% of revenue</p>
                    </div>
                @endforeach

                <div class="border-t border-gray-100 pt-3 mt-3 flex justify-between text-sm">
                    <span class="text-gray-500 font-medium">Total</span>
                    <span class="font-bold text-gray-800">â‚±{{ number_format($revenueByCategory->sum('revenue'), 0) }}</span>
                </div>
            </div>

            {{-- Order Status Breakdown --}}
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <h3 class="font-semibold text-gray-700 mb-4 text-sm">Orders by Status</h3>

                @php
                    $statusConfig = [
                        'pending'    => ['ðŸŸ¡', '#D97706', '#FEF3C7', 'Pending'],
                        'processing' => ['ðŸ”µ', '#2563EB', '#EFF6FF', 'Processing'],
                        'completed'  => ['ðŸŸ¢', '#16A34A', '#F0FDF4', 'Completed'],
                        'cancelled'  => ['ðŸ”´', '#DC2626', '#FEF2F2', 'Cancelled'],
                    ];
                    $grandTotal = $ordersByStatus->sum() ?: 1;
                @endphp

                <div class="space-y-3">
                    @foreach($statusConfig as $status => [$dot, $color, $bg, $label])
                        @php $count = $ordersByStatus[$status] ?? 0; $pct = round(($count / $grandTotal) * 100); @endphp
                        <div class="flex items-center gap-3">
                            <div class="w-2.5 h-2.5 rounded-full shrink-0" style="background: {{ $color }};"></div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-sm text-gray-700">{{ $label }}</span>
                                    <span class="text-sm font-bold text-gray-800">{{ $count }}</span>
                                </div>
                                <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full" style="width: {{ $pct }}%; background: {{ $color }};"></div>
                                </div>
                            </div>
                            <span class="text-xs text-gray-400 w-8 text-right">{{ $pct }}%</span>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-gray-100 pt-3 mt-3 flex justify-between text-sm">
                    <span class="text-gray-500 font-medium">Total Orders</span>
                    <span class="font-bold text-gray-800">{{ $ordersByStatus->sum() }}</span>
                </div>
            </div>

            {{-- Daily Revenue (last 7 days) --}}
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <h3 class="font-semibold text-gray-700 mb-4 text-sm">Daily Revenue (7 days)</h3>

                @if($dailyRevenue->isEmpty())
                    <div class="text-center py-8 text-gray-400">
                        <p class="text-3xl mb-2">ðŸ“Š</p>
                        <p class="text-xs">No revenue data yet</p>
                    </div>
                @else
                    @php $maxRev = $dailyRevenue->max('revenue') ?: 1; @endphp
                    <div class="flex items-end gap-1.5 h-24">
                        @foreach($dailyRevenue as $day)
                            @php $h = max(4, round(($day->revenue / $maxRev) * 96)); @endphp
                            <div class="flex-1 flex flex-col items-center gap-1 group">
                                <div class="relative w-full">
                                    <div class="w-full rounded-t-md transition-all hover:opacity-80 cursor-pointer"
                                        style="height: {{ $h }}px; background: #5A2A6E;"
                                        title="{{ $day->date }}: â‚±{{ number_format($day->revenue, 2) }}">
                                    </div>
                                    <div class="absolute -top-7 left-1/2 -translate-x-1/2 bg-gray-800 text-white
                                        text-xs rounded px-1.5 py-0.5 opacity-0 group-hover:opacity-100
                                        transition whitespace-nowrap pointer-events-none">
                                        â‚±{{ number_format($day->revenue, 0) }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex gap-1.5 mt-2">
                        @foreach($dailyRevenue as $day)
                            <div class="flex-1 text-center">
                                <p class="text-xs text-gray-400">
                                    {{ \Carbon\Carbon::parse($day->date)->format('D') }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- ===== BOTTOM ROW ===== --}}
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-4">

            {{-- Recent Orders --}}
            <div class="lg:col-span-3 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-700 text-sm">Recent Orders</h3>
                    <a href="{{ route('admin.orders') }}" style="color: #E94E77;"
                        class="text-xs font-medium hover:underline">View all â†’</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-xs text-gray-400 uppercase tracking-wide bg-gray-50">
                                <th class="px-5 py-2.5 text-left font-semibold">Order</th>
                                <th class="px-5 py-2.5 text-left font-semibold">Customer</th>
                                <th class="px-5 py-2.5 text-left font-semibold">Amount</th>
                                <th class="px-5 py-2.5 text-left font-semibold">Status</th>
                                <th class="px-5 py-2.5 text-left font-semibold">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($recentOrders as $order)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="px-5 py-3 font-mono font-semibold text-gray-700 text-xs">
                                        #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-5 py-3">
                                        <div class="flex items-center gap-2">
                                            <div style="background: #F3EDF7; color: #5A2A6E;"
                                                class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold shrink-0">
                                                {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                            </div>
                                            <span class="text-sm text-gray-700 truncate max-w-[120px]">
                                                {{ $order->user->name }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3 font-semibold" style="color: #E94E77;">
                                        â‚±{{ number_format($order->total_amount, 2) }}
                                    </td>
                                    <td class="px-5 py-3">
                                        @php
                                            $sc = match($order->status) {
                                                'pending'    => 'background:#FEF3C7; color:#92400E;',
                                                'processing' => 'background:#EFF6FF; color:#1E40AF;',
                                                'completed'  => 'background:#F0FDF4; color:#166534;',
                                                'cancelled'  => 'background:#FEF2F2; color:#991B1B;',
                                                default      => 'background:#F3F4F6; color:#374151;',
                                            };
                                        @endphp
                                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold" style="{{ $sc }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3 text-xs text-gray-400">
                                        {{ $order->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-10 text-gray-400">
                                        No orders yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Right column: top products + recent customers --}}
            <div class="lg:col-span-2 space-y-4">

                {{-- Top Products --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-700 text-sm">Top Products</h3>
                        <a href="{{ route('admin.products') }}" style="color: #E94E77;"
                            class="text-xs font-medium hover:underline">Manage â†’</a>
                    </div>
                    <div class="space-y-3">
                        @forelse($topProducts as $i => $p)
                            <div class="flex items-center gap-3">
                                <span class="w-5 h-5 rounded-full text-xs font-bold flex items-center justify-center shrink-0"
                                    style="{{ $i === 0
                                        ? 'background:#FEF3C7; color:#92400E;'
                                        : 'background:#F3F4F6; color:#6B7280;' }}">
                                    {{ $i + 1 }}
                                </span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-gray-700 truncate">{{ $p->title }}</p>
                                    <p class="text-xs text-gray-400">{{ $p->total_sold }} sold</p>
                                </div>
                                <span class="text-xs font-bold shrink-0" style="color: #E94E77;">
                                    â‚±{{ number_format($p->revenue, 0) }}
                                </span>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 text-center py-4">No sales data yet.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Recent Customers --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-700 text-sm">Recent Customers</h3>
                        <a href="{{ route('admin.customers') }}" style="color: #E94E77;"
                            class="text-xs font-medium hover:underline">View all â†’</a>
                    </div>
                    <div class="space-y-3">
                        @foreach($recentCustomers as $customer)
                            <div class="flex items-center gap-3">
                                <div style="background: #F3EDF7; color: #5A2A6E;"
                                    class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold shrink-0">
                                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-gray-700 truncate">{{ $customer->name }}</p>
                                    <p class="text-xs text-gray-400 truncate">{{ $customer->email }}</p>
                                </div>
                                <span class="text-xs text-gray-400 shrink-0">
                                    {{ $customer->created_at->diffForHumans(null, true) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
</div>
