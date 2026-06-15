@extends('layouts.app')

@section('title', 'Booking Studio - Naomi Studio')

@section('content')
<main class="bg-naomi-bg min-h-screen pb-24">
<div class="max-w-7xl mx-auto px-4 md:px-6 py-10 md:py-14">

    {{-- PAGE HEADER --}}
    <div class="mb-10">
        <a href="{{ route('home') }}"
           class="inline-flex items-center gap-2 mb-4 px-4 py-2 bg-naomi-white border border-charcoal/10 hover:border-primary hover:text-primary text-charcoal/60 rounded-full text-[10px] font-black uppercase tracking-[0.2em] transition-all shadow-sm">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Beranda
        </a>
        <div class="flex items-center gap-2 mb-3">
            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
            <span class="text-[10px] font-black uppercase tracking-[0.4em] text-charcoal/60">Real-Time Availability</span>
        </div>
        <h1 class="serif-title text-4xl md:text-6xl font-bold text-charcoal leading-tight tracking-tighter">
            Booking <span class="text-primary italic">Studio</span>
        </h1>
        <p class="text-charcoal/60 mt-3 font-medium">Pilih studio, tanggal, dan jam yang kamu inginkan.</p>
    </div>

    {{-- FILTER BULAN --}}
    <form method="GET" action="{{ route('booking.index') }}" class="flex flex-wrap items-center gap-3 mb-8">
        <select name="month" class="bg-naomi-white border border-charcoal/10 rounded-2xl px-4 py-2.5 text-sm font-bold text-charcoal focus:ring-2 focus:ring-primary/20 outline-none shadow-sm">
            @foreach(range(1,12) as $m)
                <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ DateTime::createFromFormat('!m', $m)->format('F') }}</option>
            @endforeach
        </select>
        <select name="year" class="bg-naomi-white border border-charcoal/10 rounded-2xl px-4 py-2.5 text-sm font-bold text-charcoal focus:ring-2 focus:ring-primary/20 outline-none shadow-sm">
            @foreach([now()->year, now()->year + 1] as $y)
                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-primary text-naomi-white px-5 py-2.5 rounded-2xl text-sm font-black uppercase tracking-widest hover:bg-charcoal transition-all shadow-sm">Filter</button>
    </form>

    {{-- STUDIO TABS --}}
    <div class="flex gap-3 mb-8 flex-wrap">
        @foreach($studios as $i => $studio)
        <button onclick="switchStudio({{ $i }})" id="btnStudio{{ $i }}"
                class="studio-tab group px-6 py-4 bg-naomi-white {{ $i === 0 ? 'border-2 border-primary shadow-lg shadow-primary/10' : 'border border-charcoal/10 hover:border-primary/30' }} rounded-2xl text-left transition-all">
            <p class="font-black text-sm {{ $i === 0 ? 'text-charcoal' : 'text-charcoal/60' }} group-hover:text-primary transition-colors">{{ $studio->name }}</p>
            <p class="text-[10px] {{ $i === 0 ? 'text-primary' : 'text-charcoal/40' }} mt-0.5 font-bold">
                {{ $studio->size_sqm }} &nbsp;·&nbsp; Rp{{ number_format($studio->price_per_hour, 0, ',', '.') }}/jam
            </p>
        </button>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- ── KIRI: KALENDER + SLOT JAM ── --}}
        <div class="lg:col-span-7 space-y-5">

            {{-- STEP 1: Pilih Tanggal --}}
            <div class="bg-naomi-white rounded-3xl shadow-sm border border-charcoal/5 p-6 md:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="size-8 bg-primary text-white rounded-xl flex items-center justify-center text-xs font-black">1</div>
                    <h2 class="font-black text-charcoal text-lg">Pilih Tanggal</h2>
                    <button onclick="openBookingFlowModal()" class="ml-auto flex items-center gap-1.5 border border-charcoal/20 text-charcoal/60 hover:border-primary hover:text-primary rounded-xl px-3 py-1.5 text-[11px] font-bold transition-all">
                        <span class="material-symbols-outlined text-sm">info</span>
                        Alur Booking
                    </button>
                </div>

                {{-- Mini Calendar Grid --}}
                @php
                    $firstDay = \Carbon\Carbon::create($year, $month, 1);
                    $daysInMonth = $firstDay->daysInMonth;
                    $startDow = $firstDay->dayOfWeek; // 0=Sun
                    $today = now()->format('Y-m-d');
                @endphp

                <div class="mb-4">
                    <div class="grid grid-cols-7 gap-1 mb-2">
                        @foreach(['Min','Sen','Sel','Rab','Kam','Jum','Sab'] as $day)
                        <div class="text-center text-[9px] font-black uppercase tracking-widest text-charcoal/30 py-1">{{ $day }}</div>
                        @endforeach
                    </div>
                    <div class="grid grid-cols-7 gap-1" id="calendarGrid">
                        {{-- Empty cells before first day --}}
                        @for($e = 0; $e < $startDow; $e++)
                        <div></div>
                        @endfor

                        @for($d = 1; $d <= $daysInMonth; $d++)
                        @php
                            $dateStr = sprintf('%04d-%02d-%02d', $year, $month, $d);
                            $isPast  = $dateStr < $today;
                        @endphp
                        <button type="button"
                                id="calDay{{ $d }}"
                                onclick="{{ $isPast ? '' : "selectDate('$dateStr', $d)" }}"
                                class="aspect-square rounded-xl text-sm font-bold transition-all
                                    {{ $isPast
                                        ? 'text-charcoal/20 cursor-not-allowed'
                                        : 'text-charcoal hover:bg-primary hover:text-white cursor-pointer' }}">
                            {{ $d }}
                        </button>
                        @endfor
                    </div>
                </div>

                <div id="selectedDateDisplay" class="hidden bg-primary/5 border border-primary/20 rounded-2xl px-4 py-3 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary text-lg">event</span>
                    <span id="selectedDateText" class="font-black text-primary text-sm"></span>
                    <button onclick="clearDate()" class="ml-auto text-primary/50 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-base">close</span>
                    </button>
                </div>

                <input type="hidden" id="startDate">
            </div>

            {{-- Step 2 ada di popup modal --}}
        </div>

        {{-- ── KANAN: KERANJANG + FORM ── --}}
        <div class="lg:col-span-5 space-y-5">

            {{-- KERANJANG --}}
            <div class="bg-naomi-white rounded-3xl shadow-sm border border-charcoal/5 overflow-hidden">
                <div class="bg-charcoal px-6 py-5 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-naomi-white/70 text-xl">shopping_cart</span>
                        <h3 class="font-black text-naomi-white text-base">Keranjang</h3>
                    </div>
                    <span class="bg-primary text-white text-[10px] font-black px-3 py-1 rounded-full">{{ $cartItems->count() }} item</span>
                </div>

                <div class="p-5 space-y-3 max-h-56 overflow-y-auto">
                    @forelse($cartItems as $item)
                    <div class="flex items-start justify-between gap-3 bg-naomi-bg rounded-2xl p-4">
                        <div class="flex-1 min-w-0">
                            <p class="font-black text-charcoal text-sm truncate">{{ $item->studio->name }}</p>
                            <p class="text-[10px] text-charcoal/50 font-bold mt-0.5">
                                {{ $item->date->format('d M Y') }} · {{ substr($item->start_time,0,5) }}–{{ substr($item->end_time,0,5) }}
                            </p>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-[10px] text-primary font-black">Rp{{ number_format($item->total_price, 0, ',', '.') }}</span>
                                <span class="text-[9px] text-charcoal/30 font-bold">DP: Rp{{ number_format($item->dp_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('booking.cart.remove', $item->id) }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="size-8 flex items-center justify-center text-red-300 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all">
                                <span class="material-symbols-outlined text-base">delete</span>
                            </button>
                        </form>
                    </div>
                    @empty
                    <div class="text-center py-6">
                        <span class="material-symbols-outlined text-3xl text-charcoal/20 block mb-2">shopping_cart</span>
                        <p class="text-charcoal/30 text-xs font-bold">Keranjang masih kosong</p>
                    </div>
                    @endforelse
                </div>

                @if($cartItems->isNotEmpty())
                <div class="px-5 pb-5 border-t border-naomi-bg pt-4">
                    <div class="flex justify-between text-xs mb-1.5">
                        <span class="text-charcoal/50 font-medium">Total DP</span>
                        <span class="font-black text-primary">Rp{{ number_format($cartItems->sum('dp_amount'), 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-xs mb-4">
                        <span class="text-charcoal/50 font-medium">Total Harga</span>
                        <span class="font-black text-charcoal">Rp{{ number_format($cartItems->sum('total_price'), 0, ',', '.') }}</span>
                    </div>
                    <form method="POST" action="{{ route('booking.checkout') }}">
                        @csrf
                        <button type="submit" class="w-full bg-primary text-naomi-white py-3.5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-lg shadow-primary/20 hover:bg-charcoal transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            Checkout Semua
                        </button>
                    </form>
                </div>
                @endif
            </div>

            {{-- STEP 3: FORM TAMBAH --}}
            <div class="bg-naomi-white rounded-3xl shadow-sm border border-charcoal/5 overflow-hidden">
                <div class="bg-primary px-6 py-5 flex items-center gap-3">
                    <div class="size-8 bg-white/20 text-white rounded-xl flex items-center justify-center text-xs font-black">3</div>
                    <div>
                        <h3 class="font-black text-naomi-white text-base">Konfirmasi Slot</h3>
                        <p id="studioNameDisplay" class="text-naomi-white/70 text-[10px] font-bold uppercase tracking-widest mt-0.5">{{ $studios->first()->name }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('booking.cart.add') }}" id="addCartForm">
                    @csrf
                    <input type="hidden" name="studio_id" id="inputStudioId" value="{{ $studios->first()->id }}">
                    <input type="hidden" name="date" id="inputDate">
                    <input type="hidden" name="start_time" id="inputStartTime">
                    <input type="hidden" name="end_time" id="inputEndTime">
                    <input type="hidden" name="duration_hours" id="inputDuration">

                    <div class="p-6 space-y-4">
                        <div class="bg-naomi-bg rounded-2xl p-4 space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-[9px] font-black uppercase tracking-widest text-charcoal/40">Tanggal</span>
                                <span id="displayDate" class="font-black text-charcoal text-sm">—</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[9px] font-black uppercase tracking-widest text-charcoal/40">Waktu</span>
                                <span id="displayTime" class="font-black text-charcoal text-sm">—</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[9px] font-black uppercase tracking-widest text-charcoal/40">Durasi</span>
                                <span id="displayDurasi" class="font-black text-charcoal text-sm">—</span>
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] uppercase font-black text-charcoal/50 tracking-widest mb-2 block">Jumlah Peserta</label>
                            <input type="number" name="participant_count" id="inputParticipant"
                                   min="1" value="1"
                                   class="w-full bg-naomi-bg border border-charcoal/10 rounded-2xl px-4 py-3 text-sm font-bold text-charcoal focus:ring-2 focus:ring-primary/20 outline-none"
                                   onchange="updateSummary()">
                            <p id="participantWarning" class="text-[10px] text-amber-600 font-bold mt-1.5 hidden"></p>
                        </div>

                        <div class="border-t border-charcoal/5 pt-4 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-charcoal/50">Total Harga</span>
                                <span id="displayTotal" class="font-black text-charcoal">Rp 0</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-charcoal/50">Minimal DP</span>
                                <span id="displayDP" class="font-black text-primary">Rp 0</span>
                            </div>
                        </div>

                        <button type="button" onclick="addToCart()"
                                class="w-full bg-primary text-naomi-white py-3.5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-lg shadow-primary/20 hover:bg-charcoal transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-sm">add_shopping_cart</span>
                            Tambah ke Keranjang
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
</main>

{{-- Modal Pilih Jam --}}
<div id="slotModal" class="hidden fixed inset-0 bg-charcoal/70 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-naomi-white rounded-3xl shadow-2xl w-full max-w-lg max-h-[90vh] flex flex-col overflow-hidden">

        {{-- Header modal --}}
        <div class="bg-primary px-6 py-5 flex items-center justify-between shrink-0">
            <div>
                <div class="flex items-center gap-3">
                    <div class="size-8 bg-white/20 text-white rounded-xl flex items-center justify-center text-xs font-black">2</div>
                    <h3 class="font-black text-naomi-white text-base">Pilih Jam</h3>
                </div>
                <p id="slotModalDate" class="text-naomi-white/70 text-xs mt-1 ml-11"></p>
            </div>
            <button onclick="closeSlotModal()" class="size-9 bg-white/10 hover:bg-white/20 rounded-xl flex items-center justify-center transition-all">
                <span class="material-symbols-outlined text-white text-lg">close</span>
            </button>
        </div>

        {{-- Legend --}}
        <div class="px-6 py-3 border-b border-naomi-bg flex items-center gap-4 text-[9px] font-black uppercase tracking-widest shrink-0">
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 bg-green-100 border border-green-400 rounded-md inline-block"></span>Tersedia</span>
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 bg-red-100 border border-red-400 rounded-md inline-block"></span>Terpesan</span>
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 bg-orange-100 border border-orange-400 rounded-md inline-block"></span>Ditutup</span>
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 bg-primary rounded-md inline-block"></span>Dipilih</span>
        </div>
        <p class="px-6 pt-3 text-[10px] text-charcoal/40 font-medium shrink-0">Klik jam mulai → klik lagi untuk memperpanjang. Minimal 1 jam.</p>

        {{-- Slot grid --}}
        <div class="flex-1 overflow-y-auto p-6">
            <div class="grid grid-cols-4 sm:grid-cols-6 gap-2" id="slotBody"></div>
        </div>

        {{-- Footer: konfirmasi --}}
        <div class="px-6 py-5 border-t border-naomi-bg bg-naomi-bg/30 shrink-0">
            <div id="slotModalSummary" class="hidden mb-4 bg-primary/5 border border-primary/20 rounded-2xl px-4 py-3 flex items-center justify-between">
                <div>
                    <p class="text-[9px] font-black uppercase tracking-widest text-charcoal/40 mb-0.5">Waktu Dipilih</p>
                    <p id="slotModalTime" class="font-black text-primary text-sm"></p>
                </div>
                <button onclick="clearSlot()" class="text-charcoal/30 hover:text-red-500 transition-colors">
                    <span class="material-symbols-outlined text-base">close</span>
                </button>
            </div>
            <button onclick="confirmSlot()"
                    class="w-full bg-primary text-naomi-white py-3.5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-lg shadow-primary/20 hover:bg-charcoal transition-all flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-sm">check_circle</span>
                Konfirmasi Jam
            </button>
        </div>
    </div>
</div>

{{-- Modal Alur Booking --}}
<div id="bookingFlowModal" class="hidden fixed inset-0 bg-charcoal/70 backdrop-blur-sm flex items-center justify-center z-50 p-4" onclick="handleBookingFlowBackdrop(event)">
    <div class="bg-naomi-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden">

        {{-- Header --}}
        <div class="bg-charcoal px-6 py-5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-naomi-white/70 text-xl">info</span>
                <h3 class="font-black text-naomi-white text-base">Alur Booking</h3>
            </div>
            <button onclick="closeBookingFlowModal()" class="size-9 bg-white/10 hover:bg-white/20 rounded-xl flex items-center justify-center transition-all">
                <span class="material-symbols-outlined text-white text-lg">close</span>
            </button>
        </div>

        {{-- Steps --}}
        <div class="p-6 space-y-4">
            <div class="flex items-start gap-4">
                <div class="size-8 bg-primary text-white rounded-xl flex items-center justify-center text-xs font-black shrink-0">1</div>
                <div>
                    <p class="font-black text-charcoal text-sm">Pilih Studio &amp; Tanggal</p>
                    <p class="text-charcoal/50 text-xs mt-0.5">Pilih studio yang kamu inginkan, lalu klik tanggal yang tersedia di kalender.</p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <div class="size-8 bg-primary text-white rounded-xl flex items-center justify-center text-xs font-black shrink-0">2</div>
                <div>
                    <p class="font-black text-charcoal text-sm">Pilih Slot Jam</p>
                    <p class="text-charcoal/50 text-xs mt-0.5">Pilih jam mulai dan perpanjang durasi sesuai kebutuhan. Minimal 1 jam.</p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <div class="size-8 bg-primary text-white rounded-xl flex items-center justify-center text-xs font-black shrink-0">3</div>
                <div>
                    <p class="font-black text-charcoal text-sm">Checkout &amp; Bayar DP</p>
                    <p class="text-charcoal/50 text-xs mt-0.5">Tambahkan slot ke keranjang, lalu checkout dan lakukan pembayaran DP.</p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <div class="size-8 bg-charcoal/20 text-charcoal rounded-xl flex items-center justify-center text-xs font-black shrink-0">4</div>
                <div>
                    <p class="font-black text-charcoal text-sm">Konfirmasi Admin</p>
                    <p class="text-charcoal/50 text-xs mt-0.5">Admin akan memverifikasi pembayaran DP dan mengkonfirmasi booking kamu.</p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <div class="size-8 bg-charcoal/20 text-charcoal rounded-xl flex items-center justify-center text-xs font-black shrink-0">5</div>
                <div>
                    <p class="font-black text-charcoal text-sm">Pelunasan Sebelum Sesi</p>
                    <p class="text-charcoal/50 text-xs mt-0.5">Lunasi sisa pembayaran sebelum sesi dimulai agar booking tetap aktif.</p>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="px-6 pb-6">
            <button onclick="closeBookingFlowModal()"
                    class="w-full py-3.5 bg-charcoal text-naomi-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-primary transition-all">Mengerti</button>
        </div>
    </div>
</div>

{{-- Modal Error --}}
<div id="errorModal" class="hidden fixed inset-0 bg-charcoal/60 backdrop-blur-sm flex items-center justify-center z-50 p-6">
    <div class="bg-naomi-white rounded-3xl p-10 max-w-sm w-full text-center shadow-2xl">
        <div class="size-16 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <span class="material-symbols-outlined text-3xl">error</span>
        </div>
        <h3 class="serif-title text-2xl font-bold text-charcoal mb-3">Oops!</h3>
        <p id="errorMessage" class="text-charcoal/70 mb-8 font-medium text-sm"></p>
        <button onclick="document.getElementById('errorModal').classList.add('hidden')"
                class="w-full py-3.5 bg-charcoal text-naomi-white rounded-2xl font-black text-xs uppercase tracking-widest">Tutup</button>
    </div>
</div>

<script>
const studios      = @json($studiosJson);
const bookedSlots  = @json($bookedSlots);
const closedSlots  = @json($closedSlots);

let currentStudioIndex = 0;
let selectedStartTime  = null;
let selectedEndTime    = null;
let selectedDateStr    = null;

// ── STUDIO SWITCH ──────────────────────────────────────────────
function switchStudio(index) {
    currentStudioIndex = index;
    studios.forEach((_, i) => {
        const btn = document.getElementById('btnStudio' + i);
        if (i === index) {
            btn.classList.add('border-2','border-primary','shadow-lg','shadow-primary/10');
            btn.classList.remove('border','border-charcoal/10');
            btn.querySelector('p:first-child').classList.replace('text-charcoal/60','text-charcoal');
            btn.querySelector('p:last-child').classList.replace('text-charcoal/40','text-primary');
        } else {
            btn.classList.remove('border-2','border-primary','shadow-lg','shadow-primary/10');
            btn.classList.add('border','border-charcoal/10');
            btn.querySelector('p:first-child').classList.replace('text-charcoal','text-charcoal/60');
            btn.querySelector('p:last-child').classList.replace('text-primary','text-charcoal/40');
        }
    });
    document.getElementById('studioNameDisplay').textContent = studios[index].name;
    document.getElementById('inputStudioId').value = studios[index].id;
    selectedStartTime = null;
    selectedEndTime   = null;
    if (selectedDateStr) generateSlots();
    updateSummary();
}

// ── CALENDAR ───────────────────────────────────────────────────
function selectDate(dateStr, day) {
    selectedDateStr   = dateStr;
    selectedStartTime = null;
    selectedEndTime   = null;

    // Highlight selected day
    document.querySelectorAll('#calendarGrid button').forEach(b => {
        b.classList.remove('bg-primary','text-white','shadow-md');
    });
    const btn = document.getElementById('calDay' + day);
    if (btn) btn.classList.add('bg-primary','text-white','shadow-md');

    // Show selected date badge
    const d    = new Date(dateStr + 'T00:00:00');
    const opts = { weekday:'long', day:'numeric', month:'long', year:'numeric' };
    document.getElementById('selectedDateText').textContent = d.toLocaleDateString('id-ID', opts);
    document.getElementById('selectedDateDisplay').classList.remove('hidden');

    document.getElementById('startDate').value = dateStr;
    document.getElementById('inputDate').value = dateStr;

    // Buka modal slot jam
    document.getElementById('slotModalDate').textContent = d.toLocaleDateString('id-ID', opts);
    document.getElementById('slotModal').classList.remove('hidden');
    document.getElementById('slotModal').classList.add('flex');
    generateSlots();
    updateSummary();
}

function clearDate() {
    selectedDateStr   = null;
    selectedStartTime = null;
    selectedEndTime   = null;
    document.getElementById('startDate').value = '';
    document.getElementById('inputDate').value = '';
    document.getElementById('selectedDateDisplay').classList.add('hidden');
    document.querySelectorAll('#calendarGrid button').forEach(b => {
        b.classList.remove('bg-primary','text-white','shadow-md');
    });
    updateSummary();
}

function closeSlotModal() {
    document.getElementById('slotModal').classList.add('hidden');
    document.getElementById('slotModal').classList.remove('flex');
}

function clearSlot() {
    selectedStartTime = null;
    selectedEndTime   = null;
    document.getElementById('slotModalSummary').classList.add('hidden');
    generateSlots();
    updateSummary();
}

function confirmSlot() {
    if (!selectedStartTime) { showError('Pilih slot waktu terlebih dahulu.'); return; }
    closeSlotModal();
    updateSummary();
}

// ── SLOT GRID ──────────────────────────────────────────────────
function generateSlots() {
    const container = document.getElementById('slotBody');
    container.innerHTML = '';
    const studio = studios[currentStudioIndex];

    // Jam operasional: Minggu 12:00-22:00, Senin-Sabtu 10:00-22:00
    const d        = new Date(selectedDateStr + 'T00:00:00');
    const isSunday = d.getDay() === 0;
    const startHour = isSunday ? 12 : 10;
    const endHour   = 22; // slot terakhir 21:30 (end 22:00)

    for (let hour = startHour; hour < endHour; hour++) {
        [0, 30].forEach(min => {
            const timeStr    = `${String(hour).padStart(2,'0')}:${String(min).padStart(2,'0')}`;
            const isBooked   = selectedDateStr ? isSlotBooked(studio.id, selectedDateStr, timeStr) : false;
            const isClosed   = selectedDateStr ? isSlotClosed(studio.id, selectedDateStr, timeStr) : false;
            const isSelected = selectedStartTime && selectedEndTime && timeStr >= selectedStartTime && timeStr < selectedEndTime;

            const div = document.createElement('div');
            div.className = 'rounded-2xl text-center py-3 px-1 transition-all select-none ' +
                (isClosed
                    ? 'bg-orange-50 text-orange-400 border border-orange-200 cursor-not-allowed'
                    : isBooked
                        ? 'bg-red-50 text-red-400 border border-red-100 cursor-not-allowed'
                        : isSelected
                            ? 'bg-primary text-white border border-primary shadow-md cursor-pointer'
                            : 'bg-green-50 text-green-700 border border-green-200 hover:bg-green-100 cursor-pointer');

            div.innerHTML = `<div class="font-black text-xs">${timeStr}</div>`;
            if (!isBooked && !isClosed) div.onclick = () => selectSlot(timeStr);
            container.appendChild(div);
        });
    }
}

function isSlotBooked(studioId, date, time) {
    return bookedSlots.some(b =>
        b.studio_id == studioId &&
        b.date <= date && (b.end_date >= date || b.date === date) &&
        b.start_time <= time && b.end_time > time
    );
}

function isSlotClosed(studioId, date, time) {
    // Slot pada waktu `time` (HH:MM) dianggap tertutup jika ada closure yang:
    // closure.start_time <= time < closure.end_time (overlap dengan slot 30 menit mulai dari time)
    const timeEnd = addMinutes(time, 30);
    return closedSlots.some(c =>
        c.studio_id == studioId &&
        c.date === date &&
        c.start_time < timeEnd && c.end_time > time
    );
}

function selectSlot(time) {
    if (!selectedDateStr) { showError('Pilih tanggal terlebih dahulu.'); return; }

    if (!selectedStartTime) {
        selectedStartTime = time;
        selectedEndTime   = addMinutes(time, 60);
    } else if (time < selectedStartTime) {
        selectedStartTime = time;
        selectedEndTime   = addMinutes(time, 60);
    } else if (time === selectedStartTime) {
        selectedStartTime = null;
        selectedEndTime   = null;
    } else {
        const newEnd = addMinutes(time, 30);
        const minEnd = addMinutes(selectedStartTime, 60);
        selectedEndTime = newEnd > minEnd ? newEnd : minEnd;
    }

    // Pastikan range yang dipilih tidak mencakup slot yang tertutup
    if (selectedStartTime && selectedEndTime) {
        const studio = studios[currentStudioIndex];
        const hasClosedInRange = closedSlots.some(c =>
            c.studio_id == studio.id &&
            c.date === selectedDateStr &&
            c.start_time < selectedEndTime && c.end_time > selectedStartTime
        );
        if (hasClosedInRange) {
            showError('Slot yang dipilih mencakup waktu yang ditutup. Pilih slot lain.');
            selectedStartTime = null;
            selectedEndTime   = null;
            generateSlots();
            document.getElementById('slotModalSummary').classList.add('hidden');
            updateSummary();
            return;
        }
    }

    generateSlots();

    // Update summary di modal
    const summary = document.getElementById('slotModalSummary');
    if (selectedStartTime) {
        document.getElementById('slotModalTime').textContent = `${selectedStartTime} – ${selectedEndTime}`;
        summary.classList.remove('hidden');
    } else {
        summary.classList.add('hidden');
    }

    updateSummary();
}

function addMinutes(time, mins) {
    const [h, m] = time.split(':').map(Number);
    const total  = h * 60 + m + mins;
    return `${String(Math.floor(total/60)).padStart(2,'0')}:${String(total%60).padStart(2,'0')}`;
}

function getDurationHours(start, end) {
    const [sh, sm] = start.split(':').map(Number);
    const [eh, em] = end.split(':').map(Number);
    return ((eh * 60 + em) - (sh * 60 + sm)) / 60;
}

// ── SUMMARY ────────────────────────────────────────────────────
function updateSummary() {
    const studio       = studios[currentStudioIndex];
    const participants = parseInt(document.getElementById('inputParticipant')?.value || 1);

    document.getElementById('inputStartTime').value = selectedStartTime || '';
    document.getElementById('inputEndTime').value   = selectedEndTime   || '';

    const warning = document.getElementById('participantWarning');
    if (studio.extra_price_threshold > 0 && participants > studio.extra_price_threshold) {
        warning.textContent = `Lebih dari ${studio.extra_price_threshold} orang → tarif Rp${studio.extra_price_per_hour.toLocaleString('id-ID')}/jam`;
        warning.classList.remove('hidden');
    } else if (participants > studio.capacity) {
        warning.textContent = `Melebihi kapasitas maksimal (${studio.capacity} orang)`;
        warning.classList.remove('hidden');
    } else {
        warning.classList.add('hidden');
    }

    if (!selectedDateStr || !selectedStartTime) {
        document.getElementById('displayDate').textContent   = '—';
        document.getElementById('displayTime').textContent   = '—';
        document.getElementById('displayDurasi').textContent = '—';
        document.getElementById('displayTotal').textContent  = 'Rp 0';
        document.getElementById('displayDP').textContent     = 'Rp 0';
        document.getElementById('inputDuration').value = '';
        return;
    }

    const duration     = getDurationHours(selectedStartTime, selectedEndTime);
    const pricePerHour = (studio.extra_price_threshold > 0 && participants > studio.extra_price_threshold)
        ? studio.extra_price_per_hour : studio.price_per_hour;
    const total = pricePerHour * duration;
    const dp    = studio.min_dp_amount;

    document.getElementById('inputDuration').value        = duration;
    document.getElementById('displayDate').textContent    = selectedDateStr;
    document.getElementById('displayTime').textContent    = `${selectedStartTime} – ${selectedEndTime}`;
    document.getElementById('displayDurasi').textContent  = `${duration} jam`;
    document.getElementById('displayTotal').textContent   = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('displayDP').textContent      = 'Rp ' + dp.toLocaleString('id-ID');
}

// ── CART ───────────────────────────────────────────────────────
function addToCart() {
    if (!selectedDateStr)   { showError('Pilih tanggal terlebih dahulu.'); return; }
    if (!selectedStartTime) { showError('Pilih slot waktu terlebih dahulu.'); return; }
    document.getElementById('addCartForm').submit();
}

function showError(msg) {
    document.getElementById('errorMessage').textContent = msg;
    document.getElementById('errorModal').classList.remove('hidden');
    document.getElementById('errorModal').classList.add('flex');
}

// ── BOOKING FLOW MODAL ────────────────────────────────────────
function openBookingFlowModal() {
    const modal = document.getElementById('bookingFlowModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeBookingFlowModal() {
    const modal = document.getElementById('bookingFlowModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function handleBookingFlowBackdrop(event) {
    if (event.target === document.getElementById('bookingFlowModal')) {
        closeBookingFlowModal();
    }
}

// ── INIT ───────────────────────────────────────────────────────
function updateCalendar() { /* kept for compatibility */ }

document.addEventListener('DOMContentLoaded', () => {
    switchStudio({{ $selectedStudioIndex }});
});
</script>
@endsection
