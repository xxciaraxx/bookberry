<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class AdminCustomers extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void { $this->resetPage(); }

    public function render()
    {
        $customers = User::where('is_admin', false)
            ->withCount('orders')
            ->withSum('orders', 'total_amount')
            ->when($this->search, fn($q) =>
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
            )
            ->latest()
            ->paginate(15);

        return view('livewire.admin.admin-customers', compact('customers'))
            ->layout('components.admin-layout', [
                'title'     => 'Customers — BookBerry Admin',
                'pageTitle' => 'Customer Management',
            ]);
    }
}