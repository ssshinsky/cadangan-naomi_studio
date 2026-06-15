@extends('admin.layouts.admin')

@section('title', 'Kalender Ketersediaan Studio')

@section('content')

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="font-serif text-3xl font-bold text-charcoal">Kalender Ketersediaan</h2>
            <p class="text-naomi-muted text-sm mt-1">Pantau slot ketersediaan studio, booking masuk, dan penutupan jadwal secara visual.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.closures.index') }}"
               class="flex items-center gap-2 px-5 py-3 bg-naomi-surface text-charcoal rounded-xl font-bold border border-naomi-muted/20 hover:border-primary transition-all text-xs uppercase tracking-wider">
                <span class="material-symbols-outlined text-sm">event_busy</span>
                Kelola Closure
            </a>
            <a href="{{ route('admin.closures.create') }}?studio_id={{ $selectedStudioId }}"
               class="flex items-center gap-2 px-5 py-3 bg-primary text-white rounded-xl font-bold shadow-lg shadow-primary/20 hover:bg-charcoal transition-all text-xs uppercase tracking-wider">
                <span class="material-symbols-outlined text-sm">add_circle</span>
                Tutup Slot Studio
            </a>
        </div>
    </div>

    {{-- Filter Form --}}
    <form method="GET" action="{{ route('admin.availability.index') }}" class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 gap-4 mb-8 bg-naomi-white p-6 rounded-2xl border border-naomi-muted/20 shadow-sm">
        <div>
            <label for="studio_id" class="block text-[10px] font-black uppercase tracking-widest text-naomi-muted mb-2">Pilih Studio</label>
            <select name="studio_id" id="studio_id" onchange="this.form.submit()"
                    class="w-full bg-naomi-bg border border-naomi-muted/20 rounded-xl px-4 py-2.5 text-sm font-bold text-charcoal focus:ring-2 focus:ring-primary/20 outline-none">
                @foreach($studios as $s)
                    <option value="{{ $s->id }}" {{ $selectedStudioId == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="month" class="block text-[10px] font-black uppercase tracking-widest text-naomi-muted mb-2">Bulan</label>
            <select name="month" id="month" onchange="this.form.submit()"
                    class="w-full bg-naomi-bg border border-naomi-muted/20 rounded-xl px-4 py-2.5 text-sm font-bold text-charcoal focus:ring-2 focus:ring-primary/20 outline-none">
                @foreach(range(1,12) as $m)
                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ DateTime::createFromFormat('!m', $m)->format('F') }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="year" class="block text-[10px] font-black uppercase tracking-widest text-naomi-muted mb-2">Tahun</label>
            <select name="year" id="year" onchange="this.form.submit()"
                    class="w-full bg-naomi-bg border border-naomi-muted/20 rounded-xl px-4 py-2.5 text-sm font-bold text-charcoal focus:ring-2 focus:ring-primary/20 outline-none">
                @foreach([now()->year - 1, now()->year, now()->year + 1] as $y)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" class="w-full bg-primary text-white py-2.5 rounded-xl text-sm font-bold hover:bg-charcoal transition-all">
                Terapkan Filter
            </button>
        </div>
    </form>

    {{-- Main Calendar Layout Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        {{-- Kiri: Kalender Grid (Col span 8) --}}
        <div class="lg:col-span-8 bg-naomi-white rounded-3xl border border-naomi-muted/20 shadow-sm p-6">
            @php
                $firstDay = \Carbon\Carbon::create($year, $month, 1);
                $daysInMonth = $firstDay->daysInMonth;
                $startDow = $firstDay->dayOfWeek; // 0=Sun
                $today = now()->format('Y-m-d');
                $selectedStudio = $studios->firstWhere('id', $selectedStudioId);
            @endphp

            <div class="flex items-center justify-between mb-6 border-b border-naomi-bg pb-4">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">calendar_month</span>
                    <h3 class="font-serif text-xl font-bold text-charcoal">
                        {{ $firstDay->translatedFormat('F Y') }}
                    </h3>
                </div>
                <span class="bg-primary/10 text-primary text-xs font-bold px-3 py-1 rounded-full border border-primary/20">
                    {{ $selectedStudio->name ?? 'Studio' }}
                </span>
            </div>

            {{-- Legend --}}
            <div class="flex flex-wrap items-center gap-4 text-[10px] font-black uppercase tracking-widest text-naomi-muted mb-6">
                <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> Jam Tersedia</span>
                <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-rose-500"></span> Jam Terpesan</span>
                <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-amber-500"></span> Jam Ditutup</span>
            </div>

            {{-- Calendar grid header --}}
            <div class="grid grid-cols-7 gap-2 mb-2">
                @foreach(['Min','Sen','Sel','Rab','Kam','Jum','Sab'] as $dayName)
                    <div class="text-center text-[10px] font-black uppercase tracking-widest text-naomi-muted py-2">{{ $dayName }}</div>
                @endforeach
            </div>

            {{-- Calendar cells --}}
            <div class="grid grid-cols-7 gap-2" id="calendarCells">
                {{-- Empty days offset --}}
                @for($i = 0; $i < $startDow; $i++)
                    <div class="bg-naomi-bg/10 rounded-2xl aspect-[4/3] border border-transparent"></div>
                @endfor

                {{-- Actual days --}}
                @for($day = 1; $day <= $daysInMonth; $day++)
                    @php
                        $dateStr = sprintf('%04d-%02d-%02d', $year, $month, $day);
                        $isToday = $dateStr === $today;
                        $isPast = $dateStr < $today;
                    @endphp
                    <button type="button" 
                            id="day-cell-{{ $dateStr }}" 
                            onclick="selectDate('{{ $dateStr }}')"
                            class="day-cell group flex flex-col justify-between p-3 min-h-[85px] w-full rounded-2xl border bg-naomi-white text-left transition-all hover:border-primary hover:shadow-sm
                                   {{ $isToday ? 'border-primary bg-naomi-bg ring-1 ring-primary/20' : 'border-naomi-muted/10' }}
                                   {{ $isPast ? 'bg-naomi-bg/10' : '' }}">
                        
                        <div class="flex justify-between items-center w-full">
                            <span class="text-xs font-black {{ $isPast ? 'text-charcoal/40' : 'text-charcoal' }} {{ $isToday ? 'bg-primary text-white rounded-full size-6 flex items-center justify-center -ml-1 -mt-1 shadow-sm text-[10px]' : '' }}">
                                {{ $day }}
                            </span>
                        </div>

                        {{-- Badges container (will be filled horizontally by AJAX) --}}
                        <div id="badges-{{ $dateStr }}" class="w-full flex flex-row flex-wrap gap-1 mt-2">
                            <div class="w-5 h-4 bg-slate-200/50 rounded-md animate-pulse"></div>
                            <div class="w-5 h-4 bg-slate-200/50 rounded-md animate-pulse"></div>
                        </div>
                    </button>
                @endfor
            </div>
        </div>

        {{-- Kanan: Detail Slot Jam (Col span 4) --}}
        <div class="lg:col-span-4 bg-naomi-white rounded-3xl border border-naomi-muted/20 shadow-sm p-6 overflow-hidden">
            <div class="flex items-center justify-between border-b border-naomi-bg pb-4 mb-6">
                <h3 class="font-serif text-lg font-bold text-charcoal flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-xl">schedule</span>
                    Detail Hari
                </h3>
                <span id="detailDateLabel" class="text-xs font-bold text-naomi-muted">Pilih tanggal</span>
            </div>

            {{-- Hourly slots container --}}
            <div id="slotsDetailContainer" class="space-y-3 max-h-[520px] overflow-y-auto custom-scrollbar pr-2">
                <div class="text-center py-20 text-naomi-muted">
                    <span class="material-symbols-outlined text-4xl block mb-2 text-naomi-muted/40">event</span>
                    <p class="text-xs font-bold">Pilih tanggal di kalender</p>
                    <p class="text-[11px] mt-1 text-naomi-muted/60">Klik salah satu sel tanggal untuk melihat rincian pemesanan per jam.</p>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        const studioId = {{ $selectedStudioId }};
        const filterMonth = {{ $month }};
        const filterYear = {{ $year }};
        let activeDate = null;

        // Fetch monthly summary on load
        document.addEventListener('DOMContentLoaded', () => {
            fetchMonthlySummary();
            
            // Select today if it is in the current month/year view, otherwise select the first day
            const todayStr = getTodayString();
            const [tYear, tMonth, tDay] = todayStr.split('-').map(Number);
            if (tYear === filterYear && tMonth === filterMonth) {
                selectDate(todayStr);
            } else {
                selectDate(`${filterYear}-${String(filterMonth).padStart(2, '0')}-01`);
            }
        });

        function getTodayString() {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // Fetch Monthly Summary
        function fetchMonthlySummary() {
            const url = `{{ route('admin.availability.data') }}?studio_id=${studioId}&month=${filterMonth}&year=${filterYear}`;
            
            fetch(url)
                .then(res => res.json())
                .then(data => {
                    if (data && data.days) {
                        renderCalendarBadges(data.days);
                    }
                })
                .catch(err => {
                    console.error('Error fetching calendar summary:', err);
                });
        }

        // Render summary badges inside calendar cells
        function renderCalendarBadges(daysData) {
            Object.keys(daysData).forEach(dateStr => {
                const container = document.getElementById(`badges-${dateStr}`);
                if (!container) return;

                container.innerHTML = '';
                const dayData = daysData[dateStr];

                // Render compact horizontal badge pills (only if count > 0)
                if (dayData.available > 0) {
                    const pill = createCompactPill('green', dayData.available, `${dayData.available} Jam Tersedia`);
                    container.appendChild(pill);
                }

                if (dayData.booked > 0) {
                    const pill = createCompactPill('red', dayData.booked, `${dayData.booked} Jam Terpesan`);
                    container.appendChild(pill);
                }

                if (dayData.closed > 0) {
                    const pill = createCompactPill('amber', dayData.closed, `${dayData.closed} Jam Ditutup`);
                    container.appendChild(pill);
                }

                if (dayData.available === 0 && dayData.booked === 0 && dayData.closed === 0) {
                    container.innerHTML = `<span class="text-[9px] font-bold text-naomi-muted/40 italic px-0.5">Tutup</span>`;
                }
            });
        }

        // Create a compact circle status pill
        function createCompactPill(color, count, tooltip) {
            const colors = {
                green: 'bg-emerald-50 text-emerald-700 border-emerald-200/50',
                red: 'bg-rose-50 text-rose-700 border-rose-200/50',
                amber: 'bg-amber-50 text-amber-700 border-amber-200/50'
            };

            const dots = {
                green: 'bg-emerald-500',
                red: 'bg-rose-500',
                amber: 'bg-amber-500'
            };

            const span = document.createElement('span');
            span.className = `inline-flex items-center gap-1 px-1.5 py-0.5 rounded border text-[9px] font-black ${colors[color]} leading-none shrink-0 cursor-help`;
            span.title = tooltip;
            span.innerHTML = `
                <span class="w-1.5 h-1.5 rounded-full ${dots[color]} shrink-0"></span>
                <span>${count}</span>
            `;
            return span;
        }

        // Select Date Handler
        function selectDate(dateStr) {
            // Remove active style from previous selection
            if (activeDate) {
                const prevCell = document.getElementById(`day-cell-${activeDate}`);
                if (prevCell) {
                    const isToday = activeDate === getTodayString();
                    prevCell.classList.remove('ring-2', 'ring-primary', 'border-primary', 'bg-naomi-white');
                    if (isToday) {
                        prevCell.classList.add('border-primary', 'bg-naomi-bg', 'ring-1', 'ring-primary/20');
                    } else {
                        prevCell.classList.add('border-naomi-muted/10');
                    }
                }
            }

            // Set active date
            activeDate = dateStr;
            const currentCell = document.getElementById(`day-cell-${dateStr}`);
            if (currentCell) {
                currentCell.classList.add('ring-2', 'ring-primary', 'border-primary', 'bg-naomi-white');
                currentCell.classList.remove('border-naomi-muted/10', 'bg-naomi-bg/30');
            }

            // Format label
            const d = new Date(dateStr + 'T00:00:00');
            const formattedDate = d.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'short', year: 'numeric' });
            document.getElementById('detailDateLabel').textContent = formattedDate;

            // Load slots details
            loadSlotsDetails(dateStr);
        }

        // Load Slots Details via AJAX
        function loadSlotsDetails(dateStr) {
            const container = document.getElementById('slotsDetailContainer');
            container.innerHTML = `
                <div class="flex flex-col items-center justify-center py-20 text-naomi-muted animate-pulse">
                    <span class="material-symbols-outlined text-3xl animate-spin mb-2">sync</span>
                    <p class="text-xs font-bold">Memuat jadwal slot...</p>
                </div>
            `;

            const url = `{{ route('admin.availability.day') }}?studio_id=${studioId}&date=${dateStr}`;

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    if (data && data.slots) {
                        renderSlotsList(data.slots, dateStr);
                    } else {
                        container.innerHTML = `
                            <div class="text-center py-12 text-red-500 text-xs font-bold">
                                Gagal memuat jadwal slot.
                            </div>
                        `;
                    }
                })
                .catch(err => {
                    console.error('Error loading slots detail:', err);
                    container.innerHTML = `
                        <div class="text-center py-12 text-red-500 text-xs font-bold">
                            Koneksi gagal saat mengambil data.
                        </div>
                    `;
                });
        }

        // Render list of hourly slots
        function renderSlotsList(slots, dateStr) {
            const container = document.getElementById('slotsDetailContainer');
            container.innerHTML = '';

            slots.forEach(slot => {
                const item = document.createElement('div');
                item.className = 'flex items-center justify-between gap-4 p-4 rounded-2xl border transition-all ';

                if (slot.status === 'available') {
                    // Available slot style
                    item.className += 'bg-emerald-50/20 border-emerald-100/60 hover:border-emerald-300';
                    item.innerHTML = `
                        <div>
                            <p class="font-bold text-charcoal text-xs">${slot.start} – ${slot.end}</p>
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-700 mt-1">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                Tersedia
                            </span>
                        </div>
                        <a href="{{ route('admin.closures.create') }}?studio_id=${studioId}&date=${dateStr}&start_time=${slot.start}&end_time=${slot.end}" 
                           class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-[10px] font-black uppercase tracking-wider transition-all flex items-center gap-1 shrink-0">
                            <span class="material-symbols-outlined text-[12px]">event_busy</span>
                            Tutup
                        </a>
                    `;
                } else if (slot.status === 'booked') {
                    // Booked slot style
                    item.className += 'bg-rose-50/20 border-rose-100/60 hover:border-rose-300';
                    const bookingCode = slot.booking.booking_code;
                    const customerName = slot.booking.customer_name;
                    const bookingStatus = slot.booking.status;
                    const statusColor = bookingStatus === 'pending' ? 'text-amber-600 bg-amber-50 border-amber-200' : 'text-emerald-700 bg-emerald-50 border-emerald-200';

                    item.innerHTML = `
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <p class="font-bold text-charcoal text-xs">${slot.start} – ${slot.end}</p>
                                <span class="px-1.5 py-0.5 rounded border text-[8px] font-black uppercase tracking-wider ${statusColor}">
                                    ${bookingStatus === 'pending' ? 'Pending' : 'Lunas'}
                                </span>
                            </div>
                            <p class="text-[11px] text-charcoal/80 font-bold mt-1.5 truncate">Penyewa: ${customerName}</p>
                            <p class="text-[10px] text-naomi-muted font-mono mt-0.5">Code: ${bookingCode}</p>
                        </div>
                        <a href="{{ route('admin.bookings.index') }}?search=${bookingCode}" 
                           class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-[10px] font-black uppercase tracking-wider transition-all flex items-center gap-1 shrink-0">
                            <span class="material-symbols-outlined text-[12px]">visibility</span>
                            Detail
                        </a>
                    `;
                } else if (slot.status === 'closed') {
                    // Closed / Blocked slot style
                    item.className += 'bg-amber-50/20 border-amber-100/60 hover:border-amber-300';
                    const reason = slot.closure.reason;
                    const adminName = slot.closure.admin_name;

                    item.innerHTML = `
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <p class="font-bold text-charcoal text-xs">${slot.start} – ${slot.end}</p>
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-700">
                                    <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                                    Ditutup
                                </span>
                            </div>
                            <p class="text-[11px] text-charcoal/80 font-bold mt-1.5 truncate">Alasan: ${reason}</p>
                            <p class="text-[10px] text-naomi-muted mt-0.5">Oleh: ${adminName}</p>
                        </div>
                        <a href="{{ route('admin.closures.index') }}" 
                           class="px-3 py-1.5 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-[10px] font-black uppercase tracking-wider transition-all flex items-center gap-1 shrink-0">
                            <span class="material-symbols-outlined text-[12px]">settings</span>
                            Kelola
                        </a>
                    `;
                }

                container.appendChild(item);
            });
        }
    </script>
    @endpush

@endsection
