<?php

namespace App\Livewire\Admin;

use App\Models\Package;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class ServiceManager extends Component
{
    use WithFileUploads;

    // Collection properties
    public $services = [];
    public $packages = [];

    // Modal state
    public bool $showModal = false;
    public bool $isEditing = false;
    public ?int $editingId = null;

    // Form fields
    public string $name = '';
    public string $price = '';
    public string $room_size = '';
    public string $max_hours = '';
    public string $estimation = '';
    public string $cleaners_required = '';
    public string $description = '';
    public $image; // file uploaded
    public $existingImage; // URL or path
    public array $selectedPackages = [];

    public function mount()
    {
        $this->refreshData();
    }

    public function refreshData()
    {
        $this->services = Service::withCount('orders')->get();
        $this->packages = Package::all();
    }

    public function openCreateModal()
    {
        $this->resetValidation();
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function openEditModal(Service $service)
    {
        $this->resetValidation();
        $this->resetForm();
        $this->isEditing = true;
        $this->editingId = $service->id;
        
        $this->name = $service->name;
        $this->price = $service->price;
        $this->room_size = $service->room_size;
        $this->max_hours = $service->max_hours;
        $this->estimation = $service->estimation;
        $this->cleaners_required = $service->cleaners_required;
        $this->description = $service->description ?? '';
        $this->existingImage = $service->image;
        $this->selectedPackages = $service->packages()->pluck('packages.id')->toArray();
        
        $this->showModal = true;
    }

    public function resetForm()
    {
        $this->name = '';
        $this->price = '';
        $this->room_size = '';
        $this->max_hours = '';
        $this->estimation = '';
        $this->cleaners_required = '';
        $this->description = '';
        $this->image = null;
        $this->existingImage = null;
        $this->selectedPackages = [];
        $this->editingId = null;
    }

    public function save()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'room_size' => 'required|string|max:20',
            'max_hours' => 'required|integer|min:1',
            'estimation' => 'required|string|max:100',
            'cleaners_required' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'image' => $this->image ? 'image|max:2048' : 'nullable',
            'selectedPackages' => 'nullable|array',
            'selectedPackages.*' => 'exists:packages,id',
        ];

        $validated = $this->validate($rules);
        $validated['slug'] = Str::slug($this->name);

        if ($this->isEditing) {
            $service = Service::findOrFail($this->editingId);
            
            if ($this->image) {
                if ($service->image) {
                    Storage::disk('public')->delete($service->image);
                }
                $validated['image'] = $this->image->store('services', 'public');
            } else {
                $validated['image'] = $service->image;
            }

            $service->update([
                'name' => $this->name,
                'slug' => $validated['slug'],
                'price' => $this->price,
                'image' => $validated['image'],
                'room_size' => $this->room_size,
                'max_hours' => $this->max_hours,
                'estimation' => $this->estimation,
                'cleaners_required' => $this->cleaners_required,
                'description' => $this->description,
            ]);

            $service->packages()->sync($this->selectedPackages);
            session()->flash('success', 'Layanan berhasil diperbarui!');
        } else {
            if ($this->image) {
                $validated['image'] = $this->image->store('services', 'public');
            } else {
                $validated['image'] = null;
            }

            $service = Service::create([
                'name' => $this->name,
                'slug' => $validated['slug'],
                'price' => $this->price,
                'image' => $validated['image'],
                'room_size' => $this->room_size,
                'max_hours' => $this->max_hours,
                'estimation' => $this->estimation,
                'cleaners_required' => $this->cleaners_required,
                'description' => $this->description,
            ]);

            $service->packages()->sync($this->selectedPackages);
            session()->flash('success', 'Layanan berhasil ditambahkan!');
        }

        $this->showModal = false;
        $this->resetForm();
        $this->refreshData();
    }

    public function delete(Service $service)
    {
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }
        
        $service->delete();
        session()->flash('success', 'Layanan berhasil dihapus!');
        $this->refreshData();
    }

    public function render()
    {
        return view('livewire.admin.service-manager')
            ->layout('layouts.admin', ['title' => 'Kelola Layanan']);
    }
}
