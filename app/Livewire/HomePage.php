<?php

namespace App\Livewire;

use App\Models\Package;
use App\Models\Service;
use Livewire\Attributes\Computed;
use Livewire\Component;

class HomePage extends Component
{
    #[Computed]
    public function services()
    {
        return Service::all();
    }

    #[Computed]
    public function packages()
    {
        return Package::all();
    }

    public function render()
    {
        return view('livewire.home-page')
            ->layout('layouts.guest-public');
    }
}
