<?php

namespace App\Livewire\Pekerja;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerList extends Component
{
    use WithPagination;

    public string $search = '';
    public ?int $selectedCustomerId = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function selectCustomer(?int $customerId)
    {
        $this->selectedCustomerId = $customerId;
    }

    public function render()
    {
        $user = Auth::user();
        
        // Get unique customers from worker's assigned orders
        $customerIds = $user->assignedOrders()->pluck('customer_id')->unique();
        
        $query = User::whereIn('id', $customerIds);

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        $customers = $query->withCount(['orders'])->paginate(10);

        // Load detail customer if selected
        $selectedCustomer = null;
        $customerOrders = [];
        
        if ($this->selectedCustomerId) {
            $selectedCustomer = User::find($this->selectedCustomerId);
            
            // Query only orders this worker has served for this customer
            $customerOrders = $user->assignedOrders()
                ->where('customer_id', $this->selectedCustomerId)
                ->with(['service', 'review'])
                ->latest()
                ->get();
        }

        return view('livewire.pekerja.customer-list', [
            'customers' => $customers,
            'selectedCustomer' => $selectedCustomer,
            'customerOrders' => $customerOrders,
        ])->layout('layouts.pekerja', ['title' => 'Pelanggan Saya']);
    }
}
