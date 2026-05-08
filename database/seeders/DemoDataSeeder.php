<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\OperationalCost;
use App\Models\Payment;
use App\Models\Studio;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $admin     = Admin::first();
        $customers = Customer::with('user')->get();
        $studios   = Studio::all();

        if ($customers->isEmpty() || $studios->isEmpty()) {
            $this->command->warn('Jalankan CustomerSeeder dan StudioSeeder terlebih dahulu.');
            return;
        }

        $studioBesar = $studios->firstWhere('slug', 'studio-besar') ?? $studios->first();
        $studioKecil = $studios->firstWhere('slug', 'studio-kecil') ?? $studios->last();

        // ── BOOKING DATA ──────────────────────────────────────────────────────
        $bookingsData = [
            // Bulan lalu — completed, lunas
            [
                'customer'   => $customers[0],
                'studio'     => $studioBesar,
                'date'       => now()->subMonth()->setDay(5),
                'start'      => '09:00', 'end' => '12:00', 'hours' => 3,
                'status'     => 'completed',
                'pay_type'   => 'full', 'pay_method' => 'transfer_bca',
                'participants' => 15,
            ],
            [
                'customer'   => $customers[1] ?? $customers[0],
                'studio'     => $studioKecil,
                'date'       => now()->subMonth()->setDay(12),
                'start'      => '14:00', 'end' => '16:00', 'hours' => 2,
                'status'     => 'completed',
                'pay_type'   => 'full', 'pay_method' => 'qris',
                'participants' => 8,
            ],
            [
                'customer'   => $customers[2] ?? $customers[0],
                'studio'     => $studioBesar,
                'date'       => now()->subMonth()->setDay(20),
                'start'      => '10:00', 'end' => '13:00', 'hours' => 3,
                'status'     => 'completed',
                'pay_type'   => 'full', 'pay_method' => 'transfer_bca',
                'participants' => 20,
            ],
            // Bulan ini — confirmed, DP
            [
                'customer'   => $customers[0],
                'studio'     => $studioKecil,
                'date'       => now()->addDays(3),
                'start'      => '13:00', 'end' => '15:00', 'hours' => 2,
                'status'     => 'confirmed',
                'pay_type'   => 'dp', 'pay_method' => 'transfer_bca',
                'participants' => 6,
            ],
            // Bulan ini — confirmed, lunas
            [
                'customer'   => $customers[1] ?? $customers[0],
                'studio'     => $studioBesar,
                'date'       => now()->addDays(7),
                'start'      => '09:00', 'end' => '11:00', 'hours' => 2,
                'status'     => 'confirmed',
                'pay_type'   => 'full', 'pay_method' => 'qris',
                'participants' => 12,
            ],
            // Pending — belum bayar
            [
                'customer'   => $customers[2] ?? $customers[0],
                'studio'     => $studioKecil,
                'date'       => now()->addDays(10),
                'start'      => '16:00', 'end' => '18:00', 'hours' => 2,
                'status'     => 'pending',
                'pay_type'   => null, 'pay_method' => null,
                'participants' => 5,
            ],
        ];

        foreach ($bookingsData as $data) {
            $studio      = $data['studio'];
            $pricePerHour = $studio->getPriceForParticipants($data['participants']);
            $totalPrice  = $pricePerHour * $data['hours'];
            $dpAmount    = $studio->min_dp_amount;

            $booking = Booking::create([
                'customer_id'      => $data['customer']->id,
                'studio_id'        => $studio->id,
                'booking_code'     => Booking::generateCode(),
                'date'             => $data['date']->format('Y-m-d'),
                'end_date'         => $data['date']->format('Y-m-d'),
                'start_time'       => $data['start'],
                'end_time'         => $data['end'],
                'duration_hours'   => $data['hours'],
                'total_days'       => 1,
                'participant_count'=> $data['participants'],
                'total_price'      => $totalPrice,
                'dp_amount'        => $dpAmount,
                'remaining_amount' => $data['pay_type'] === 'full' ? 0 : ($data['pay_type'] === 'dp' ? $totalPrice - $dpAmount : $totalPrice - $dpAmount),
                'booking_status'   => $data['status'],
            ]);

            // Buat payment kalau bukan pending
            if ($data['pay_type']) {
                $amount = $data['pay_type'] === 'full' ? $totalPrice : $dpAmount;
                Payment::create([
                    'booking_id'     => $booking->id,
                    'verified_by'    => $admin->id,
                    'amount'         => $amount,
                    'payment_type'   => $data['pay_type'],
                    'payment_method' => $data['pay_method'],
                    'paid_at'        => $data['date']->subDays(2),
                    'status'         => 'verified',
                    'verified_by'    => $admin->id,
                    'verified_at'    => $data['date']->subDays(1),
                ]);
            }
        }

        // ── OPERATIONAL COSTS ─────────────────────────────────────────────────
        $costsData = [
            // Bulan lalu
            ['month' => now()->subMonth()->month, 'year' => now()->subMonth()->year, 'category' => 'listrik',    'amount' => 850000,  'desc' => 'Token listrik studio utama & AC Central',    'date' => now()->subMonth()->setDay(5)],
            ['month' => now()->subMonth()->month, 'year' => now()->subMonth()->year, 'category' => 'air',        'amount' => 120000,  'desc' => 'Tagihan PDAM bulan lalu',                    'date' => now()->subMonth()->setDay(7)],
            ['month' => now()->subMonth()->month, 'year' => now()->subMonth()->year, 'category' => 'wifi',       'amount' => 250000,  'desc' => 'Langganan internet IndiHome',                'date' => now()->subMonth()->setDay(10)],
            ['month' => now()->subMonth()->month, 'year' => now()->subMonth()->year, 'category' => 'kebersihan', 'amount' => 150000,  'desc' => 'Alat kebersihan & sabun',                    'date' => now()->subMonth()->setDay(15)],
            ['month' => now()->subMonth()->month, 'year' => now()->subMonth()->year, 'category' => 'lain-lain',  'amount' => 200000,  'desc' => 'Service AC studio kecil',                    'date' => now()->subMonth()->setDay(20)],
            // Bulan ini
            ['month' => now()->month, 'year' => now()->year, 'category' => 'listrik',    'amount' => 920000,  'desc' => 'Token listrik bulan ini',                    'date' => now()->setDay(5)],
            ['month' => now()->month, 'year' => now()->year, 'category' => 'air',        'amount' => 115000,  'desc' => 'Tagihan PDAM bulan ini',                     'date' => now()->setDay(7)],
            ['month' => now()->month, 'year' => now()->year, 'category' => 'wifi',       'amount' => 250000,  'desc' => 'Langganan internet IndiHome',                'date' => now()->setDay(10)],
            ['month' => now()->month, 'year' => now()->year, 'category' => 'kebersihan', 'amount' => 80000,   'desc' => 'Pembelian alat pel & cairan pembersih',      'date' => now()->setDay(12)],
        ];

        foreach ($costsData as $cost) {
            OperationalCost::create([
                'created_by'   => $admin->id,
                'cost_code'    => OperationalCost::generateCode($cost['month'], $cost['year']),
                'category'     => $cost['category'],
                'description'  => $cost['desc'],
                'amount'       => $cost['amount'],
                'period_month' => $cost['month'],
                'period_year'  => $cost['year'],
                'payment_date' => $cost['date']->format('Y-m-d'),
            ]);
        }

        $this->command->info('Demo data berhasil dibuat: ' . count($bookingsData) . ' booking, ' . count($costsData) . ' biaya operasional.');
    }
}
