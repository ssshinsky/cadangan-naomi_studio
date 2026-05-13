<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::with(['user', 'bookings'])
            ->withCount('bookings');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', fn($q2) => $q2->where('email', 'like', '%' . $request->search . '%'));
            });
        }

        $customers = $query->latest()->paginate(15)->withQueryString();

        return view('admin.customers.index', compact('customers'));
    }

    public function toggleActive(Customer $customer)
    {
        $customer->user->update([
            'is_active' => ! $customer->user->is_active,
        ]);

        $status = $customer->user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Akun {$customer->name} berhasil {$status}.");
    }

    public function resetPassword(Request $request, Customer $customer)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $customer->user->update([
            'password' => bcrypt($request->password),
        ]);

        return back()->with('success', "Password {$customer->name} berhasil direset.");
    }

    public function exportPdf(Request $request)
    {
        $now = now();

        $customers = Customer::with(['user', 'bookings.payments'])->get();

        $totalCustomers = $customers->count();
        $activeCustomers = $customers->where('user.is_active', true)->count();
        $inactiveCustomers = $totalCustomers - $activeCustomers;

        $confirmedBookings = Booking::whereIn('booking_status', ['confirmed', 'completed'])->count();
        $totalRevenue = Payment::where('status', 'verified')
            ->whereHas('booking', fn($q) => $q->whereIn('booking_status', ['confirmed', 'completed']))
            ->sum('amount');

        $customerReport = $customers->map(function ($customer) {
            $confirmedBookingsCount = $customer->bookings
                ->whereIn('booking_status', ['confirmed', 'completed'])
                ->count();

            $totalSpent = $customer->bookings
                ->whereIn('booking_status', ['confirmed', 'completed'])
                ->flatMap(fn($booking) => $booking->payments)
                ->where('status', 'verified')
                ->sum('amount');

            $lastBookingDate = $customer->bookings
                ->whereIn('booking_status', ['confirmed', 'completed'])
                ->max('created_at');

            return [
                'name' => $customer->name,
                'email' => $customer->user->email,
                'phone' => $customer->phone ?? '-',
                'status' => $customer->user->is_active ? 'Aktif' : 'Nonaktif',
                'joined_at' => $customer->joined_at ?? $customer->created_at,
                'bookings_count' => $confirmedBookingsCount,
                'total_spent' => $totalSpent,
                'last_booking' => $lastBookingDate,
            ];
        });

        $topBookers = $customerReport
            ->sortByDesc('bookings_count')
            ->take(10);

        $topSpenders = $customerReport
            ->sortByDesc('total_spent')
            ->take(10);

        $recentCustomers = $customerReport
            ->sortByDesc('joined_at')
            ->take(10);

        $pdf = Pdf::loadView('pdf.customers', [
            'generatedAt' => $now,
            'stats' => [
                'total_customers' => $totalCustomers,
                'active_customers' => $activeCustomers,
                'inactive_customers' => $inactiveCustomers,
                'confirmed_bookings' => $confirmedBookings,
                'total_revenue' => $totalRevenue,
            ],
            'topBookers' => $topBookers,
            'topSpenders' => $topSpenders,
            'statusDistribution' => [
                'active' => $activeCustomers,
                'inactive' => $inactiveCustomers,
            ],
            'recentCustomers' => $recentCustomers,
        ])->setPaper('a4', 'portrait');

        return $pdf->download('laporan-pelanggan-' . $now->format('Y-m-d-His') . '.pdf');
    }
}
