@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')

    <div class="mb-8">
        <h2 class="font-serif text-3xl font-bold text-charcoal">Ringkasan Studio</h2>
        <p class="text-primary/60 text-sm mt-1">Selamat datang kembali, berikut performa studio hari ini.</p>
    </div>

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-naomi-white p-6 rounded-2xl shadow-sm border border-naomi-muted/20 group hover:border-primary transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-primary/10 p-2 rounded-lg text-primary">
                    <span class="material-symbols-outlined">event_note</span>
                </div>
                <span class="text-xs font-bold text-naomi-muted uppercase tracking-tighter">Hari Ini</span>
            </div>
            <p class="text-charcoal/60 text-xs font-medium mb-1">Pesanan Baru</p>
            <p class="text-3xl font-bold font-serif text-charcoal">{{ $newBookingsToday }}</p>
        </div>

        <div class="bg-naomi-white p-6 rounded-2xl shadow-sm border border-naomi-muted/20 group hover:border-primary transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-primary/10 p-2 rounded-lg text-primary">
                    <span class="material-symbols-outlined">account_balance_wallet</span>
                </div>
                <span class="text-xs font-bold text-naomi-muted uppercase tracking-tighter">Bulan Ini</span>
            </div>
            <p class="text-charcoal/60 text-xs font-medium mb-1">Total Pendapatan</p>
            <p class="text-xl font-bold font-serif text-charcoal">Rp{{ number_format($revenueThisMonth, 0, ',', '.') }}</p>
        </div>

        <div class="bg-naomi-white p-6 rounded-2xl shadow-sm border border-naomi-muted/20 group hover:border-primary transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-primary/10 p-2 rounded-lg text-primary">
                    <span class="material-symbols-outlined">groups</span>
                </div>
                <span class="text-xs font-bold text-naomi-muted uppercase tracking-tighter">Status</span>
            </div>
            <p class="text-charcoal/60 text-xs font-medium mb-1">Booking Aktif</p>
            <p class="text-3xl font-bold font-serif text-charcoal">{{ $activeBookings }}</p>
        </div>

        <div class="bg-naomi-white p-6 rounded-2xl shadow-sm border border-naomi-muted/20 group hover:border-primary transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-primary/10 p-2 rounded-lg text-primary">
                    <span class="material-symbols-outlined">person_add</span>
                </div>
                <span class="text-xs font-bold text-naomi-muted uppercase tracking-tighter">Minggu Ini</span>
            </div>
            <p class="text-charcoal/60 text-xs font-medium mb-1">Member Baru</p>
            <p class="text-3xl font-bold font-serif text-charcoal">{{ $newMembersThisWeek }}</p>
        </div>
    </div>

    {{-- GRAFIK + DP --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">

        {{-- Grafik Tren Pendapatan — smooth curve --}}
        <div class="lg:col-span-2 bg-naomi-white p-8 rounded-2xl shadow-sm border border-naomi-muted/20">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="font-serif text-xl font-bold leading-tight text-charcoal">Tren Pendapatan</h3>
                    <p class="text-xs text-naomi-muted">Analisis 4 minggu terakhir</p>
                </div>
            </div>
            @php
                $maxRevenue = max($weeklyRevenue) ?: 1;
                $svgPoints = [];
                foreach ($weeklyRevenue as $i => $val) {
                    $svgPoints[] = [
                        'x' => round($i * (400 / 3), 2),
                        'y' => round(130 - ($val / $maxRevenue * 115), 2),
                    ];
                }
                // Smooth bezier path
                $linePath = "M{$svgPoints[0]['x']},{$svgPoints[0]['y']}";
                for ($i = 1; $i < count($svgPoints); $i++) {
                    $prev = $svgPoints[$i-1];
                    $curr = $svgPoints[$i];
                    $cpx  = round(($prev['x'] + $curr['x']) / 2, 2);
                    $linePath .= " C{$cpx},{$prev['y']} {$cpx},{$curr['y']} {$curr['x']},{$curr['y']}";
                }
                $last     = end($svgPoints);
                $areaPath = $linePath . " L{$last['x']},150 L0,150 Z";
            @endphp
            <div class="h-64 w-full relative">
                <svg class="w-full h-full" viewBox="0 0 400 150" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="gradient" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" style="stop-color:#2D2A28; stop-opacity:0.2" />
                            <stop offset="100%" style="stop-color:#2D2A28; stop-opacity:0" />
                        </linearGradient>
                    </defs>
                    <path d="{{ $areaPath }}" fill="url(#gradient)" />
                    <path d="{{ $linePath }}" fill="none" stroke="#2D2A28" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    @foreach($svgPoints as $pt)
                        <circle cx="{{ $pt['x'] }}" cy="{{ $pt['y'] }}" r="2.5" fill="#2D2A28" />
                    @endforeach
                </svg>
                <div class="flex justify-between mt-4 px-1">
                    <span class="text-[10px] font-bold text-naomi-muted uppercase">Minggu 1</span>
                    <span class="text-[10px] font-bold text-naomi-muted uppercase">Minggu 2</span>
                    <span class="text-[10px] font-bold text-naomi-muted uppercase">Minggu 3</span>
                    <span class="text-[10px] font-bold text-naomi-muted uppercase">Minggu 4</span>
                </div>
                <div class="flex justify-between mt-1 px-1">
                    @foreach($weeklyRevenue as $val)
                        <span class="text-[10px] font-bold text-primary">Rp{{ number_format($val/1000, 0) }}k</span>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Pesanan yang Perlu Dikonfirmasi --}}
        <div class="bg-naomi-white p-8 rounded-2xl shadow-sm border border-naomi-muted/20">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-serif text-xl font-bold leading-tight text-charcoal">Pesanan yang Perlu Dikonfirmasi</h3>
                <a href="{{ route('admin.bookings.index') }}" class="text-primary text-xs font-bold hover:underline">Lihat Semua</a>
            </div>
            <div class="space-y-6">
                @forelse($needsAction as $booking)
                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="flex gap-4 group block">
                    <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center text-red-500 group-hover:bg-red-500 group-hover:text-white transition-colors shrink-0">
                        <span class="material-symbols-outlined text-xl">account_balance_wallet</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start">
                            <p class="text-sm font-bold text-charcoal truncate">{{ $booking->customer->name }}</p>
                            <span class="text-[9px] font-bold text-naomi-muted ml-2 shrink-0">{{ $booking->booking_code }}</span>
                        </div>
                        @if($booking->booking_status === 'pending')
                            <p class="text-[11px] text-charcoal/60">Status: <span class="font-bold text-yellow-600">Menunggu Konfirmasi</span></p>
                        @else
                            <p class="text-[11px] text-charcoal/60">Sisa: <span class="font-bold text-red-500">Rp{{ number_format($booking->remaining_amount, 0, ',', '.') }}</span></p>
                        @endif
                    </div>
                </a>
                @empty
                <p class="text-center text-charcoal/30 text-sm py-4">Tidak ada pesanan yang perlu dikonfirmasi</p>
                @endforelse
            </div>
            <a href="{{ route('admin.bookings.index') }}"
               class="block w-full mt-8 bg-primary text-naomi-white py-3 rounded-xl text-sm font-bold hover:brightness-110 shadow-lg shadow-primary/20 transition-all text-center">
                Kelola Penagihan
            </a>
        </div>
    </div>

    {{-- GRAFIK PER STUDIO --}}
    <div class="bg-naomi-white p-8 rounded-2xl shadow-sm border border-naomi-muted/20 mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="font-serif text-xl font-bold text-charcoal">Booking per Studio</h3>
                <p class="text-xs text-naomi-muted">Bulan {{ now()->format('F Y') }}</p>
            </div>
        </div>
        <canvas id="studioChart" height="60"></canvas>
    </div>

    {{-- JADWAL HARI INI — full width --}}
    <div class="bg-naomi-white p-8 rounded-2xl shadow-sm border border-naomi-muted/20 mb-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h3 class="font-serif text-xl font-bold text-charcoal">Jadwal Sewa Studio Hari Ini</h3>
                <p class="text-xs text-naomi-muted">{{ now()->translatedFormat('l, d F Y') }}</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-naomi-muted text-[10px] font-bold uppercase tracking-widest border-b border-naomi-bg">
                        <th class="pb-4">Ruangan</th>
                        <th class="pb-4">Waktu Sewa</th>
                        <th class="pb-4">Nama Penyewa</th>
                        <th class="pb-4">Total Bayar</th>
                        <th class="pb-4">Status Booking</th>
                        <th class="pb-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-naomi-bg">
                    @forelse($todayBookings as $booking)
                    <tr class="group hover:bg-naomi-bg/30 transition-colors">
                        <td class="py-4 font-medium text-sm text-charcoal">{{ $booking->studio->name }}</td>
                        <td class="py-4 text-sm">{{ substr($booking->start_time,0,5) }} – {{ substr($booking->end_time,0,5) }}</td>
                        <td class="py-4">
                            <div class="flex items-center gap-2">
                                <div class="size-6 rounded-full bg-naomi-surface overflow-hidden shrink-0">
                                    @if($booking->customer->avatar)
                                        <img src="{{ asset('storage/' . $booking->customer->avatar) }}" class="w-full h-full object-cover" alt="Avatar">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($booking->customer->name) }}&background=2D2A28&color=fff&size=64"
                                             class="w-full h-full" alt="Avatar">
                                    @endif
                                </div>
                                <span class="text-sm font-medium">{{ $booking->customer->name }}</span>
                            </div>
                        </td>
                        <td class="py-4 text-xs font-bold text-charcoal/80 italic">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        <td class="py-4">
                            <x-booking-status :status="$booking->getDisplayStatus()" />
                        </td>
                        <td class="py-4 text-right">
                            <a href="{{ route('admin.bookings.show', $booking->id) }}"
                               class="text-primary text-xs font-bold hover:underline transition-colors">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-10 text-center text-charcoal/30 text-sm">
                            Tidak ada booking hari ini
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById('studioChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: @json($studioStats->pluck('name')),
        datasets: [{
            label: 'Jumlah Booking',
            data: @json($studioStats->pluck('count')),
            backgroundColor: ['rgba(45,42,40,0.8)', 'rgba(45,42,40,0.4)', 'rgba(45,42,40,0.2)'],
            borderColor: '#2D2A28',
            borderWidth: 1.5,
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: ctx => ctx.raw + ' booking' } }
        },
        scales: {
            x: { grid: { display: false }, ticks: { font: { size: 12, weight: '700' } } },
            y: {
                grid: { color: 'rgba(0,0,0,0.04)' },
                ticks: { stepSize: 1, font: { size: 11 } },
                beginAtZero: true,
            }
        }
    }
});
</script>
@endpush
