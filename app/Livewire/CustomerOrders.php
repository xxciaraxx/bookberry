<?php

namespace App\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerOrders extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filter = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilter(): void
    {
        $this->resetPage();
    }

    public function cancelOrder(int $orderId): void
    {
        $user = Auth::user();
        abort_unless($user, 403);

        $order = Order::where('user_id', $user->id)->findOrFail($orderId);

        if ($order->status === 'cancelled') {
            return;
        }

        $approvalStatus = $order->approval_status
            ?? ($order->approved_at ? 'approved' : ($order->rejected_at ? 'rejected' : 'pending'));

        if ($approvalStatus === 'approved') {
            $this->dispatch('notify', message: 'Approved orders can no longer be cancelled.');
            return;
        }

        $updates = ['status' => 'cancelled'];

        if (Schema::hasColumn('orders', 'cancelled_at')) {
            $updates['cancelled_at'] = now();
        }

        if (Schema::hasColumn('orders', 'cancelled_by')) {
            $updates['cancelled_by'] = $user->id;
        }

        $order->update($updates);
        $this->dispatch('notify', message: 'Order cancelled.');
    }

    public function render()
    {
        $ordersQuery = Order::with(['items.product'])
            ->where('user_id', Auth::id())
            ->when($this->search, fn($q) => $q->where('id', 'like', '%' . $this->search . '%'))
            ->latest();

        if ($this->filter === 'cancelled') {
            $ordersQuery->where('status', 'cancelled');
        } elseif (in_array($this->filter, ['pending', 'approved', 'rejected'], true)) {
            $ordersQuery->where('status', '!=', 'cancelled');

            if (Schema::hasColumn('orders', 'approval_status')) {
                $ordersQuery->where('approval_status', $this->filter);
            } elseif ($this->filter === 'approved' && Schema::hasColumn('orders', 'approved_at')) {
                $ordersQuery->whereNotNull('approved_at');
            } elseif ($this->filter === 'rejected' && Schema::hasColumn('orders', 'rejected_at')) {
                $ordersQuery->whereNotNull('rejected_at');
            } elseif ($this->filter === 'pending') {
                if (Schema::hasColumn('orders', 'approved_at')) {
                    $ordersQuery->whereNull('approved_at');
                }
                if (Schema::hasColumn('orders', 'rejected_at')) {
                    $ordersQuery->whereNull('rejected_at');
                }
            }
        }

        $orders = $ordersQuery->paginate(10);

        return view('livewire.customer-orders', compact('orders'))
            ->layout('components.layout', ['title' => 'My Orders - BookBerry']);
    }
}

