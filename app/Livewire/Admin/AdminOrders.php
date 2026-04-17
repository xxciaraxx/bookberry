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
    public string $decisionFilter = '';

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingDecisionFilter(): void { $this->resetPage(); }

    public function approveOrder(int $orderId): void
    {
        $user = Auth::user();
        abort_unless($user && $user->isAdmin(), 403);

        if (! Schema::hasColumn('orders', 'approved_at')) {
            $this->dispatch('notify', message: 'Missing approval columns. Run: php artisan migrate');
            return;
        }

        $order = Order::findOrFail($orderId);

        if ($order->status === 'cancelled') {
            $this->dispatch('notify', message: 'Order was cancelled by the customer.');
            return;
        }

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

        if ($order->status === 'cancelled') {
            $this->dispatch('notify', message: 'Order was cancelled by the customer.');
            return;
        }

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
        $ordersQuery = Order::with(['user', 'approvedBy', 'rejectedBy', 'cancelledBy'])
            ->when($this->search, fn($q) =>
                $q->whereHas('user', fn($q2) =>
                    $q2->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                )->orWhere('id', 'like', '%' . $this->search . '%')
            )
            ->latest();

        if ($this->decisionFilter === 'cancelled') {
            $ordersQuery->where('status', 'cancelled');
        } elseif (in_array($this->decisionFilter, ['pending', 'approved', 'rejected'], true)) {
            $ordersQuery->where('status', '!=', 'cancelled');

            if (Schema::hasColumn('orders', 'approval_status')) {
                $ordersQuery->where('approval_status', $this->decisionFilter);
            } elseif ($this->decisionFilter === 'approved' && Schema::hasColumn('orders', 'approved_at')) {
                $ordersQuery->whereNotNull('approved_at');
            } elseif ($this->decisionFilter === 'rejected' && Schema::hasColumn('orders', 'rejected_at')) {
                $ordersQuery->whereNotNull('rejected_at');
            } elseif ($this->decisionFilter === 'pending') {
                if (Schema::hasColumn('orders', 'approved_at')) {
                    $ordersQuery->whereNull('approved_at');
                }
                if (Schema::hasColumn('orders', 'rejected_at')) {
                    $ordersQuery->whereNull('rejected_at');
                }
            }
        }

        $orders = $ordersQuery->paginate(15);

        return view('livewire.admin.admin-orders', compact('orders'))
            ->layout('components.admin-layout', [
                'title'     => 'Orders - BookBerry Admin',
                'pageTitle' => 'Order Management',
            ]);
    }
}
