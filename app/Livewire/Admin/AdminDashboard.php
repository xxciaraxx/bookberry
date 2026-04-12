<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;

class AdminDashboard extends Component
{
    public string $period = '30'; // days

    public function render()
    {
        $days = (int) $this->period;
        $since = now()->subDays($days);

        // ── Key Metrics ──────────────────────────────────────
        $totalRevenue = Order::where('status', '!=', 'cancelled')
            ->where('created_at', '>=', $since)
            ->sum('total_amount');

        $totalOrders = Order::where('created_at', '>=', $since)->count();

        $newCustomers = User::where('is_admin', false)
            ->where('created_at', '>=', $since)
            ->count();

        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();

        $pendingOrders = Order::where('status', 'pending')->count();

        // ── Recent Orders ─────────────────────────────────────
        $recentOrders = Order::with('user')
            ->latest()
            ->take(8)
            ->get();

        // ── Top Selling Products ──────────────────────────────
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

        // ── Orders by Status ──────────────────────────────────
        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        // ── Revenue by Category ───────────────────────────────
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

        // ── Daily Revenue (last 7 days) ───────────────────────
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

        // ── Recent Customers ──────────────────────────────────
        $recentCustomers = User::where('is_admin', false)
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.admin.admin-dashboard', compact(
            'totalRevenue', 'totalOrders', 'newCustomers', 'totalProducts',
            'activeProducts', 'pendingOrders', 'recentOrders', 'topProducts',
            'ordersByStatus', 'revenueByCategory', 'dailyRevenue', 'recentCustomers'
        ))->layout('components.admin-layout', ['title' => 'Dashboard — BookBerry Admin']);
    }
}