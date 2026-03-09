<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vendor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'business_name',
        'description',
        'location',
        'approval_status',
        'commission_rate',
        'profile_image',
        'business_phone',
        'business_address',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function getAverageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getTotalEarnings()
    {
        $orders = Order::whereHas('items', function ($query) {
            $query->whereHas('product', function ($q) {
                $q->where('vendor_id', $this->id);
            });
        })->where('payment_status', 'completed')->get();

        return $orders->sum('vendor_amount');
    }
}
