<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;

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

    public function render()
    {
        $orders = Order::with('user')
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
                'title'     => 'Orders — BookBerry Admin',
                'pageTitle' => 'Order Management',
            ]);
    }
}