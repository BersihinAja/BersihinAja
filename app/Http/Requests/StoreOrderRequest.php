<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'service_id' => ['required', 'exists:services,id'],
            'worker_ids' => ['required', 'array', 'min:1'],
            'worker_ids.*' => ['exists:users,id'],
            'package_ids' => ['nullable', 'array'],
            'package_ids.*' => ['exists:packages,id'],
            'address' => ['required', 'string', 'min:10'],
            'regency_name' => ['required', 'string'],
        ];
    }
}
