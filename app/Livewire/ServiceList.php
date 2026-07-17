<?php

namespace App\Livewire;

use App\Models\Service;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ServiceList extends Component
{
    #[Computed]
    public function services()
    {
        return Service::with('packages')->get();
    }

    public function render()
    {
        return view('livewire.service-list')
            ->layout('layouts.guest-public', ['title' => 'Semua Layanan — BersihinAja']);
    }
}
