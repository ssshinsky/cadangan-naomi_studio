<?php

namespace Tests\Unit;

use App\Models\Admin;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Studio;
use App\Models\StudioClosure;
use App\Models\User;
use App\Services\ClosureService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Unit test untuk ClosureService::getMonthlySummary().
 *
 * Memverifikasi bahwa ringkasan per hari dihitung dengan benar
 * berdasarkan booking dan closure yang ada.
 */
class ClosureServiceMonthlySummaryTest extends TestCase
{
    use RefreshDatabase;

    private ClosureService $service;
    private Studio $studio;
    private Admin $admin;
    private Customer $customer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new ClosureService();

        // Buat User untuk Admin dan Customer
        $adminUser = User::create([
            'name'     => 'Admin Test',
            'email'    => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);

        $customerUser = User::create([
            'name'     => 'Customer Test',
            'email'    => 'customer@test.com',
            'password' => bcrypt('password'),
        ]);

        $this->admin = Admin::create([
            'user_id'        => $adminUser->id,
            'name'           => 'Admin Test',
            'is_super_admin' => false,
        ]);

        $this->customer = Customer::create([
            'user_id' => $customerUser->id,
            'name'    => 'Customer Test',
            'phone'   => '081234567890',
        ]);

        $this->studio = Studio::create([
            'created_by'    => $this->admin->id,
            'name'          => 'Studio A',
            'slug'          => 'studio-a',
            'price_per_hour' => 100000,
            'min_dp_amount'  => 50000,
            'capacity'       => 10,
            'is_available'   => true,
        ]);
    }

    /**
     * Hari tanpa booking maupun closure harus memiliki semua slot available (14).
     */
    public function test_day_with_no_booking_and_no_closure_returns_all_available(): void
    {
        $summary = $this->service->getMonthlySummary($this->studio->id, 7, 2025);

        $this->assertArrayHasKey('2025-07-01', $summary);
        $this->assertEquals(14, $summary['2025-07-01']['available']);
        $this->assertEquals(0, $summary['2025-07-01']['booked']);
        $this->assertEquals(0, $summary['2025-07-01']['closed']);
    }

    /**
     * Setiap hari harus memiliki total slot tepat 14 (available + booked + closed = 14).
     */
    public function test_total_slots_per_day_is_always_14(): void
    {
        // Buat closure 3 jam pada tanggal 1
        StudioClosure::create([
            'studio_id'  => $this->studio->id,
            'created_by' => $this->admin->id,
            'date'       => '2025-07-01',
            'start_time' => '08:00',
            'end_time'   => '11:00',
            'reason'     => 'Maintenance',
        ]);

        // Buat booking 2 jam pada tanggal 1
        Booking::create([
            'customer_id'    => $this->customer->id,
            'studio_id'      => $this->studio->id,
            'booking_code'   => 'NS-20250701-0001',
            'date'           => '2025-07-01',
            'start_time'     => '12:00',
            'end_time'       => '14:00',
            'duration_hours' => 2,
            'total_days'     => 1,
            'total_price'    => 200000,
            'booking_status' => 'confirmed',
        ]);

        $summary = $this->service->getMonthlySummary($this->studio->id, 7, 2025);

        $day = $summary['2025-07-01'];
        $total = $day['available'] + $day['booked'] + $day['closed'];
        $this->assertEquals(14, $total);
    }

    /**
     * Closure 3 jam (08:00–11:00) harus menghasilkan 3 slot closed.
     */
    public function test_closure_correctly_marks_slots_as_closed(): void
    {
        StudioClosure::create([
            'studio_id'  => $this->studio->id,
            'created_by' => $this->admin->id,
            'date'       => '2025-07-05',
            'start_time' => '08:00',
            'end_time'   => '11:00',
            'reason'     => 'Renovasi',
        ]);

        $summary = $this->service->getMonthlySummary($this->studio->id, 7, 2025);

        $day = $summary['2025-07-05'];
        $this->assertEquals(3, $day['closed']);
        $this->assertEquals(0, $day['booked']);
        $this->assertEquals(11, $day['available']);
    }

    /**
     * Booking 2 jam (10:00–12:00) dengan status confirmed harus menghasilkan 2 slot booked.
     */
    public function test_confirmed_booking_correctly_marks_slots_as_booked(): void
    {
        Booking::create([
            'customer_id'    => $this->customer->id,
            'studio_id'      => $this->studio->id,
            'booking_code'   => 'NS-20250710-0001',
            'date'           => '2025-07-10',
            'start_time'     => '10:00',
            'end_time'       => '12:00',
            'duration_hours' => 2,
            'total_days'     => 1,
            'total_price'    => 200000,
            'booking_status' => 'confirmed',
        ]);

        $summary = $this->service->getMonthlySummary($this->studio->id, 7, 2025);

        $day = $summary['2025-07-10'];
        $this->assertEquals(2, $day['booked']);
        $this->assertEquals(0, $day['closed']);
        $this->assertEquals(12, $day['available']);
    }

    /**
     * Booking dengan status pending juga harus dihitung sebagai booked.
     */
    public function test_pending_booking_also_counted_as_booked(): void
    {
        Booking::create([
            'customer_id'    => $this->customer->id,
            'studio_id'      => $this->studio->id,
            'booking_code'   => 'NS-20250715-0001',
            'date'           => '2025-07-15',
            'start_time'     => '14:00',
            'end_time'       => '16:00',
            'duration_hours' => 2,
            'total_days'     => 1,
            'total_price'    => 200000,
            'booking_status' => 'pending',
        ]);

        $summary = $this->service->getMonthlySummary($this->studio->id, 7, 2025);

        $day = $summary['2025-07-15'];
        $this->assertEquals(2, $day['booked']);
    }

    /**
     * Booking dengan status cancelled atau completed tidak dihitung sebagai booked.
     */
    public function test_cancelled_and_completed_bookings_not_counted_as_booked(): void
    {
        Booking::create([
            'customer_id'    => $this->customer->id,
            'studio_id'      => $this->studio->id,
            'booking_code'   => 'NS-20250720-0001',
            'date'           => '2025-07-20',
            'start_time'     => '09:00',
            'end_time'       => '10:00',
            'duration_hours' => 1,
            'total_days'     => 1,
            'total_price'    => 100000,
            'booking_status' => 'cancelled',
        ]);

        Booking::create([
            'customer_id'    => $this->customer->id,
            'studio_id'      => $this->studio->id,
            'booking_code'   => 'NS-20250720-0002',
            'date'           => '2025-07-20',
            'start_time'     => '10:00',
            'end_time'       => '11:00',
            'duration_hours' => 1,
            'total_days'     => 1,
            'total_price'    => 100000,
            'booking_status' => 'completed',
        ]);

        $summary = $this->service->getMonthlySummary($this->studio->id, 7, 2025);

        $day = $summary['2025-07-20'];
        $this->assertEquals(0, $day['booked']);
        $this->assertEquals(14, $day['available']);
    }

    /**
     * Closure memiliki prioritas lebih tinggi dari booking.
     * Jika slot overlap dengan closure DAN booking, slot dihitung sebagai 'closed'.
     */
    public function test_closure_has_priority_over_booking(): void
    {
        // Closure 08:00–10:00
        StudioClosure::create([
            'studio_id'  => $this->studio->id,
            'created_by' => $this->admin->id,
            'date'       => '2025-07-22',
            'start_time' => '08:00',
            'end_time'   => '10:00',
            'reason'     => 'Maintenance AC',
        ]);

        // Booking yang overlap dengan closure: 09:00–11:00
        Booking::create([
            'customer_id'    => $this->customer->id,
            'studio_id'      => $this->studio->id,
            'booking_code'   => 'NS-20250722-0001',
            'date'           => '2025-07-22',
            'start_time'     => '09:00',
            'end_time'       => '11:00',
            'duration_hours' => 2,
            'total_days'     => 1,
            'total_price'    => 200000,
            'booking_status' => 'confirmed',
        ]);

        $summary = $this->service->getMonthlySummary($this->studio->id, 7, 2025);

        $day = $summary['2025-07-22'];
        // 08:00-09:00 → closed (hanya closure)
        // 09:00-10:00 → closed (overlap keduanya, closure prioritas)
        // 10:00-11:00 → booked (hanya booking)
        $this->assertEquals(2, $day['closed']);
        $this->assertEquals(1, $day['booked']);
        $this->assertEquals(11, $day['available']);
    }

    /**
     * Return array harus memiliki semua tanggal dalam bulan (31 hari untuk Juli).
     */
    public function test_returns_all_days_in_month(): void
    {
        $summary = $this->service->getMonthlySummary($this->studio->id, 7, 2025);

        $this->assertCount(31, $summary);

        // Periksa key format YYYY-MM-DD
        $this->assertArrayHasKey('2025-07-01', $summary);
        $this->assertArrayHasKey('2025-07-15', $summary);
        $this->assertArrayHasKey('2025-07-31', $summary);
    }

    /**
     * Bulan Februari tahun biasa harus memiliki 28 hari.
     */
    public function test_returns_correct_days_for_february_non_leap_year(): void
    {
        $summary = $this->service->getMonthlySummary($this->studio->id, 2, 2025);

        $this->assertCount(28, $summary);
        $this->assertArrayHasKey('2025-02-28', $summary);
        $this->assertArrayNotHasKey('2025-02-29', $summary);
    }

    /**
     * Setiap entri dalam hasil harus memiliki key 'available', 'booked', 'closed'.
     */
    public function test_each_day_has_required_keys(): void
    {
        $summary = $this->service->getMonthlySummary($this->studio->id, 7, 2025);

        foreach ($summary as $dateKey => $day) {
            $this->assertArrayHasKey('available', $day, "Tanggal $dateKey tidak memiliki key 'available'");
            $this->assertArrayHasKey('booked', $day, "Tanggal $dateKey tidak memiliki key 'booked'");
            $this->assertArrayHasKey('closed', $day, "Tanggal $dateKey tidak memiliki key 'closed'");
        }
    }

    /**
     * Data studio lain tidak boleh mempengaruhi ringkasan studio yang diminta.
     */
    public function test_only_returns_data_for_requested_studio(): void
    {
        // Buat studio kedua
        $studioB = Studio::create([
            'created_by'    => $this->admin->id,
            'name'          => 'Studio B',
            'slug'          => 'studio-b',
            'price_per_hour' => 150000,
            'min_dp_amount'  => 75000,
            'capacity'       => 15,
            'is_available'   => true,
        ]);

        // Buat closure untuk Studio B
        StudioClosure::create([
            'studio_id'  => $studioB->id,
            'created_by' => $this->admin->id,
            'date'       => '2025-07-01',
            'start_time' => '08:00',
            'end_time'   => '22:00',
            'reason'     => 'Tutup seharian',
        ]);

        // Ringkasan Studio A tidak boleh terpengaruh
        $summaryA = $this->service->getMonthlySummary($this->studio->id, 7, 2025);

        $this->assertEquals(14, $summaryA['2025-07-01']['available']);
        $this->assertEquals(0, $summaryA['2025-07-01']['closed']);
    }
}
