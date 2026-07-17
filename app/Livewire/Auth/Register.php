<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Services\RegionService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Component;

class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role = '';

    // Conditional worker fields
    public string $phone = '';
    public string $address = '';
    public string $ktp_number = '';
    public string $selectedProvince = '';
    public string $selectedRegency = '';

    public array $provinces = [];
    public array $regencies = [];

    public function boot(RegionService $regionService)
    {
        $this->provinces = $regionService->getProvinces()->toArray();
    }

    public function updatedSelectedProvince($value, RegionService $regionService)
    {
        $this->selectedRegency = '';
        $this->regencies = [];

        if ($value) {
            $this->regencies = $regionService->getRegencies($value)->toArray();
        }
    }

    public function register(RegionService $regionService)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:customer,pekerja'],
        ];

        if ($this->role === 'pekerja') {
            $rules = array_merge($rules, [
                'phone' => ['required', 'string', 'max:20'],
                'address' => ['required', 'string'],
                'ktp_number' => ['required', 'string', 'max:20', 'unique:'.User::class.',ktp_number'],
                'selectedProvince' => ['required', 'string'],
                'selectedRegency' => ['required', 'string'],
            ]);
        }

        $this->validate($rules);

        $provinceName = '';
        $regencyName = '';

        if ($this->role === 'pekerja') {
            foreach ($this->provinces as $prov) {
                if ($prov['id'] == $this->selectedProvince) {
                    $provinceName = $prov['name'];
                }
            }
            foreach ($this->regencies as $reg) {
                if ($reg['id'] == $this->selectedRegency) {
                    $regencyName = $reg['name'];
                }
            }
        }

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'phone' => $this->role === 'pekerja' ? $this->phone : null,
            'address' => $this->role === 'pekerja' ? $this->address : null,
            'ktp_number' => $this->role === 'pekerja' ? $this->ktp_number : null,
            'province_id' => $this->role === 'pekerja' ? $this->selectedProvince : null,
            'regency_id' => $this->role === 'pekerja' ? $this->selectedRegency : null,
            'province_name' => $provinceName ?: null,
            'regency_name' => $regencyName ?: null,
            'status' => $this->role === 'pekerja' ? 'pending_verification' : 'available',
        ]);

        $user->assignRole($this->role);

        event(new Registered($user));

        if ($user->hasRole('pekerja')) {
            session()->flash('pending_verification', 'Pendaftaran berhasil! Akun Anda sedang diverifikasi oleh admin.');
            return redirect()->route('login');
        }

        Auth::login($user);
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.auth.register')
            ->layout('layouts.guest');
    }
}
