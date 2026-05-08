@extends('admin.layouts.admin')

@section('title', 'Laporan Keuangan Bulanan')

@section('content')

    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10">
        <div>
            <h2 class="font-serif text-3xl font-bold text-charcoal tracking-tight">Laporan Keuangan</h2>
            <p class="text-naomi-muted text-sm mt-1 font-light">Rekapitulasi arus kas masuk dan keluar studio</p>
        </div>

        <div class="flex items-center gap-3">
            <form action="{{ route('admin.laporan.index') }}" method="GET"
                  class="flex items-center gap-2 bg-white border border-charcoal/5 p-1.5 rounded-2xl shadow-sm">
                <select name="month" class="bg-transparent border-none text-xs font-bold text-charcoal focus:ring-0 cursor-pointer px-3">
                    @foreach(range(1,12) as $m)
                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                        {{ strtoupper(date('F', mktime(0,0,0,$m,1))) }}
                    </option>
                    @endforeach
                </select>
                <div class="w-[1px] h-4 bg-charcoal/10"></div>
                <select name="year" class="bg-transparent border-none text-xs font-bold text-charcoal focus:ring-0 cursor-pointer px-3">
                    @for($y = date('Y'); $y >= 2024; $y--)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
                <button type="submit" class="bg-charcoal text-white p-2 rounded-xl hover:bg-primary transition-all">
                    <span class="material-symbols-outlined text-sm block">filter_list</span>
                </button>
            </form>

            <a href="{{ route('admin.laporan.export-pdf', ['month' => $month, 'year' => $year]) }}"
               class="px-5 py-3 bg-primary text-white rounded-xl text-xs font-black uppercase tracking-widest flex items-center gap-2 shadow-lg shadow-primary/20 hover:bg-charcoal transition-all">
                <span class="material-symbols-outlined text-sm">picture_as_pdf</span>
                Export PDF
            </a>
        </div>
    </div>

    {{-- SUMMARY CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        {{-- Pemasukan --}}
        <div class="bg-white p-8 rounded-[2.5rem] border border-charcoal/5 shadow-sm hover:border-green-500/30 transition-all">
            <div class="flex items-center gap-3 mb-4">
                <div class="size-10 bg-green-500/10 rounded-xl flex items-center justify-center text-green-600">
                    <span class="material-symbols-outlined text-xl">trending_up</span>
                </div>
                <p class="text-[10px] font-black text-naomi-muted uppercase tracking-[0.2em]">Pemasukan</p>
            </div>
            <h4 class="text-3xl font-black text-charcoal tracking-tighter">Rp{{ number_format($totalIncome, 0, ',', '.') }}</h4>
            @if($incomeChange !== null)
            <p class="text-[10px] mt-2 font-bold uppercase tracking-widest {{ $incomeChange >= 0 ? 'text-green-600' : 'text-red-500' }}">
                {{ $incomeChange >= 0 ? '↑' : '↓' }} {{ abs($incomeChange) }}% vs Bulan Lalu
            </p>
            @else
            <p class="text-[10px] text-naomi-muted mt-2 font-bold uppercase tracking-widest">Periode {{ date('F Y', mktime(0,0,0,$month,1,$year)) }}</p>
            @endif
        </div>

        {{-- Pengeluaran --}}
        <div class="bg-white p-8 rounded-[2.5rem] border border-charcoal/5 shadow-sm hover:border-red-500/30 transition-all">
            <div class="flex items-center gap-3 mb-4">
                <div class="size-10 bg-red-500/10 rounded-xl flex items-center justify-center text-red-600">
                    <span class="material-symbols-outlined text-xl">trending_down</span>
                </div>
                <p class="text-[10px] font-black text-naomi-muted uppercase tracking-[0.2em]">Pengeluaran</p>
            </div>
            <h4 class="text-3xl font-black text-charcoal tracking-tighter">Rp{{ number_format($totalExpense, 0, ',', '.') }}</h4>
            <p class="text-[10px] text-naomi-muted mt-2 font-bold uppercase tracking-widest">{{ $costs->count() }} item maintenance</p>
        </div>

        {{-- Laba Bersih --}}
        <div class="bg-primary p-8 rounded-[2.5rem] shadow-xl shadow-primary/20 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 size-24 bg-white/10 rounded-full blur-2xl"></div>
            <div class="flex items-center gap-3 mb-4 relative z-10">
                <div class="size-10 bg-white/20 rounded-xl flex items-center justify-center text-naomi-white">
                    <span class="material-symbols-outlined text-xl">payments</span>
                </div>
                <p class="text-[10px] font-black text-naomi-white/70 uppercase tracking-[0.2em]">Laba Bersih</p>
            </div>
            <h4 class="text-3xl font-black text-naomi-white tracking-tighter relative z-10">
                Rp{{ number_format($netProfit, 0, ',', '.') }}
            </h4>
            <p class="text-[10px] text-naomi-white/80 mt-2 font-bold uppercase tracking-widest relative z-10">
                Profit Margin {{ $margin }}%
            </p>
        </div>
    </div>

    {{-- GRAFIK 6 BULAN TERAKHIR --}}
    <div class="bg-white rounded-[2.5rem] border border-charcoal/5 shadow-sm p-8 mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="font-serif text-xl font-bold text-charcoal">Tren Keuangan</h3>
                <p class="text-naomi-muted text-xs mt-1">6 bulan terakhir</p>
            </div>
            <div class="flex items-center gap-4 text-[10px] font-black uppercase tracking-widest">
                <span class="flex items-center gap-1.5"><span class="size-3 rounded-full bg-green-500 inline-block"></span>Pemasukan</span>
                <span class="flex items-center gap-1.5"><span class="size-3 rounded-full bg-red-400 inline-block"></span>Pengeluaran</span>
            </div>
        </div>
        <canvas id="laporanChart" height="80"></canvas>
    </div>

    {{-- TABEL RINCIAN --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        {{-- Pemasukan --}}
        <div class="space-y-4">
            <div class="flex items-center justify-between px-2">
                <h3 class="font-serif text-xl font-bold text-charcoal">Rincian Pemasukan</h3>
                <span class="text-[10px] font-black text-green-600 bg-green-50 px-3 py-1 rounded-full uppercase tracking-widest border border-green-100">
                    {{ $payments->count() }} transaksi
                </span>
            </div>
            <div class="bg-white rounded-[2rem] border border-charcoal/5 overflow-hidden shadow-sm">
                @if($payments->isEmpty())
                <div class="px-8 py-12 text-center text-naomi-muted">
                    <span class="material-symbols-outlined text-4xl block mb-2">receipt_long</span>
                    Belum ada pemasukan periode ini
                </div>
                @else
                <table class="w-full text-left border-collapse">
                    <tbody class="divide-y divide-charcoal/5">
                        @foreach($payments as $payment)
                        <tr class="hover:bg-naomi-bg/10 transition-all">
                            <td class="px-6 py-4">
                                <p class="text-sm font-bold text-charcoal">{{ $payment->booking->customer->name }}</p>
                                <p class="text-[10px] text-naomi-muted uppercase">
                                    {{ $payment->paid_at->format('d M') }} •
                                    {{ $payment->booking->studio->name }} •
                                    {{ strtoupper($payment->payment_type) }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-right font-black text-green-600 text-sm whitespace-nowrap">
                                + Rp{{ number_format($payment->amount, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-green-50/50 border-t border-green-100">
                            <td class="px-6 py-4 text-xs font-black text-charcoal uppercase tracking-widest">Total</td>
                            <td class="px-6 py-4 text-right font-black text-green-600">
                                Rp{{ number_format($totalIncome, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
                @endif
            </div>
        </div>

        {{-- Pengeluaran --}}
        <div class="space-y-4">
            <div class="flex items-center justify-between px-2">
                <h3 class="font-serif text-xl font-bold text-charcoal">Rincian Pengeluaran</h3>
                <span class="text-[10px] font-black text-red-500 bg-red-50 px-3 py-1 rounded-full uppercase tracking-widest border border-red-100">
                    {{ $costs->count() }} item
                </span>
            </div>
            <div class="bg-white rounded-[2rem] border border-charcoal/5 overflow-hidden shadow-sm">
                @if($costs->isEmpty())
                <div class="px-8 py-12 text-center text-naomi-muted">
                    <span class="material-symbols-outlined text-4xl block mb-2">engineering</span>
                    Belum ada pengeluaran periode ini
                </div>
                @else
                <table class="w-full text-left border-collapse">
                    <tbody class="divide-y divide-charcoal/5">
                        @foreach($costs as $cost)
                        <tr class="hover:bg-naomi-bg/10 transition-all">
                            <td class="px-6 py-4">
                                <p class="text-sm font-bold text-charcoal">{{ $cost->description ?? ucfirst($cost->category) }}</p>
                                <p class="text-[10px] text-naomi-muted uppercase">
                                    {{ $cost->payment_date->format('d M') }} • {{ ucfirst($cost->category) }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-right font-black text-red-500 text-sm whitespace-nowrap">
                                - Rp{{ number_format($cost->amount, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-red-50/50 border-t border-red-100">
                            <td class="px-6 py-4 text-xs font-black text-charcoal uppercase tracking-widest">Total</td>
                            <td class="px-6 py-4 text-right font-black text-red-500">
                                Rp{{ number_format($totalExpense, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
                @endif
            </div>
        </div>

    </div>

    {{-- FOOTER --}}
    <div class="mt-8 bg-naomi-surface/30 rounded-2xl p-6 flex flex-col md:flex-row items-center justify-between border border-charcoal/5">
        <div class="flex items-center gap-4 mb-4 md:mb-0">
            <span class="material-symbols-outlined text-primary">info</span>
            <p class="text-xs text-charcoal/70 italic">
                Laporan otomatis dari data transaksi terverifikasi dan biaya maintenance periode
                {{ date('F Y', mktime(0,0,0,$month,1,$year)) }}.
            </p>
        </div>
        <a href="{{ route('admin.maintenance.index', ['month' => $month, 'year' => $year]) }}"
           class="text-[10px] font-black uppercase tracking-[0.2em] text-primary hover:underline flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">engineering</span>
            Kelola Maintenance
        </a>
    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const ctx = document.getElementById('laporanChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($chartLabels),
        datasets: [
            {
                label: 'Pemasukan',
                data: @json($chartIncome),
                backgroundColor: 'rgba(34,197,94,0.15)',
                borderColor: 'rgba(34,197,94,0.8)',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            },
            {
                label: 'Pengeluaran',
                data: @json($chartExpense),
                backgroundColor: 'rgba(239,68,68,0.12)',
                borderColor: 'rgba(239,68,68,0.7)',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => 'Rp' + ctx.raw.toLocaleString('id-ID')
                }
            }
        },
        scales: {
            x: { grid: { display: false }, ticks: { font: { size: 11, weight: '700' } } },
            y: {
                grid: { color: 'rgba(0,0,0,0.04)' },
                ticks: {
                    font: { size: 10 },
                    callback: v => 'Rp' + (v >= 1000000 ? (v/1000000).toFixed(1)+'jt' : v.toLocaleString('id-ID'))
                }
            }
        }
    }
});
</script>
@endpush
