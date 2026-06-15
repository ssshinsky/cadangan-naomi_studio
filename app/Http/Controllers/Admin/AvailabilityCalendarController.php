<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Studio;
use App\Services\ClosureService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AvailabilityCalendarController extends Controller
{
    public function __construct(
        private readonly ClosureService $closureService
    ) {}

    /**
     * Render halaman kalender dengan dropdown filter studio.
     *
     * Pass daftar studio ke view. Default ke studio pertama dan bulan/tahun saat ini.
     *
     * Requirements: 3.1, 3.7
     */
    public function index(Request $request)
    {
        $studios = Studio::orderBy('name')->get();

        $selectedStudioId = $request->query('studio_id', optional($studios->first())->id);
        $month            = (int) $request->query('month', now()->month);
        $year             = (int) $request->query('year', now()->year);

        return view('admin.availability.index', compact('studios', 'selectedStudioId', 'month', 'year'));
    }

    /**
     * API endpoint: kembalikan JSON ringkasan ketersediaan per hari dalam satu bulan.
     *
     * Query parameters:
     *   - studio_id  (int, required)
     *   - month      (int, 1–12, required)
     *   - year       (int, required)
     *
     * Response format:
     * {
     *   "studio_id": 1,
     *   "month": 7,
     *   "year": 2025,
     *   "days": {
     *     "2025-07-01": { "available": 10, "booked": 3, "closed": 1 }
     *   }
     * }
     *
     * Requirements: 3.1, 3.6, 3.7
     */
    public function data(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'studio_id' => ['required', 'integer', 'exists:studios,id'],
            'month'     => ['required', 'integer', 'min:1', 'max:12'],
            'year'      => ['required', 'integer', 'min:2000', 'max:2100'],
        ]);

        $studioId = (int) $validated['studio_id'];
        $month    = (int) $validated['month'];
        $year     = (int) $validated['year'];

        $days = $this->closureService->getMonthlySummary($studioId, $month, $year);

        return response()->json([
            'studio_id' => $studioId,
            'month'     => $month,
            'year'      => $year,
            'days'      => $days,
        ]);
    }

    /**
     * API endpoint: kembalikan JSON detail slot per jam untuk satu hari.
     *
     * Query parameters:
     *   - studio_id  (int, required)
     *   - date       (date string YYYY-MM-DD, required)
     *
     * Requirements: 3.2, 3.5
     */
    public function dayDetail(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'studio_id' => ['required', 'integer', 'exists:studios,id'],
            'date'      => ['required', 'date_format:Y-m-d'],
        ]);

        $slots = $this->closureService->getSlotsForDay(
            (int) $validated['studio_id'],
            $validated['date']
        );

        return response()->json([
            'date'  => $validated['date'],
            'slots' => $slots,
        ]);
    }
}
