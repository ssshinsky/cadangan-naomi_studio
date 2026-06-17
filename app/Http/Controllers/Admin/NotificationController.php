<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function markRead(string $id)
    {
        $notification = DB::table('notifications')->where('id', $id)->first();

        if ($notification) {
            DB::table('notifications')
                ->where('id', $id)
                ->update(['read_at' => now()]);

            if (request()->wantsJson() || request()->ajax()) {
                return response()->json(['success' => true]);
            }

            if (request()->query('redirect') === 'back') {
                return back()->with('success', 'Notifikasi telah ditandai sebagai dibaca.');
            }

            $data      = json_decode($notification->data, true);
            $bookingId = $data['booking_id'] ?? null;

            if ($bookingId) {
                return redirect()->route('admin.bookings.show', $bookingId);
            }
        }

        return redirect()->route('admin.bookings.index');
    }

    public function markAllRead()
    {
        DB::table('notifications')
            ->whereNull('read_at')
            ->where('notifiable_type', 'App\Models\Admin')
            ->update(['read_at' => now()]);

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }
}
