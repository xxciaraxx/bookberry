<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminDashboard extends Component
{
    public string $period = '30'; // days

    public function render()
    {
        $days = (int) $this->period;
        $since = now()->subDays($days);

        // â”€â”€ Key Metrics â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        $totalRevenue = Order::where('status', '!=', 'cancelled')
            ->where('created_at', '>=', $since)
            ->sum('total_amount');

        $totalOrders = Order::where('created_at', '>=', $since)->count();

        $newCustomers = User::where('is_admin', false)
            ->where('created_at', '>=', $since)
            ->count();

        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();

        $pendingOrdersQuery = Order::query()->where('status', '!=', 'cancelled');
        if (Schema::hasColumn('orders', 'approval_status')) {
            $pendingOrdersQuery->where('approval_status', 'pending');
        } elseif (Schema::hasColumn('orders', 'approved_at') && Schema::hasColumn('orders', 'rejected_at')) {
            $pendingOrdersQuery->whereNull('approved_at')->whereNull('rejected_at');
        }
        $pendingOrders = $pendingOrdersQuery->count();

        // â”€â”€ Recent Orders â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        $recentOrders = Order::with(['user', 'approvedBy', 'rejectedBy', 'cancelledBy'])
            ->latest()
            ->take(8)
            ->get();

        // â”€â”€ Top Selling Products â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.title',
                'products.category',
                'products.price',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.quantity * order_items.price) as revenue')
            )
            ->groupBy('products.id', 'products.title', 'products.category', 'products.price')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // â”€â”€ Orders by Status â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        if (Schema::hasColumn('orders', 'approval_status')) {
            $ordersByStatus = Order::selectRaw("CASE WHEN status = 'cancelled' THEN 'cancelled' ELSE approval_status END as decision, COUNT(*) as count")
                ->groupBy('decision')
                ->pluck('count', 'decision');
        } elseif (Schema::hasColumn('orders', 'approved_at') && Schema::hasColumn('orders', 'rejected_at')) {
            $ordersByStatus = Order::selectRaw("CASE WHEN status = 'cancelled' THEN 'cancelled' WHEN approved_at IS NOT NULL THEN 'approved' WHEN rejected_at IS NOT NULL THEN 'rejected' ELSE 'pending' END as decision, COUNT(*) as count")
                ->groupBy('decision')
                ->pluck('count', 'decision');
        } else {
            $ordersByStatus = Order::selectRaw("CASE WHEN status = 'cancelled' THEN 'cancelled' ELSE 'pending' END as decision, COUNT(*) as count")
                ->groupBy('decision')
                ->pluck('count', 'decision');
        }

        // â”€â”€ Revenue by Category â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        $revenueByCategory = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', '!=', 'cancelled')
            ->where('orders.created_at', '>=', $since)
            ->select(
                'products.category',
                DB::raw('SUM(order_items.quantity * order_items.price) as revenue'),
                DB::raw('SUM(order_items.quantity) as units')
            )
            ->groupBy('products.category')
            ->get()
            ->keyBy('category');

        // â”€â”€ Daily Revenue (last 7 days) â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        $dailyRevenue = Order::where('status', '!=', 'cancelled')
            ->where('created_at', '>=', now()->subDays(7))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as revenue'),
                DB::raw('COUNT(*) as orders')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // â”€â”€ Recent Customers â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        $recentCustomers = User::where('is_admin', false)
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.admin.admin-dashboard', compact(
            'totalRevenue', 'totalOrders', 'newCustomers', 'totalProducts',
            'activeProducts', 'pendingOrders', 'recentOrders', 'topProducts',
            'ordersByStatus', 'revenueByCategory', 'dailyRevenue', 'recentCustomers'
        ))->layout('components.admin-layout', [
            'title' => 'Dashboard - BookBerry Admin',
            'pageTitle' => 'Dashboard Overview',
        ]);
    }
}
