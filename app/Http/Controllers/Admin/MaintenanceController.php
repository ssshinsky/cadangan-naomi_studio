<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OperationalCost;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year  = $request->get('year', now()->year);

        $costs = OperationalCost::where('period_month', $month)
            ->where('period_year', $year)
            ->latest('payment_date')
            ->get();

        $totalAll      = $costs->sum('amount');
        $totalListrik  = $costs->where('category', 'listrik')->sum('amount');
        $totalLainnya  = $costs->whereNotIn('category', ['listrik'])->sum('amount');

        return view('admin.maintenance.index', compact(
            'costs', 'month', 'year', 'totalAll', 'totalListrik', 'totalLainnya'
        ));
    }

    public function create()
    {
        return view('admin.maintenance.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'period'       => ['required', 'string'],
            'category'     => ['required', 'in:listrik,air,wifi,kebersihan,lain-lain'],
            'amount'       => ['required', 'integer', 'min:1'],
            'payment_date' => ['required', 'date'],
            'description'  => ['nullable', 'string'],
        ]);

        [$year, $month] = explode('-', $request->period);

        OperationalCost::create([
            'created_by'   => auth()->user()->admin->id,
            'cost_code'    => OperationalCost::generateCode((int)$month, (int)$year),
            'category'     => $request->category,
            'description'  => $request->description,
            'amount'       => $request->amount,
            'period_month' => (int)$month,
            'period_year'  => (int)$year,
            'payment_date' => $request->payment_date,
        ]);

        return redirect()->route('admin.maintenance.index', [
            'month' => $month,
            'year'  => $year,
        ])->with('success', 'Biaya operasional berhasil disimpan.');
    }

    public function edit(OperationalCost $maintenance)
    {
        return view('admin.maintenance.edit', compact('maintenance'));
    }

    public function update(Request $request, OperationalCost $maintenance)
    {
        $request->validate([
            'period'       => ['required', 'string'],
            'category'     => ['required', 'in:listrik,air,wifi,kebersihan,lain-lain'],
            'amount'       => ['required', 'integer', 'min:1'],
            'payment_date' => ['required', 'date'],
            'description'  => ['nullable', 'string'],
        ]);

        [$year, $month] = explode('-', $request->period);

        $maintenance->update([
            'category'     => $request->category,
            'description'  => $request->description,
            'amount'       => $request->amount,
            'period_month' => (int)$month,
            'period_year'  => (int)$year,
            'payment_date' => $request->payment_date,
        ]);

        return redirect()->route('admin.maintenance.index', [
            'month' => $month,
            'year'  => $year,
        ])->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(OperationalCost $maintenance)
    {
        $month = $maintenance->period_month;
        $year  = $maintenance->period_year;
        $maintenance->delete();

        return redirect()->route('admin.maintenance.index', compact('month', 'year'))
            ->with('success', 'Data berhasil dihapus.');
    }
}
