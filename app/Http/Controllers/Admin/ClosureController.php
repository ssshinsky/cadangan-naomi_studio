<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Studio;
use App\Models\StudioClosure;
use App\Services\ClosureService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClosureController extends Controller
{
    /**
     * Tampilkan daftar semua Studio_Closure, dikelompokkan per studio,
     * diurutkan ascending berdasarkan date lalu start_time.
     *
     * Requirements: 2.1
     */
    public function index()
    {
        $closures = StudioClosure::with(['studio', 'admin'])
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get()
            ->groupBy('studio_id');

        return view('admin.closures.index', compact('closures'));
    }

    /**
     * Render form untuk membuat closure baru beserta daftar studio untuk dropdown.
     *
     * Requirements: 1.1
     */
    public function create()
    {
        $studios = Studio::orderBy('name')->get();

        return view('admin.closures.create', compact('studios'));
    }

    /**
     * Validasi dan simpan Studio_Closure baru.
     * Jika ada konflik dengan booking existing, kembalikan ke form dengan daftar konflik.
     *
     * Requirements: 1.1, 1.2, 1.3, 1.4, 1.5, 5.1, 5.2, 5.3, 5.4
     */
    public function store(Request $request, ClosureService $closureService)
    {
        $validated = $request->validate([
            'studio_id'  => ['required', 'integer', 'exists:studios,id'],
            'date'       => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time'   => ['required', 'date_format:H:i', 'after:start_time'],
            'reason'     => ['required', 'string', 'min:1', 'max:255'],
        ]);

        // Deteksi konflik dengan booking yang sudah ada
        $conflictingBookings = $closureService->getConflictingBookings(
            $validated['studio_id'],
            $validated['date'],
            $validated['start_time'],
            $validated['end_time']
        );

        if ($conflictingBookings->isNotEmpty()) {
            $studios = Studio::orderBy('name')->get();

            return back()
                ->withInput()
                ->with('conflictingBookings', $conflictingBookings)
                ->with('studios', $studios);
        }

        // Tidak ada konflik — simpan langsung
        DB::transaction(function () use ($validated, $closureService) {
            $closure = StudioClosure::create([
                'studio_id'  => $validated['studio_id'],
                'created_by' => auth()->user()->admin->id,
                'date'       => $validated['date'],
                'start_time' => $validated['start_time'],
                'end_time'   => $validated['end_time'],
                'reason'     => $validated['reason'],
            ]);

            $closureService->invalidateCartItems($closure);
        });

        return redirect()->route('admin.closures.index')
            ->with('success', 'Closure berhasil dibuat.');
    }

    /**
     * Simpan closure meskipun ada konflik (Admin mengkonfirmasi dengan force_save = true).
     * Jalankan invalidateCartItems() setelah menyimpan.
     *
     * Requirements: 1.4, 4.4
     */
    public function confirmStore(Request $request, ClosureService $closureService)
    {
        $validated = $request->validate([
            'studio_id'  => ['required', 'integer', 'exists:studios,id'],
            'date'       => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time'   => ['required', 'date_format:H:i', 'after:start_time'],
            'reason'     => ['required', 'string', 'min:1', 'max:255'],
        ]);

        DB::transaction(function () use ($validated, $closureService) {
            $closure = StudioClosure::create([
                'studio_id'  => $validated['studio_id'],
                'created_by' => auth()->user()->admin->id,
                'date'       => $validated['date'],
                'start_time' => $validated['start_time'],
                'end_time'   => $validated['end_time'],
                'reason'     => $validated['reason'],
            ]);

            $closureService->invalidateCartItems($closure);
        });

        return redirect()->route('admin.closures.index')
            ->with('success', 'Closure berhasil dibuat.');
    }

    /**
     * Hapus Studio_Closure dari database.
     *
     * Requirements: 2.2, 2.3, 2.5
     */
    public function destroy(StudioClosure $closure)
    {
        try {
            DB::transaction(function () use ($closure) {
                $closure->delete();
            });

            return redirect()->route('admin.closures.index')
                ->with('success', 'Closure berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus StudioClosure', [
                'closure_id' => $closure->id,
                'error'      => $e->getMessage(),
                'trace'      => $e->getTraceAsString(),
            ]);

            return redirect()->route('admin.closures.index')
                ->with('error', 'Gagal menghapus closure. Silakan coba lagi.');
        }
    }
}
