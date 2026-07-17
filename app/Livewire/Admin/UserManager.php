<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserManager extends Component
{
    use WithPagination;

    public string $search = '';
    public string $tab = 'all'; // all, pending_workers, verified_workers

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingTab()
    {
        $this->resetPage();
    }

    public function verifyWorker(User $user)
    {
        if (!$user->hasRole('pekerja')) {
            abort(403);
        }

        $user->update(['status' => 'available']);
        session()->flash('success', 'Akun pekerja ' . $user->name . ' berhasil diverifikasi!');
    }

    public function rejectWorker(User $user)
    {
        if (!$user->hasRole('pekerja')) {
            abort(403);
        }

        $user->delete();
        session()->flash('success', 'Akun pekerja ' . $user->name . ' berhasil ditolak dan dihapus.');
    }

    public function render()
    {
        $query = User::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->tab === 'pending_workers') {
            $query->role('pekerja')->where('status', 'pending_verification');
        } elseif ($this->tab === 'verified_workers') {
            $query->role('pekerja')->where('status', 'available');
        }

        $users = $query->latest()->paginate(10);

        return view('livewire.admin.user-manager', [
            'users' => $users,
        ])->layout('layouts.admin', ['title' => 'Manajemen Pengguna']);
    }
}
