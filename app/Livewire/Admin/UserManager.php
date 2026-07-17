<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserManager extends Component
{
    use WithPagination;

    // Filter properties
    public string $role = 'all';
    public string $search = '';

    // Active detail view property
    public ?int $selectedUserId = null;

    public function updatingRole()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function selectUser(?int $userId)
    {
        $this->selectedUserId = $userId;
    }

    public function render()
    {
        $query = User::query();

        if ($this->role !== 'all') {
            $query->role($this->role);
        }

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        $users = $query->withCount('orders')->latest()->paginate(15);

        // Load detail user if selected
        $selectedUser = null;
        if ($this->selectedUserId) {
            $selectedUser = User::with(['orders' => function ($q) {
                $q->with('service')->latest()->take(10);
            }, 'roles'])->find($this->selectedUserId);
        }

        return view('livewire.admin.user-manager', [
            'users' => $users,
            'selectedUser' => $selectedUser,
        ])->layout('layouts.admin', ['title' => 'Kelola Pengguna']);
    }
}
