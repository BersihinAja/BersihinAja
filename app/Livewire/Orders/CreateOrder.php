<?php

namespace App\Livewire\Orders;

use App\Livewire\Forms\OrderForm;
use App\Models\Service;
use App\Models\User;
use App\Services\OrderService;
use Livewire\Component;

class CreateOrder extends Component
{
    public Service $service;
    public string $regencyId = '';
    public string $regencyName = '';
    
    public OrderForm $form;
    
    public $workers = [];
    public $packages = [];
    
    public function mount(Service $service)
    {
        $this->service = $service;
        $this->service->load('packages');
        $this->packages = $service->packages;
        
        $this->regencyId = request()->query('regency_id', '');
        $this->regencyName = request()->query('regency_name', '');
        
        $this->form->service_id = $service->id;
        $this->form->regency_name = $this->regencyName;
        
        $this->workers = User::workers()
            ->available()
            ->inRegency($this->regencyId)
            ->get();
    }

    public function getTotalProperty()
    {
        $total = $this->service->price;
        
        foreach ($this->packages as $package) {
            if (in_array($package->id, $this->form->package_ids)) {
                $total += $package->price;
            }
        }
        
        return $total;
    }

    public function toggleWorker($id)
    {
        if (in_array($id, $this->form->worker_ids)) {
            $this->form->worker_ids = array_diff($this->form->worker_ids, [$id]);
        } else {
            $this->form->worker_ids[] = $id;
        }
    }

    public function togglePackage($id)
    {
        if (in_array($id, $this->form->package_ids)) {
            $this->form->package_ids = array_diff($this->form->package_ids, [$id]);
        } else {
            $this->form->package_ids[] = $id;
        }
    }

    public function store(OrderService $orderService)
    {
        $this->validate();

        if (count($this->form->worker_ids) < $this->service->cleaners_required) {
            $this->addError('form.worker_ids', "Pilih minimal {$this->service->cleaners_required} pekerja.");
            return;
        }

        $order = $orderService->create([
            'customer_id' => auth()->id(),
            'service_id' => $this->form->service_id,
            'worker_ids' => $this->form->worker_ids,
            'package_ids' => $this->form->package_ids,
            'address' => $this->form->address,
            'regency_name' => $this->form->regency_name,
            'latitude' => $this->form->latitude,
            'longitude' => $this->form->longitude,
        ]);

        return redirect()->route('orders.confirm', $order);
    }

    public function render()
    {
        return view('livewire.orders.create-order')
            ->layout('layouts.guest-public', ['title' => 'Buat Pesanan — BersihinAja']);
    }
}
