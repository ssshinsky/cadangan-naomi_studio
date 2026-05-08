@extends('layouts.app')

@section('title', 'Riwayat Booking - Naomi Studio')

@section('content')
<main class="bg-naomi-bg min-h-screen pb-20">
    <div class="max-w-7xl mx-auto px-6 py-20">
        <div class="flex flex-col lg:flex-row gap-10">

            {{-- SIDEBAR --}}
            <div class="w-full lg:w-72 shrink-0">
                <div class="bg-naomi-white rounded-[2.5rem] p-8 shadow-sm border border-charcoal/10">
                    <div class="flex items-center gap-4 mb-10 pb-6 border-b border-naomi-bg">
                        <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-primary/20">
                            @if($customer->avatar)
                                <img src="{{ asset('storage/' . $customer->avatar) }}" class="w-full h-full object-cover" alt="Avatar">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&background=2D2A28&color=fff&bold=true"
                                     class="w-full h-full object-cover" alt="Avatar">
                            @endif
                        </div>
                        <div>
                            <p class="font-black text-charcoal leading-tight">{{ $customer->name }}</p>
                            <p class="text-[10px] text-charcoal/40 uppercase tracking-widest mt-1 font-bold">Member</p>
                        </div>
                    </div>
                    <nav class="space-y-2">
                        <a href="{{ route('profil') }}"
                           class="flex items-center gap-3 px-4 py-4 hover:bg-naomi-bg rounded-2xl text-charcoal/60 font-black text-[11px] uppercase tracking-wider transition-all whitespace-nowrap">
                            <span class="material-symbols-outlined text-lg shrink-0">person</span>
                            Profil Saya
                        </a>
                        <a href="{{ route('profil.riwayat-booking') }}"
                           class="flex items-center gap-3 px-4 py-4 bg-primary text-naomi-white rounded-2xl font-black text-[11px] uppercase tracking-wider shadow-lg shadow-primary/20 whitespace-nowrap">
                            <span class="material-symbols-outlined text-lg shrink-0">history</span>
                            Riwayat Booking
                        </a>
                        <div class="pt-6 border-t border-naomi-bg mt-4">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-4 text-red-500/60 hover:text-red-500 hover:bg-red-50 rounded-2xl font-black text-[11px] uppercase tracking-wider transition-all">
                                    <span class="material-symbols-outlined text-lg shrink-0">logout</span>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </nav>
                </div>
            </div>

            {{-- KONTEN --}}
            <div class="flex-1 space-y-8">
                <div class="mb-12">
                    <h1 class="serif-title text-5xl font-bold text-charcoal tracking-tighter">Riwayat Booking</h1>
                    <p class="text-charcoal/50 mt-3 font-medium">Pantau status pemesanan studio Anda secara real-time.</p>
                </div>

                <div class="flex gap-8 border-b border-charcoal/5 mb-10">
                    <button onclick="switchTab(0)" id="tab0"
                            class="tab-button pb-6 border-b-4 border-primary text-charcoal font-black text-[10px] uppercase tracking-[0.2em] transition-all">
                        Pemesanan Aktif
                    </button>
                    <button onclick="switchTab(1)" id="tab1"
                            class="tab-button pb-6 border-b-4 border-transparent text-charcoal/30 font-black text-[10px] uppercase tracking-[0.2em] hover:text-charcoal transition-all">
                        Riwayat Selesai
                    </button>
                </div>

                {{-- TAB AKTIF --}}
                <div id="content0" class="tab-content space-y-8">
                    @forelse($activeBookings as $booking)
                    @php $displayStatus = $booking->getDisplayStatus(); @endphp
                    <div class="group bg-naomi-white rounded-[2.5rem] overflow-hidden border border-charcoal/5 hover:shadow-2xl hover:shadow-charcoal/5 transition-all duration-500 flex flex-col md:flex-row">
                        <div class="md:w-72 h-64 relative overflow-hidden shrink-0">
                            @if($booking->studio->primaryImage)
                                <img src="{{ asset('storage/' . $booking->studio->primaryImage->image_url) }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $booking->studio->name }}">
                            @else
                                <div class="w-full h-full bg-naomi-surface flex items-center justify-center">
                                    <span class="material-symbols-outlined text-5xl text-naomi-muted">image</span>
                                </div>
                            @endif
                            <div class="absolute top-6 left-6">
                                <x-booking-status :status="$displayStatus" />
                            </div>
                        </div>
                        <div class="flex-1 p-10 flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-start mb-4">
                                    <h3 class="serif-title text-3xl font-bold text-charcoal">Sewa {{ $booking->studio->name }}</h3>
                                    <p class="text-[10px] font-black text-primary bg-primary/5 px-3 py-1 rounded-lg">{{ $booking->booking_code }}</p>
                                </div>
                                <div class="space-y-3">
                                    <div class="flex items-center gap-3 text-charcoal/60">
                                        <span class="material-symbols-outlined text-lg">calendar_today</span>
                                        <span class="text-sm font-medium">{{ $booking->date->format('l, d M Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-3 text-charcoal/60">
                                        <span class="material-symbols-outlined text-lg">schedule</span>
                                        <span class="text-sm font-medium">{{ substr($booking->start_time, 0, 5) }} – {{ substr($booking->end_time, 0, 5) }} ({{ $booking->duration_hours }} Jam)</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-8 flex items-center justify-between border-t border-naomi-bg pt-6">
                                <div>
                                    <p class="text-[9px] font-black text-charcoal/30 uppercase tracking-widest mb-1">Total Bayar</p>
                                    <p class="text-xl font-black text-primary">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                </div>
                                <div class="flex gap-3 flex-wrap justify-end">
                                    @if($displayStatus === 'pending')
                                        <a href="{{ route('checkout', ['booking_id' => $booking->id]) }}"
                                           class="px-6 py-3 bg-primary text-naomi-white text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-charcoal transition-all shadow-xl shadow-primary/20">
                                            Bayar Sekarang
                                        </a>
                                        <form method="POST" action="{{ route('profil.booking.cancel', $booking->id) }}" id="cancelBooking{{ $booking->id }}">
                                            @csrf
                                            <button type="button"
                                                onclick="naomiConfirm(
                                                    'Batalkan booking <strong>{{ $booking->booking_code }}</strong>? Tindakan ini tidak bisa dibatalkan.',
                                                    () => document.getElementById('cancelBooking{{ $booking->id }}').submit(),
                                                    { danger: true, confirmText: 'Ya, Batalkan' }
                                                )"
                                                class="px-6 py-3 border border-red-200 text-red-500 text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-red-50 transition-all">
                                                Batalkan
                                            </button>
                                        </form>
                                    @elseif($displayStatus === 'confirmed' || $displayStatus === 'waiting_settlement')
                                        <a href="{{ route('profil.invoice', $booking->id) }}"
                                           class="px-6 py-3 bg-blue-600 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-blue-700 transition-all shadow-lg flex items-center gap-2">
                                            <span class="material-symbols-outlined text-sm">download</span>
                                            Invoice PDF
                                        </a>
                                    @endif
                                    <a href="{{ route('profil.booking-detail', $booking->id) }}"
                                       class="px-6 py-3 border border-charcoal/10 text-charcoal text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-naomi-bg transition-all">
                                        Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="bg-naomi-white rounded-[3rem] p-20 text-center border border-charcoal/5">
                        <div class="w-20 h-20 bg-naomi-bg rounded-[2rem] flex items-center justify-center mx-auto mb-8">
                            <span class="material-symbols-outlined text-4xl text-charcoal/20">calendar_today</span>
                        </div>
                        <h3 class="serif-title text-2xl font-bold text-charcoal">Belum ada booking aktif</h3>
                        <p class="text-charcoal/40 mt-2 font-medium">Yuk booking studio sekarang!</p>
                    </div>
                    @endforelse
                </div>

                {{-- TAB SELESAI --}}
                <div id="content1" class="tab-content hidden space-y-8">
                    @forelse($completedBookings as $booking)
                    @php $displayStatus = $booking->getDisplayStatus(); @endphp
                    <div class="group bg-naomi-white rounded-[2.5rem] overflow-hidden border border-charcoal/5 hover:shadow-2xl transition-all duration-500 flex flex-col md:flex-row">
                        <div class="md:w-72 h-64 relative overflow-hidden shrink-0">
                            @if($booking->studio->primaryImage)
                                <img src="{{ asset('storage/' . $booking->studio->primaryImage->image_url) }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $booking->studio->name }}">
                            @else
                                <div class="w-full h-full bg-naomi-surface flex items-center justify-center">
                                    <span class="material-symbols-outlined text-5xl text-naomi-muted">image</span>
                                </div>
                            @endif
                            <div class="absolute top-6 left-6">
                                <x-booking-status :status="$displayStatus" />
                            </div>
                        </div>
                        <div class="flex-1 p-10 flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-start mb-4">
                                    <h3 class="serif-title text-3xl font-bold text-charcoal">Sewa {{ $booking->studio->name }}</h3>
                                    <p class="text-[10px] font-black text-primary bg-primary/5 px-3 py-1 rounded-lg">{{ $booking->booking_code }}</p>
                                </div>
                                <div class="space-y-3">
                                    <div class="flex items-center gap-3 text-charcoal/60">
                                        <span class="material-symbols-outlined text-lg">calendar_today</span>
                                        <span class="text-sm font-medium">{{ $booking->date->format('l, d M Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-3 text-charcoal/60">
                                        <span class="material-symbols-outlined text-lg">schedule</span>
                                        <span class="text-sm font-medium">{{ substr($booking->start_time, 0, 5) }} – {{ substr($booking->end_time, 0, 5) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-8 flex items-center justify-end">
                                <a href="{{ route('profil.booking-detail', $booking->id) }}"
                                   class="px-6 py-3 bg-charcoal text-naomi-white text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-primary transition-all shadow-lg">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="bg-naomi-white rounded-[3rem] p-20 text-center border border-charcoal/5">
                        <div class="w-20 h-20 bg-naomi-bg rounded-[2rem] flex items-center justify-center mx-auto mb-8">
                            <span class="material-symbols-outlined text-4xl text-charcoal/20">history</span>
                        </div>
                        <h3 class="serif-title text-2xl font-bold text-charcoal">Belum ada riwayat</h3>
                        <p class="text-charcoal/40 mt-2 font-medium">Booking yang sudah selesai akan muncul di sini.</p>
                    </div>
                    @endforelse
                </div>

                {{-- CTA --}}
                <div class="mt-20 bg-charcoal rounded-[3rem] p-12 text-center relative overflow-hidden">
                    <div class="relative z-10">
                        <h2 class="serif-title text-4xl font-bold text-naomi-white mb-4">Butuh Jadwal Baru?</h2>
                        <p class="text-naomi-white/50 max-w-md mx-auto font-medium mb-10 text-sm">Amankan slot studio favoritmu sebelum penuh.</p>
                        <a href="{{ route('studios.index') }}"
                           class="inline-flex items-center gap-4 bg-primary text-naomi-white px-10 py-5 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:scale-105 transition-all shadow-2xl shadow-primary/20">
                            Eksplor Studio
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
function switchTab(tab) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    document.getElementById('content' + tab).classList.remove('hidden');
    document.querySelectorAll('.tab-button').forEach(el => {
        el.classList.remove('border-primary', 'text-charcoal');
        el.classList.add('border-transparent', 'text-charcoal/30');
    });
    const activeTab = document.getElementById('tab' + tab);
    activeTab.classList.add('border-primary', 'text-charcoal');
    activeTab.classList.remove('border-transparent', 'text-charcoal/30');
}
</script>
@endsection
