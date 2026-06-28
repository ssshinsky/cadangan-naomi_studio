<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\BookingCart;
use App\Models\StudioClosure;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ClosureService
{
    /**
     * Apakah ada active closure yang overlap dengan slot yang diberikan?
     *
     * Kondisi overlap standar: start_time < $endTime AND end_time > $startTime
     *
     * @param  int    $studioId
     * @param  string $date       Format: YYYY-MM-DD
     * @param  string $startTime  Format: HH:MM
     * @param  string $endTime    Format: HH:MM
     * @return bool
     */
    public function isSlotBlocked(int $studioId, string $date, string $startTime, string $endTime): bool
    {
        return StudioClosure::active()
            ->where('studio_id', $studioId)
            ->whereDate('date', $date)
            ->where('start_time', '<', $endTime)
            ->where('end_time', '>', $startTime)
            ->exists();
    }

    /**
     * Kembalikan daftar booking (pending/confirmed) yang konflik
     * dengan closure yang hendak dibuat.
     *
     * Kondisi overlap standar: start_time < $endTime AND end_time > $startTime
     *
     * @param  int    $studioId
     * @param  string $date       Format: YYYY-MM-DD
     * @param  string $startTime  Format: HH:MM
     * @param  string $endTime    Format: HH:MM
     * @return Collection  Setiap item berisi: booking_code, customer_name, start_time, end_time
     */
    public function getConflictingBookings(int $studioId, string $date, string $startTime, string $endTime): Collection
    {
        return Booking::with('customer')
            ->where('studio_id', $studioId)
            ->whereDate('date', $date)
            ->whereIn('booking_status', ['pending', 'confirmed'])
            ->where('start_time', '<', $endTime)
            ->where('end_time', '>', $startTime)
            ->get()
            ->map(fn (Booking $booking) => [
                'booking_code'  => $booking->booking_code,
                'customer_name' => $booking->customer?->name ?? '-',
                'start_time'    => $booking->start_time,
                'end_time'      => $booking->end_time,
            ]);
    }

    /**
     * Tandai semua BookingCart yang tertutup oleh closure baru sebagai tidak valid.
     *
     * Query BookingCart yang belum checkout (semua item di tabel) pada studio dan
     * tanggal yang sama dengan closure, lalu gunakan kondisi overlap untuk
     * mencocokkan slot. Update is_invalidated_by_closure = true dan
     * invalidated_by_closure_id = $closure->id.
     *
     * Kondisi overlap: cart.start_time < closure.end_time AND cart.end_time > closure.start_time
     *
     * @param  StudioClosure $closure
     * @return int Jumlah item yang ditandai
     */
    public function invalidateCartItems(StudioClosure $closure): int
    {
        $query = BookingCart::where('studio_id', $closure->studio_id)
            ->whereDate('date', $closure->date)
            ->where('is_invalidated_by_closure', false)
            ->where('start_time', '<', $closure->end_time)
            ->where('end_time', '>', $closure->start_time);

        $count = $query->count();

        if ($count > 0) {
            $query->update([
                'is_invalidated_by_closure' => true,
                'invalidated_by_closure_id' => $closure->id,
            ]);
        }

        return $count;
    }

    /**
     * Kembalikan data slot per jam (08:00–22:00) untuk satu hari.
     *
     * Status setiap slot ditentukan dengan prioritas: 'closed' > 'booked' > 'available'.
     * Jika slot berstatus 'closed', sertakan data closure (id, reason, admin_name).
     * Jika slot berstatus 'booked', sertakan data booking (booking_code).
     *
     * @param  int    $studioId
     * @param  string $date      Format: YYYY-MM-DD
     * @return array  Array of ['start', 'end', 'status', 'closure', 'booking']
     */
    public function getSlotsForDay(int $studioId, string $date): array
    {
        // Ambil semua closure untuk studio dan tanggal ini beserta relasi admin
        $closures = StudioClosure::with('admin')
            ->where('studio_id', $studioId)
            ->whereDate('date', $date)
            ->get();

        // Ambil semua booking aktif (pending/confirmed) untuk studio dan tanggal ini beserta customer
        $bookings = Booking::with('customer')
            ->where('studio_id', $studioId)
            ->whereDate('date', $date)
            ->whereIn('booking_status', ['pending', 'confirmed'])
            ->get();

        // Generate slot per jam: 08:00–22:00 (14 slot)
        $slots = [];
        for ($hour = 8; $hour < 22; $hour++) {
            // Gunakan format HH:MM:SS agar konsisten dengan nilai TIME dari MySQL
            $slotStart = sprintf('%02d:00:00', $hour);
            $slotEnd   = sprintf('%02d:00:00', $hour + 1);

            // Cek apakah slot ini overlap dengan closure manapun
            // Kondisi overlap: closure.start_time < slotEnd AND closure.end_time > slotStart
            $matchingClosure = $closures->first(function ($closure) use ($slotStart, $slotEnd) {
                return $closure->start_time < $slotEnd && $closure->end_time > $slotStart;
            });

            if ($matchingClosure) {
                $slots[] = [
                    'start'   => substr($slotStart, 0, 5),
                    'end'     => substr($slotEnd, 0, 5),
                    'status'  => 'closed',
                    'closure' => [
                        'id'         => $matchingClosure->id,
                        'reason'     => $matchingClosure->reason,
                        'admin_name' => $matchingClosure->admin?->name ?? '-',
                    ],
                    'booking' => null,
                ];
                continue;
            }

            // Cek apakah slot ini overlap dengan booking manapun
            // slotStart/slotEnd sudah dalam format HH:MM:SS agar konsisten dengan nilai TIME MySQL
            $matchingBooking = $bookings->first(function ($booking) use ($slotStart, $slotEnd) {
                return $booking->start_time < $slotEnd && $booking->end_time > $slotStart;
            });

            if ($matchingBooking) {
                $slots[] = [
                    'start'   => substr($slotStart, 0, 5),
                    'end'     => substr($slotEnd, 0, 5),
                    'status'  => 'booked',
                    'closure' => null,
                    'booking' => [
                        'id'            => $matchingBooking->id,
                        'booking_code'  => $matchingBooking->booking_code,
                        'customer_name' => $matchingBooking->customer?->name ?? '-',
                        'status'        => $matchingBooking->booking_status,
                    ],
                ];
                continue;
            }

            // Slot tersedia
            $slots[] = [
                'start'   => substr($slotStart, 0, 5),
                'end'     => substr($slotEnd, 0, 5),
                'status'  => 'available',
                'closure' => null,
                'booking' => null,
            ];
        }

        return $slots;
    }

    /**
     * Kembalikan ringkasan per hari dalam satu bulan (untuk calendar grid).
     *
     * Total slot per hari: 14 (08:00–22:00, satu slot per jam).
     * Prioritas per slot: 'closed' > 'booked' > 'available'.
     *
     * Format output:
     * [
     *   'YYYY-MM-DD' => ['available' => int, 'booked' => int, 'closed' => int],
     *   ...
     * ]
     *
     * @param  int $studioId
     * @param  int $month     1–12
     * @param  int $year
     * @return array
     */
    public function getMonthlySummary(int $studioId, int $month, int $year): array
    {
        $startOfMonth = Carbon::create($year, $month, 1);
        $daysInMonth  = $startOfMonth->daysInMonth;
        $startDate    = $startOfMonth->toDateString();
        $endDate      = $startOfMonth->copy()->endOfMonth()->toDateString();

        // Query semua closure pada bulan tersebut, dikelompokkan per tanggal
        $closures = StudioClosure::where('studio_id', $studioId)
            ->whereBetween('date', [$startDate, $endDate])
            ->get()
            ->groupBy(fn ($c) => Carbon::parse($c->date)->format('Y-m-d'));

        // Query semua booking aktif (pending/confirmed) pada bulan tersebut, dikelompokkan per tanggal
        $bookings = Booking::where('studio_id', $studioId)
            ->whereBetween('date', [$startDate, $endDate])
            ->whereIn('booking_status', ['pending', 'confirmed'])
            ->get()
            ->groupBy(fn ($b) => Carbon::parse($b->date)->format('Y-m-d'));

        $summary = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dateKey     = Carbon::create($year, $month, $day)->format('Y-m-d');
            $dayClosures = $closures->get($dateKey, collect());
            $dayBookings = $bookings->get($dateKey, collect());

            $available = 0;
            $booked    = 0;
            $closed    = 0;

            // Iterasi 14 slot per jam: 08:00 – 22:00
            for ($hour = 8; $hour < 22; $hour++) {
                // Gunakan format HH:MM:SS agar konsisten dengan nilai TIME dari MySQL
                $slotStart = sprintf('%02d:00:00', $hour);
                $slotEnd   = sprintf('%02d:00:00', $hour + 1);

                // Prioritas 1: cek closure
                // Kondisi overlap: closure.start_time < slotEnd AND closure.end_time > slotStart
                $isClosed = $dayClosures->contains(function ($closure) use ($slotStart, $slotEnd) {
                    return $closure->start_time < $slotEnd && $closure->end_time > $slotStart;
                });

                if ($isClosed) {
                    $closed++;
                    continue;
                }

                // Prioritas 2: cek booking aktif
                $isBooked = $dayBookings->contains(function ($booking) use ($slotStart, $slotEnd) {
                    return $booking->start_time < $slotEnd && $booking->end_time > $slotStart;
                });

                if ($isBooked) {
                    $booked++;
                    continue;
                }

                $available++;
            }

            $summary[$dateKey] = compact('available', 'booked', 'closed');
        }

        return $summary;
    }
}
