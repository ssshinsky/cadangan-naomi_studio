<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OperationalCost;
use App\Models\Payment;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function exportPdf(Request $request)
    {
        $month = (int) $request->get('month', now()->month);
        $year  = (int) $request->get('year', now()->year);

        $payments = Payment::with(['booking.customer', 'booking.studio'])
            ->where('status', 'verified')
            ->whereHas('booking', fn($q) => $q->whereIn('booking_status', ['confirmed', 'completed']))
            ->whereMonth('paid_at', $month)
            ->whereYear('paid_at', $year)
            ->latest('paid_at')
            ->get();

        $totalIncome = $payments->sum('amount');

        $costs = OperationalCost::where('period_month', $month)
            ->where('period_year', $year)
            ->latest('payment_date')
            ->get();

        $totalExpense = $costs->sum('amount');
        $netProfit    = $totalIncome - $totalExpense;
        $margin       = $totalIncome > 0 ? round($netProfit / $totalIncome * 100) : 0;

        // Data 6 bulan terakhir untuk grafik PDF
        $chartLabels  = [];
        $chartIncome  = [];
        $chartExpense = [];
        for ($i = 5; $i >= 0; $i--) {
            $m = $month - $i;
            $y = $year;
            while ($m <= 0) { $m += 12; $y--; }
            $chartLabels[]  = date('M', mktime(0,0,0,$m,1));
            $chartIncome[]  = Payment::where('status', 'verified')
                ->whereHas('booking', fn($q) => $q->whereIn('booking_status', ['confirmed', 'completed']))
                ->whereMonth('paid_at', $m)->whereYear('paid_at', $y)->sum('amount');
            $chartExpense[] = OperationalCost::where('period_month', $m)->where('period_year', $y)->sum('amount');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.laporan', compact(
            'month', 'year', 'payments', 'costs',
            'totalIncome', 'totalExpense', 'netProfit', 'margin',
            'chartLabels', 'chartIncome', 'chartExpense'
        ))->setPaper('a4', 'portrait');

        $filename = 'laporan-' . date('F', mktime(0,0,0,$month,1)) . '-' . $year . '.pdf';

        return $pdf->download($filename);
    }

    public function index(Request $request)
    {
        $month = (int) $request->get('month', now()->month);
        $year  = (int) $request->get('year', now()->year);

        // Pemasukan: payment verified pada booking confirmed/completed
        $payments = Payment::with(['booking.customer', 'booking.studio'])
            ->where('status', 'verified')
            ->whereHas('booking', fn($q) => $q->whereIn('booking_status', ['confirmed', 'completed']))
            ->whereMonth('paid_at', $month)
            ->whereYear('paid_at', $year)
            ->latest('paid_at')
            ->get();

        $totalIncome = $payments->sum('amount');

        // Pengeluaran: operational costs periode ini
        $costs = OperationalCost::where('period_month', $month)
            ->where('period_year', $year)
            ->latest('payment_date')
            ->get();

        $totalExpense = $costs->sum('amount');
        $netProfit    = $totalIncome - $totalExpense;
        $margin       = $totalIncome > 0 ? round($netProfit / $totalIncome * 100) : 0;

        // Perbandingan bulan lalu
        $prevMonth      = $month === 1 ? 12 : $month - 1;
        $prevYear       = $month === 1 ? $year - 1 : $year;
        $prevIncome     = Payment::where('status', 'verified')
            ->whereHas('booking', fn($q) => $q->whereIn('booking_status', ['confirmed', 'completed']))
            ->whereMonth('paid_at', $prevMonth)
            ->whereYear('paid_at', $prevYear)
            ->sum('amount');

        $incomeChange = $prevIncome > 0
            ? round(($totalIncome - $prevIncome) / $prevIncome * 100)
            : null;

        // Data 6 bulan terakhir untuk grafik
        $chartLabels  = [];
        $chartIncome  = [];
        $chartExpense = [];
        for ($i = 5; $i >= 0; $i--) {
            $m = $month - $i;
            $y = $year;
            while ($m <= 0) { $m += 12; $y--; }
            $chartLabels[]  = date('M', mktime(0,0,0,$m,1));
            $chartIncome[]  = Payment::where('status', 'verified')
                ->whereHas('booking', fn($q) => $q->whereIn('booking_status', ['confirmed', 'completed']))
                ->whereMonth('paid_at', $m)->whereYear('paid_at', $y)->sum('amount');
            $chartExpense[] = OperationalCost::where('period_month', $m)->where('period_year', $y)->sum('amount');
        }

        return view('admin.laporan.index', compact(
            'month', 'year',
            'payments', 'costs',
            'totalIncome', 'totalExpense', 'netProfit', 'margin',
            'incomeChange', 'chartLabels', 'chartIncome', 'chartExpense'
        ));
    }
}
