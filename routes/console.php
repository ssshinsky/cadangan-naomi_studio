<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Jalankan setiap 30 menit — otomatis tandai booking selesai kalau waktunya sudah lewat
Schedule::command('bookings:complete-expired')->everyThirtyMinutes();
