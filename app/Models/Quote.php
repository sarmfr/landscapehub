<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quote extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'location',
        'description',
        'image',
        'status',
        'accepted_vendor_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(QuoteResponse::class);
    }

    public function acceptedVendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'accepted_vendor_id');
    }
}
