<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        $customer    = auth()->user()->customer;
        $bookingIds  = session('booking_ids', []);

        // Bisa juga dari query param (dari riwayat booking)
        if ($request->has('booking_id')) {
            $bookingIds = [$request->booking_id];
        }

        $bookings = $customer->bookings()
            ->with('studio')
            ->whereIn('id', $bookingIds)
            ->where('booking_status', 'pending')
            ->get();

        if ($bookings->isEmpty()) {
            return redirect()->route('booking.index')->with('cart_error', 'Tidak ada booking yang perlu dibayar.');
        }

        $totalDP    = $bookings->sum('dp_amount');
        $totalFull  = $bookings->sum('total_price');

        return view('payments.checkout', compact('bookings', 'totalDP', 'totalFull'));
    }

    public function status()
    {
        $customer   = auth()->user()->customer;
        $bookingIds = session('paid_booking_ids', []);

        $bookings = $customer->bookings()
            ->with(['studio', 'payments'])
            ->whereIn('id', $bookingIds)
            ->get();

        // Fallback: ambil booking terbaru kalau session kosong
        if ($bookings->isEmpty()) {
            $bookings = $customer->bookings()
                ->with(['studio', 'payments'])
                ->where('booking_status', 'pending')
                ->latest()
                ->take(1)
                ->get();
        }

        return view('payments.status', compact('bookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_ids'      => ['required', 'array'],
            'payment_type'     => ['required', 'in:dp,full'],
            'payment_method'   => ['required', 'in:transfer_bca,transfer_bni,qris'],
            'proof_image'      => ['required', 'image', 'max:5120'],
        ]);

        $customer  = auth()->user()->customer;
        $proofPath = $request->file('proof_image')->store('payments', 'public');
        $paidIds   = [];

        foreach ($request->booking_ids as $bookingId) {
            $booking = $customer->bookings()->findOrFail($bookingId);

            $amount = $request->payment_type === 'full'
                ? $booking->total_price
                : $booking->dp_amount;

            Payment::create([
                'booking_id'     => $booking->id,
                'amount'         => $amount,
                'payment_type'   => $request->payment_type,
                'payment_method' => $request->payment_method,
                'proof_image'    => $proofPath,
                'paid_at'        => now(),
                'status'         => 'pending',
            ]);

            if ($request->payment_type === 'dp') {
                $booking->update(['remaining_amount' => $booking->total_price - $booking->dp_amount]);
            } else {
                $booking->update(['remaining_amount' => 0]);
            }

            $paidIds[] = $booking->id;
        }

        return redirect()->route('payment.status')->with('paid_booking_ids', $paidIds);
    }
}
