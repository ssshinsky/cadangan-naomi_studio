<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Payment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Auto-complete booking yang sudah lewat waktu
        \Artisan::call('bookings:complete-expired');

        $today     = Carbon::today();
        $thisMonth = Carbon::now();

        // Stat cards
        $newBookingsToday   = Booking::whereDate('created_at', $today)->count();
        $revenueThisMonth   = Payment::where('status', 'verified')
                                ->whereHas('booking', fn($q) => $q->whereIn('booking_status', ['confirmed', 'completed']))
                                ->whereMonth('paid_at', $thisMonth->month)
                                ->whereYear('paid_at', $thisMonth->year)
                                ->sum('amount');
        $activeBookings     = Booking::whereIn('booking_status', ['pending', 'confirmed'])->count();
        $newMembersThisWeek = Customer::where('created_at', '>=', Carbon::now()->startOfWeek())->count();

        // DP belum lunas (confirmed tapi remaining > 0)
        $pendingSettlements = Booking::with('customer')
            ->where('booking_status', 'confirmed')
            ->where('remaining_amount', '>', 0)
            ->latest()
            ->take(5)
            ->get();

        // Jadwal hari ini
        $todayBookings = Booking::with(['customer', 'studio', 'payments'])
            ->whereDate('date', $today)
            ->whereIn('booking_status', ['pending', 'confirmed', 'completed'])
            ->orderBy('start_time')
            ->get();

        // Data tren pendapatan 4 minggu terakhir — hanya booking confirmed/completed
        $weeklyRevenue = [];
        for ($i = 3; $i >= 0; $i--) {
            $start = Carbon::now()->startOfWeek()->subWeeks($i);
            $end   = Carbon::now()->startOfWeek()->subWeeks($i)->endOfWeek();
            $weeklyRevenue[] = Payment::where('status', 'verified')
                ->whereHas('booking', fn($q) => $q->whereIn('booking_status', ['confirmed', 'completed']))
                ->whereBetween('paid_at', [$start, $end])
                ->sum('amount');
        }

        // Booking per studio bulan ini
        $studioStats = \App\Models\Studio::withCount([
            'bookings as bookings_this_month' => fn($q) => $q
                ->whereIn('booking_status', ['confirmed', 'completed'])
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year),
        ])->get()->map(fn($s) => [
            'name'  => $s->name,
            'count' => $s->bookings_this_month,
        ]);

        return view('admin.dashboard', compact(
            'newBookingsToday',
            'revenueThisMonth',
            'activeBookings',
            'newMembersThisWeek',
            'pendingSettlements',
            'todayBookings',
            'weeklyRevenue',
            'studioStats'
        ));
    }
}
