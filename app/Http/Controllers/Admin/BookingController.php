<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        // Auto-complete booking yang sudah lewat waktu
        \Artisan::call('bookings:complete-expired');

        $query = Booking::with(['customer', 'studio', 'payments'])
            ->latest();

        // Filter search nama customer / kode booking
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('booking_code', 'like', '%' . $request->search . '%')
                  ->orWhereHas('customer', fn($q2) => $q2->where('name', 'like', '%' . $request->search . '%'));
            });
        }

        // Filter status
        if ($request->status === 'menunggu') {
            $query->where('booking_status', 'pending')
                  ->whereHas('payments', fn($q) => $q->where('status', 'pending'));
        } elseif ($request->status === 'dikonfirmasi') {
            $query->where('booking_status', 'confirmed');
        } elseif ($request->status === 'ditolak') {
            $query->where('booking_status', 'cancelled');
        }

        // Filter bulan & tahun
        if ($request->month) {
            $query->whereMonth('date', $request->month);
        }
        if ($request->year) {
            $query->whereYear('date', $request->year);
        }

        $bookings = $query->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with(['customer.user', 'studio', 'payments'])->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    // Konfirmasi pembayaran (verifikasi bukti)
    public function confirmPayment(Request $request, $paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $booking = $payment->booking;
        $admin   = auth()->user()->admin;

        // Update status payment dulu
        $payment->update([
            'status'      => 'verified',
            'verified_by' => $admin->id,
            'verified_at' => now(),
        ]);

        // Hitung ulang dari DB setelah update
        $booking->refresh();
        $totalVerified = $booking->payments()->where('status', 'verified')->sum('amount');
        $remaining     = max(0, $booking->total_price - $totalVerified);

        $booking->update([
            'booking_status'  => 'confirmed',
            'remaining_amount'=> $remaining,
            'dp_amount'       => $payment->payment_type === 'full' && $totalVerified === $booking->total_price ? 0 : $booking->dp_amount,
        ]);

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    // Tolak bukti pembayaran
    public function rejectPayment(Request $request, $paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $booking = $payment->booking;
        $paymentType = $payment->payment_type;

        $payment->update([
            'status' => 'rejected',
            'notes'  => $request->reason ?? 'Bukti pembayaran tidak valid.',
        ]);

        $booking->refresh();
        $totalVerified = $booking->payments()->where('status', 'verified')->sum('amount');
        $remaining = max(0, $booking->total_price - $totalVerified);

        $booking->update([
            'remaining_amount' => $remaining,
            'dp_amount'        => $paymentType === 'full' && $totalVerified === 0
                ? $booking->studio->min_dp_amount
                : $booking->dp_amount,
        ]);

        return back()->with('success', 'Bukti pembayaran ditolak.');
    }

    // Konfirmasi pelunasan (pop-up, tanpa upload bukti)
    public function confirmSettlement($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $admin   = auth()->user()->admin;

        Payment::create([
            'booking_id'     => $booking->id,
            'amount'         => $booking->remaining_amount,
            'payment_type'   => 'pelunasan',
            'payment_method' => 'cash',
            'paid_at'        => now(),
            'status'         => 'verified',
            'verified_by'    => $admin->id,
            'verified_at'    => now(),
            'notes'          => 'Pelunasan dikonfirmasi admin saat kedatangan.',
        ]);

        $booking->update([
            'booking_status'  => 'confirmed',
            'remaining_amount'=> 0,
        ]);

        return back()->with('success', 'Pelunasan berhasil dikonfirmasi.');
    }

    // Batalkan booking
    public function cancel(Request $request, $bookingId)
    {
        $booking = Booking::with('customer.user')->findOrFail($bookingId);

        $booking->update(['booking_status' => 'cancelled']);

        return back()->with('success', 'Booking dibatalkan. Hubungi customer via WhatsApp untuk proses refund.');
    }

    // Download invoice
    public function invoice($id)
    {
        $booking = Booking::with(['customer.user', 'studio', 'payments'])
            ->whereIn('booking_status', ['confirmed', 'completed'])
            ->findOrFail($id);

        $customer = $booking->customer;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.invoice', compact('booking', 'customer'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('invoice-' . $booking->booking_code . '.pdf');
    }
}
