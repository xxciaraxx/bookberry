<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class AdminOrders extends Component
{
    use WithPagination;

    public string $search      = '';
    public string $statusFilter = '';

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingStatusFilter(): void { $this->resetPage(); }

    public function updateStatus(int $orderId, string $status): void
    {
        Order::findOrFail($orderId)->update(['status' => $status]);
        $this->dispatch('notify', message: 'Order status updated!');
    }

    public function approveOrder(int $orderId): void
    {
        $user = Auth::user();
        abort_unless($user && $user->isAdmin(), 403);

        if (! Schema::hasColumn('orders', 'approved_at')) {
            $this->dispatch('notify', message: 'Missing approval columns. Run: php artisan migrate');
            return;
        }

        $order = Order::findOrFail($orderId);

        if ($order->approved_at) {
            return;
        }

        $updates = ['approved_at' => now()];

        if (Schema::hasColumn('orders', 'approved_by')) {
            $updates['approved_by'] = $user->id;
        }

        if (Schema::hasColumn('orders', 'approval_status')) {
            $updates['approval_status'] = 'approved';
        }

        if (Schema::hasColumn('orders', 'rejected_at')) {
            $updates['rejected_at'] = null;
        }

        if (Schema::hasColumn('orders', 'rejected_by')) {
            $updates['rejected_by'] = null;
        }

        $order->update($updates);

        $this->dispatch('notify', message: 'Order approved!');
    }

    public function rejectOrder(int $orderId): void
    {
        $user = Auth::user();
        abort_unless($user && $user->isAdmin(), 403);

        if (! Schema::hasColumn('orders', 'rejected_at')) {
            $this->dispatch('notify', message: 'Missing rejection columns. Run: php artisan migrate');
            return;
        }

        $order = Order::findOrFail($orderId);

        if ($order->rejected_at) {
            return;
        }

        $updates = ['rejected_at' => now()];

        if (Schema::hasColumn('orders', 'rejected_by')) {
            $updates['rejected_by'] = $user->id;
        }

        if (Schema::hasColumn('orders', 'approval_status')) {
            $updates['approval_status'] = 'rejected';
        }

        if (Schema::hasColumn('orders', 'approved_at')) {
            $updates['approved_at'] = null;
        }

        if (Schema::hasColumn('orders', 'approved_by')) {
            $updates['approved_by'] = null;
        }

        $order->update($updates);

        $this->dispatch('notify', message: 'Order rejected!');
    }

    public function render()
    {
        $orders = Order::with(['user', 'approvedBy', 'rejectedBy'])
            ->when($this->search, fn($q) =>
                $q->whereHas('user', fn($q2) =>
                    $q2->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                )->orWhere('id', 'like', '%' . $this->search . '%')
            )
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->latest()
            ->paginate(15);

        return view('livewire.admin.admin-orders', compact('orders'))
            ->layout('components.admin-layout', [
                'title'     => 'Orders - BookBerry Admin',
                'pageTitle' => 'Order Management',
            ]);
    }
}
