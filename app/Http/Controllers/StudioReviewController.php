<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\StudioReview;
use Illuminate\Http\Request;

class StudioReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => ['required', 'exists:bookings,id'],
            'rating'     => ['required', 'integer', 'min:1', 'max:5'],
            'comment'    => ['nullable', 'string', 'max:1000'],
        ]);

        $booking = Booking::findOrFail($request->booking_id);

        // Cek ownership
        if ($booking->customer_id !== auth()->user()->customer->id) {
            abort(403);
        }

        // Cek status booking harus completed
        if ($booking->booking_status !== 'completed') {
            return back()->with('error', 'Hanya booking yang sudah selesai yang dapat diberi review.');
        }

        // Cek belum pernah review
        if ($booking->review) {
            return back()->with('error', 'Anda sudah memberikan review untuk booking ini.');
        }

        // Simpan review
        StudioReview::create([
            'booking_id'  => $booking->id,
            'customer_id' => $booking->customer_id,
            'studio_id'   => $booking->studio_id,
            'rating'      => $request->rating,
            'comment'     => $request->comment,
            'is_visible'  => true,
        ]);

        return back()->with('success', 'Review berhasil dikirim. Terima kasih!');
    }
}
