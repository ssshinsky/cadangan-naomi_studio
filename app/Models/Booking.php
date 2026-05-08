<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    protected $fillable = [
        'customer_id',
        'studio_id',
        'booking_code',
        'date',
        'end_date',
        'start_time',
        'end_time',
        'duration_hours',
        'total_days',
        'participant_count',
        'total_price',
        'dp_amount',
        'remaining_amount',
        'booking_status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'date'     => 'date',
            'end_date' => 'date',
        ];
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(StudioReview::class);
    }

    public function isPending(): bool
    {
        return $this->booking_status === 'pending';
    }

    public function isConfirmed(): bool
    {
        return $this->booking_status === 'confirmed';
    }

    public function getDisplayStatus(): string
    {
        return match(true) {
            $this->booking_status === 'cancelled'                                                    => 'cancelled',
            $this->booking_status === 'completed'                                                    => 'completed',  // studio sudah selesai dipakai
            $this->booking_status === 'confirmed' && $this->remaining_amount > 0                     => 'waiting_settlement', // DP, belum lunas
            $this->booking_status === 'confirmed' && $this->remaining_amount == 0                    => 'confirmed',
            $this->booking_status === 'pending' && $this->payments()->where('status', 'pending')->exists() => 'waiting_confirmation', // sudah bayar, belum dikonfirm
            default                                                                                   => 'pending',   // belum bayar sama sekali
        };
    }

    // Generate kode booking otomatis: NS-YYYYMMDD-XXXX
    public static function generateCode(): string
    {
        $date = now()->format('Ymd');
        $last = static::whereDate('created_at', today())->count() + 1;
        return 'NS-' . $date . '-' . str_pad($last, 4, '0', STR_PAD_LEFT);
    }
}
