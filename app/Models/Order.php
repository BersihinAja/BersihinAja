<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_number', 'customer_id', 'service_id', 'total',
        'address', 'regency_name', 'payment_status', 'order_status',
        'midtrans_order_id', 'midtrans_snap_token', 'paid_at', 'expires_at',
        'latitude', 'longitude',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'paid_at' => 'datetime',
        'expires_at' => 'datetime',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function workers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'order_workers', 'order_id', 'worker_id')
            ->withTimestamps();
    }

    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class, 'order_packages')
            ->withPivot('price')
            ->withTimestamps();
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    public function scopeUnpaid($query)
    {
        return $query->where('payment_status', 'unpaid');
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopeExpired($query)
    {
        return $query->where('payment_status', 'unpaid')
            ->where('expires_at', '<', now());
    }

    public function scopeForCustomer($query, int $customerId)
    {
        return $query->where('customer_id', $customerId);
    }
}
