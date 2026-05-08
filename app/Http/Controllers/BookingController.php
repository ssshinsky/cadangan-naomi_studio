<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Booking;
use App\Models\BookingCart;
use App\Models\Studio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $studios  = Studio::where('is_available', true)->get();
        $customer = auth()->user()->customer;

        $month = $request->get('month', now()->month);
        $year  = $request->get('year', now()->year);

        // Pre-select studio dari query param
        $selectedStudioId = $request->get('studio');
        $selectedStudioIndex = 0;
        if ($selectedStudioId) {
            $idx = $studios->search(fn($s) => $s->id == $selectedStudioId);
            if ($idx !== false) $selectedStudioIndex = $idx;
        }

        $bookedSlots = Booking::whereIn('booking_status', ['pending', 'confirmed'])
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get()
            ->map(fn($b) => [
                'studio_id'  => $b->studio_id,
                'date'       => $b->date->format('Y-m-d'),
                'start_time' => substr($b->start_time, 0, 5),
                'end_time'   => substr($b->end_time, 0, 5),
            ]);

        $cartItems = $customer->bookingCarts()->with('studio')->orderBy('date')->get();

        $studiosJson = $studios->map(fn($s) => [
            'id'                    => $s->id,
            'name'                  => $s->name,
            'price_per_hour'        => $s->price_per_hour,
            'extra_price_per_hour'  => $s->extra_price_per_hour,
            'extra_price_threshold' => $s->extra_price_threshold,
            'min_dp_amount'         => $s->min_dp_amount,
            'capacity'              => $s->capacity,
            'size_sqm'              => $s->size_sqm,
        ]);

        return view('bookings.index', compact('studios', 'studiosJson', 'bookedSlots', 'cartItems', 'month', 'year', 'selectedStudioIndex'));
    }

    // Tambah item ke keranjang
    public function addToCart(Request $request)
    {
        $request->validate([
            'studio_id'         => ['required', 'exists:studios,id'],
            'date'              => ['required', 'date', 'after_or_equal:today'],
            'start_time'        => ['required'],
            'end_time'          => ['required'],
            'duration_hours'    => ['required', 'numeric', 'min:1'],
            'participant_count' => ['required', 'integer', 'min:1'],
        ]);

        $studio   = Studio::findOrFail($request->studio_id);
        $customer = auth()->user()->customer;

        // Validasi kapasitas — kembalikan ke cart_error supaya muncul di UI
        if ($request->participant_count > $studio->capacity) {
            return back()->with('cart_error', "Maksimal kapasitas {$studio->name} adalah {$studio->capacity} orang.");
        }

        // Hitung harga berdasarkan jumlah peserta
        $pricePerHour = $studio->getPriceForParticipants($request->participant_count);
        $totalPrice   = $pricePerHour * $request->duration_hours;
        $dpAmount     = $studio->min_dp_amount;

        // Cek apakah slot sudah ada di cart
        $exists = BookingCart::where('customer_id', $customer->id)
            ->where('studio_id', $studio->id)
            ->where('date', $request->date)
            ->where(function ($q) use ($request) {
                $q->whereBetween('start_time', [$request->start_time, $request->end_time])
                  ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
            })->exists();

        if ($exists) {
            return back()->with('cart_error', 'Slot ini sudah ada di keranjang.');
        }

        // Cek apakah sudah dipesan orang lain
        $booked = Booking::where('studio_id', $studio->id)
            ->where('date', $request->date)
            ->whereIn('booking_status', ['pending', 'confirmed'])
            ->where('start_time', '<', $request->end_time)
            ->where('end_time', '>', $request->start_time)
            ->exists();

        if ($booked) {
            return back()->with('cart_error', 'Slot ini sudah dipesan.');
        }

        BookingCart::create([
            'customer_id'       => $customer->id,
            'studio_id'         => $studio->id,
            'date'              => $request->date,
            'start_time'        => $request->start_time,
            'end_time'          => $request->end_time,
            'duration_hours'    => $request->duration_hours,
            'participant_count' => $request->participant_count,
            'total_price'       => $totalPrice,
            'dp_amount'         => $dpAmount,
        ]);

        return back()->with('cart_success', 'Berhasil ditambahkan ke keranjang!');
    }

    // Hapus item dari keranjang
    public function removeFromCart($id)
    {
        $customer = auth()->user()->customer;
        BookingCart::where('id', $id)->where('customer_id', $customer->id)->delete();
        return back()->with('cart_success', 'Item dihapus dari keranjang.');
    }

    // Checkout semua item di keranjang
    public function checkout(Request $request)
    {
        $customer  = auth()->user()->customer;
        $cartItems = $customer->bookingCarts()->with('studio')->get();

        if ($cartItems->isEmpty()) {
            return back()->with('cart_error', 'Keranjang kosong.');
        }

        $admin = Admin::first();

        $bookings = [];
        foreach ($cartItems as $item) {
            $booking = Booking::create([
                'customer_id'     => $customer->id,
                'studio_id'       => $item->studio_id,
                'booking_code'    => Booking::generateCode(),
                'date'            => $item->date,
                'end_date'        => $item->date,
                'start_time'      => $item->start_time,
                'end_time'        => $item->end_time,
                'duration_hours'  => $item->duration_hours,
                'total_days'      => 1,
                'total_price'     => $item->total_price,
                'dp_amount'       => $item->dp_amount,
                'remaining_amount'=> $item->total_price - $item->dp_amount,
                'booking_status'  => 'pending',
            ]);
            $bookings[] = $booking->id;

            // Buat notifikasi untuk admin
            if ($admin) {
                DB::table('notifications')->insert([
                    'id'              => Str::uuid()->toString(),
                    'type'            => 'new_booking',
                    'notifiable_type' => 'App\Models\Admin',
                    'notifiable_id'   => $admin->id,
                    'data'            => json_encode([
                        'booking_id'    => $booking->id,
                        'booking_code'  => $booking->booking_code,
                        'customer_name' => $customer->name ?? auth()->user()->name,
                    ]),
                    'read_at'         => null,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);
            }
        }

        // Hapus semua cart setelah checkout
        $customer->bookingCarts()->delete();

        // Redirect ke checkout dengan booking IDs
        return redirect()->route('checkout')->with('booking_ids', $bookings);
    }
}
