<?php

namespace App\Livewire\Pekerja;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Dashboard extends Component
{
    public string $status = '';

    public function mount()
    {
        $this->status = Auth::user()->status ?: 'available';
    }

    public function updatedStatus($value)
    {
        $user = Auth::user();
        $user->update(['status' => $value]);
        session()->flash('success', 'Status Anda berhasil diperbarui menjadi ' . ($value === 'available' ? 'Tersedia' : 'Sibuk') . '!');
    }

    #[Computed]
    public function stats()
    {
        $user = Auth::user();
        return [
            'active_orders' => $user->assignedOrders()->where('order_status', 'in_progress')->count(),
            'completed_orders' => $user->assignedOrders()->where('order_status', 'completed')->count(),
            'total_earnings' => $user->assignedOrders()->where('payment_status', 'paid')->sum('total'),
        ];
    }

    #[Computed]
    public function recentOrders()
    {
        $user = Auth::user();
        return $user->assignedOrders()
            ->with(['customer', 'service'])
            ->latest()
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.pekerja.dashboard')
            ->layout('layouts.pekerja', ['title' => 'Dashboard']);
    }
}
