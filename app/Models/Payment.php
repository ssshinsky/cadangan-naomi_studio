<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'verified_by',
        'amount',
        'payment_type',
        'payment_method',
        'proof_image',
        'paid_at',
        'status',
        'verified_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'paid_at'     => 'datetime',
            'verified_at' => 'datetime',
        ];
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(Admin::class, 'verified_by');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isVerified(): bool
    {
        return $this->status === 'verified';
    }
}
