<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CompleteExpiredBookings extends Command
{
    protected $signature   = 'bookings:complete-expired';
    protected $description = 'Otomatis ubah status booking jadi completed kalau waktu sudah lewat';

    public function handle(): void
    {
        $now = Carbon::now();

        $updated = Booking::whereIn('booking_status', ['confirmed', 'pending'])
            ->where('remaining_amount', 0) // hanya yang sudah lunas
            ->where(function ($q) use ($now) {
                $q->where('date', '<', $now->toDateString())
                  ->orWhere(function ($q2) use ($now) {
                      $q2->where('date', $now->toDateString())
                         ->where('end_time', '<', $now->format('H:i:s'));
                  });
            })
            ->update(['booking_status' => 'completed']);

        $this->info("$updated booking ditandai selesai.");
    }
}
