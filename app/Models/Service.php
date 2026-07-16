<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'price', 'image', 'room_size',
        'max_hours', 'estimation', 'cleaners_required', 'description',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'max_hours' => 'integer',
        'cleaners_required' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (Service $service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->name);
            }
        });
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class, 'service_packages')
            ->withTimestamps();
    }
}
