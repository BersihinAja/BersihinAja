<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class OrderForm extends Form
{
    #[Validate('required|integer|exists:services,id')]
    public $service_id = '';

    #[Validate('required|array')]
    public $worker_ids = [];

    public $package_ids = [];

    #[Validate('required|string|min:10')]
    public $address = '';

    #[Validate('required|string')]
    public $regency_name = '';
}
