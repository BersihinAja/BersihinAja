<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Package extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'description'];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'service_packages')
            ->withTimestamps();
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_packages')
            ->withPivot('price')
            ->withTimestamps();
    }
}
