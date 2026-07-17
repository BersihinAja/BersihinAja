<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'address',
        'ktp_number', 'avatar', 'google_id',
        'province_id', 'regency_id', 'province_name', 'regency_name',
        'status',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function assignedOrders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_workers', 'worker_id', 'order_id')
            ->withTimestamps();
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'customer_id');
    }

    public function scopeWorkers($query)
    {
        return $query->role('pekerja');
    }

    public function scopeCustomers($query)
    {
        return $query->role('customer');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeInRegency($query, string $regencyId)
    {
        return $query->where('regency_id', $regencyId);
    }

    public function getAverageRatingAttribute(): ?float
    {
        $ratings = \App\Models\Review::whereIn('order_id', function ($query) {
            $query->select('order_id')
                ->from('order_workers')
                ->where('worker_id', $this->id);
        })->pluck('rating');

        if ($ratings->isEmpty()) {
            return null;
        }

        return round($ratings->average(), 1);
    }

    public function getReviewCountAttribute(): int
    {
        return \App\Models\Review::whereIn('order_id', function ($query) {
            $query->select('order_id')
                ->from('order_workers')
                ->where('worker_id', $this->id);
        })->count();
    }
}

