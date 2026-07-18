<?php

namespace App\Livewire\Pekerja;

use App\Models\User;
use App\Services\RegionService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Dashboard extends Component
{
    use WithFileUploads;

    // KYC Inputs
    public string $phone = '';
    public string $ktp_number = '';
    public string $address = '';
    public string $selectedProvince = '';
    public string $selectedRegency = '';
    
    public $avatar_file;
    public $ktp_file;

    public array $provinces = [];
    public array $regencies = [];
    public string $status = '';

    public function boot(RegionService $regionService)
    {
        $this->provinces = $regionService->getProvinces()->toArray();
    }

    public function mount(RegionService $regionService)
    {
        $user = Auth::user();
        $this->status = $user->status ?: 'available';

        if ($user->status === 'pending_verification' || $user->status === 'rejected') {
            $this->phone = $user->phone ?? '';
            $this->ktp_number = $user->ktp_number ?? '';
            $this->address = $user->address ?? '';
            $this->selectedProvince = $user->province_id ?? '';
            $this->selectedRegency = $user->regency_id ?? '';
            
            if ($this->selectedProvince) {
                $this->regencies = $regionService->getRegencies($this->selectedProvince)->toArray();
            }
        }
    }

    public function updatedSelectedProvince($value, RegionService $regionService)
    {
        $this->selectedRegency = '';
        $this->regencies = [];

        if ($value) {
            $this->regencies = $regionService->getRegencies($value)->toArray();
        }
    }

    public function updatedStatus($value)
    {
        $user = Auth::user();
        $user->update(['status' => $value]);
        session()->flash('success', 'Status Anda berhasil diperbarui menjadi ' . ($value === 'available' ? 'Tersedia' : 'Sibuk') . '!');
    }

    public function submitKyc(RegionService $regionService)
    {
        $user = Auth::user();
        if ($user->status !== 'pending_verification' && $user->status !== 'rejected') {
            return;
        }

        $this->validate([
            'phone' => ['required', 'string', 'max:20'],
            'ktp_number' => ['required', 'string', 'max:20', 'unique:users,ktp_number,' . $user->id],
            'address' => ['required', 'string'],
            'selectedProvince' => ['required', 'string'],
            'selectedRegency' => ['required', 'string'],
            'avatar_file' => ['required', 'image', 'max:2048'], // 2MB max
            'ktp_file' => ['required', 'image', 'max:2048'], // 2MB max
        ]);

        $provinceName = '';
        $regencyName = '';

        foreach ($this->provinces as $prov) {
            if ($prov['id'] == $this->selectedProvince) {
                $provinceName = $prov['name'];
            }
        }
        
        // Ensure we load regencies if empty
        if (empty($this->regencies) && $this->selectedProvince) {
            $this->regencies = $regionService->getRegencies($this->selectedProvince)->toArray();
        }

        foreach ($this->regencies as $reg) {
            if ($reg['id'] == $this->selectedRegency) {
                $regencyName = $reg['name'];
            }
        }

        // Store files inside public storage (kyc/ folder)
        $avatarPath = $this->avatar_file->store('kyc', 'public');
        $ktpPath = $this->ktp_file->store('kyc', 'public');

        $user->forceFill([
            'phone' => $this->phone,
            'ktp_number' => $this->ktp_number,
            'address' => $this->address,
            'province_id' => $this->selectedProvince,
            'regency_id' => $this->selectedRegency,
            'province_name' => $provinceName,
            'regency_name' => $regencyName,
            'avatar' => $avatarPath,
            'ktp_image' => $ktpPath,
            'status' => 'under_review',
            'rejection_reason' => null, // Clear old rejection reason
        ])->save();

        session()->flash('success', 'Dokumen KYC berhasil diajukan dan sedang ditinjau.');

        return redirect()->route('pekerja.dashboard');
    }

    public function render()
    {
        $user = Auth::user();
        
        if ($user->status === 'pending_verification' || $user->status === 'rejected' || $user->status === 'under_review') {
            return view('livewire.pekerja.dashboard', [
                'user' => $user,
            ])->layout('layouts.pekerja', ['title' => 'Verifikasi Profil']);
        }

        // Normal Dashboard Data
        $stats = [
            'completed_jobs' => $user->assignedOrders()->where('order_status', 'completed')->count(),
            'active_jobs' => $user->assignedOrders()->whereIn('order_status', ['assigned', 'on_the_way', 'working'])->count(),
            'total_earnings' => $user->assignedOrders()->where('order_status', 'completed')->sum('total'),
        ];

        $recentOrders = $user->assignedOrders()
            ->with(['customer', 'service'])
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.pekerja.dashboard', [
            'user' => $user,
            'stats' => $stats,
            'recentOrders' => $recentOrders,
        ])->layout('layouts.pekerja', ['title' => 'Dashboard']);
    }
}
