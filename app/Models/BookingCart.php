<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingCart extends Model
{
    protected $fillable = [
        'customer_id',
        'studio_id',
        'date',
        'start_time',
        'end_time',
        'duration_hours',
        'participant_count',
        'total_price',
        'dp_amount',
        'is_invalidated_by_closure',
        'invalidated_by_closure_id',
    ];

    protected function casts(): array
    {
        return ['date' => 'date'];
    }

    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
