<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerProfileController extends Controller
{
    public function index()
    {
        $customer = auth()->user()->customer;
        $totalBookings = $customer->bookings()->count();

        return view('profile.profil', compact('customer', 'totalBookings'));
    }

    public function edit()
    {
        $customer = auth()->user()->customer;
        return view('profile.editprofil', compact('customer'));
    }

    public function riwayatBooking()
    {
        // Auto-complete booking yang sudah lewat waktu
        \Artisan::call('bookings:complete-expired');

        $customer = auth()->user()->customer;

        $activeBookings = $customer->bookings()
            ->with(['studio', 'studio.primaryImage', 'payments'])
            ->whereIn('booking_status', ['pending', 'confirmed'])
            ->latest()
            ->get();
        $completedBookings = $customer->bookings()
            ->with(['studio', 'studio.primaryImage', 'payments'])
            ->whereIn('booking_status', ['completed', 'cancelled'])
            ->latest()
            ->get();

        return view('profile.riwayatbooking', compact('customer', 'activeBookings', 'completedBookings'));
    }

    public function bookingDetail($id)
    {
        $customer = auth()->user()->customer;

        $booking = $customer->bookings()
            ->with(['studio', 'payments', 'review'])
            ->findOrFail($id);

        return view('profile.booking-detail', compact('customer', 'booking'));
    }

    public function cancelBooking($id)
    {
        $customer = auth()->user()->customer;

        $booking = $customer->bookings()
            ->whereIn('booking_status', ['pending'])
            ->findOrFail($id);

        // Hanya boleh batalkan kalau belum ada payment yang verified
        $hasVerifiedPayment = $booking->payments()->where('status', 'verified')->exists();
        if ($hasVerifiedPayment) {
            return back()->with('error', 'Booking yang sudah dikonfirmasi tidak bisa dibatalkan sendiri. Hubungi admin.');
        }

        $booking->update(['booking_status' => 'cancelled']);

        return redirect()->route('profil.riwayat-booking')
            ->with('success', 'Booking berhasil dibatalkan.');
    }

    public function update(Request $request)
    {
        $customer = auth()->user()->customer;

        $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'phone'         => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['nullable', 'date'],
            'gender'        => ['nullable', 'in:male,female'],
            'address'       => ['nullable', 'string', 'max:500'],
            'avatar'        => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->only(['name', 'phone', 'date_of_birth', 'gender', 'address']);

        if ($request->hasFile('avatar')) {
            // Hapus avatar lama kalau ada
            if ($customer->avatar) {
                Storage::disk('public')->delete($customer->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $customer->update($data);

        return redirect()->route('profil')->with('success', 'Profil berhasil diperbarui!');
    }
}
