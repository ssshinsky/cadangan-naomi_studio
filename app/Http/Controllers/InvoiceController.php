<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function download($id)
    {
        $customer = auth()->user()->customer;

        $booking = $customer->bookings()
            ->with(['studio', 'payments'])
            ->whereIn('booking_status', ['confirmed', 'completed'])
            ->findOrFail($id);

        $pdf = Pdf::loadView('pdf.invoice', compact('booking', 'customer'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('invoice-' . $booking->booking_code . '.pdf');
    }
}
