<?php

namespace App\Livewire\Auth;

use App\Models\User;
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

    public function register()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:customer,pekerja'],
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'status' => $this->role === 'pekerja' ? 'pending_verification' : 'available',
        ]);

        $user->assignRole($this->role);

        event(new Registered($user));

        Auth::login($user);

        if ($user->hasRole('admin')) {
            return redirect('/admin/dashboard');
        }
        if ($user->hasRole('pekerja')) {
            return redirect('/pekerja/dashboard');
        }

        return redirect('/');
    }

    public function render()
    {
        return view('livewire.auth.register')
            ->layout('layouts.guest');
    }
}
