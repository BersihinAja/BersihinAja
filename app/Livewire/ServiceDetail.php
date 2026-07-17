<?php

namespace App\Livewire;

use App\Models\Service;
use App\Services\RegionService;
use Livewire\Component;

class ServiceDetail extends Component
{
    public Service $service;
    
    public string $selectedProvince = '';
    public string $selectedRegency = '';
    
    public array $provinces = [];
    public array $regencies = [];

    public function mount(Service $service, RegionService $regionService)
    {
        $this->service = $service;
        $this->service->load('packages');
        $this->provinces = $regionService->getProvinces();
    }

    public function updatedSelectedProvince($value, RegionService $regionService)
    {
        $this->selectedRegency = '';
        $this->regencies = [];
        
        if ($value) {
            $this->regencies = $regionService->getRegencies($value);
        }
    }

    public function getSelectedRegencyNameProperty()
    {
        foreach ($this->regencies as $regency) {
            if ($regency['id'] == $this->selectedRegency) {
                return $regency['name'];
            }
        }
        return '';
    }

    public function order()
    {
        if (!$this->selectedRegency) {
            return;
        }

        $regencyName = $this->getSelectedRegencyNameProperty();

        return redirect()->route('orders.create', [
            'service' => $this->service->slug,
            'regency_id' => $this->selectedRegency,
            'regency_name' => $regencyName,
        ]);
    }

    public function render()
    {
        return view('livewire.service-detail')
            ->layout('layouts.guest-public', ['title' => $this->service->name . ' — BersihinAja']);
    }
}
