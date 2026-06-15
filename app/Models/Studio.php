<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Studio extends Model
{
    protected $fillable = [
        'created_by',
        'name',
        'slug',
        'description',
        'rules',
        'price_per_hour',
        'extra_price_per_hour',
        'extra_price_threshold',
        'min_dp_amount',
        'capacity',
        'size_sqm',
        'floor_type',
        'video',
        'is_available',
        'is_active',
    ];

    // Hitung harga per jam berdasarkan jumlah peserta
    public function getPriceForParticipants(int $participants): int
    {
        if ($this->extra_price_threshold > 0 && $participants > $this->extra_price_threshold) {
            return $this->extra_price_per_hour;
        }
        return $this->price_per_hour;
    }

    protected function casts(): array
    {
        return [
            'is_available' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function images()
    {
        return $this->hasMany(StudioImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(StudioImage::class)->where('is_primary', true);
    }

    public function facilities()
    {
        return $this->hasMany(StudioFacility::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(StudioReview::class);
    }

    public function closures(): HasMany
    {
        return $this->hasMany(StudioClosure::class);
    }
}
