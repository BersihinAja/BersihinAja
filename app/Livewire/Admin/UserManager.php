<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserManager extends Component
{
    use WithPagination;

    public string $search = '';
    public string $tab = 'all'; // all, pending_workers, verified_workers, under_review
    
    // Rejection modal states
    public bool $showRejectionModal = false;
    public ?int $selectedUserId = null;
    public string $rejectionReason = '';

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

        $user->update([
            'status' => 'available',
            'rejection_reason' => null
        ]);
        
        session()->flash('success', 'Akun pekerja ' . $user->name . ' berhasil diverifikasi!');
    }

    public function openRejectionModal($userId)
    {
        $this->selectedUserId = $userId;
        $this->rejectionReason = '';
        $this->showRejectionModal = true;
    }

    public function submitRejection()
    {
        $this->validate([
            'rejectionReason' => ['required', 'string', 'min:5'],
        ]);

        $user = User::findOrFail($this->selectedUserId);
        if (!$user->hasRole('pekerja')) {
            abort(403);
        }

        $user->update([
            'status' => 'rejected',
            'rejection_reason' => $this->rejectionReason,
        ]);

        $this->showRejectionModal = false;
        $this->selectedUserId = null;
        
        session()->flash('success', 'Berkas pendaftaran pekerja ditolak dengan alasan yang terlampir.');
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
        } elseif ($this->tab === 'under_review') {
            $query->role('pekerja')->where('status', 'under_review');
        } elseif ($this->tab === 'verified_workers') {
            $query->role('pekerja')->where('status', 'available');
        }

        $users = $query->latest()->paginate(10);

        return view('livewire.admin.user-manager', [
            'users' => $users,
        ])->layout('layouts.admin', ['title' => 'Manajemen Pengguna']);
    }
}
