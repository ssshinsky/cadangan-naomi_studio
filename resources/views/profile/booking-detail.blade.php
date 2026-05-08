@extends('layouts.app')

@section('title', 'Detail Pemesanan - Naomi Studio')

@section('content')
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

        {{-- MAIN CONTENT --}}
        <div class="flex-1">
            <div class="flex justify-between items-start mb-10">
                <div>
                    <h1 class="serif-title text-4xl font-bold text-charcoal">Detail Pemesanan</h1>
                    <p class="text-charcoal/50 mt-1">Laporan lengkap transaksi Anda pada Naomi Studio</p>
                </div>
                <a href="{{ route('profil.riwayat-booking') }}"
                   class="text-primary hover:underline text-sm font-medium flex items-center gap-1">
                    ← Kembali
                </a>
            </div>

            <div class="bg-naomi-white rounded-[3rem] shadow-sm border border-charcoal/5 overflow-hidden">

                {{-- Summary --}}
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div>
                            <span class="text-[10px] uppercase tracking-widest text-charcoal/40 font-black">ID Transaksi</span>
                            <div class="flex items-center gap-3 mt-1">
                                <p class="text-2xl font-bold text-charcoal">{{ $booking->booking_code }}</p>
                                <x-booking-status :status="$booking->getDisplayStatus()" />
                            </div>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-widest text-charcoal/40 font-black">Layanan</span>
                            <p class="font-semibold text-lg text-charcoal mt-1">Sewa {{ $booking->studio->name }}</p>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-widest text-charcoal/40 font-black">Waktu</span>
                            <div class="mt-2 space-y-1">
                                <div class="flex items-center gap-3 text-charcoal/70">
                                    <span class="material-symbols-outlined text-primary">calendar_today</span>
                                    <span>{{ $booking->date->format('l, d F Y') }}</span>
                                </div>
                                <div class="flex items-center gap-3 text-charcoal/70">
                                    <span class="material-symbols-outlined text-primary">schedule</span>
                                    <span>{{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }} ({{ $booking->duration_hours }} Jam)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6 border-t md:border-t-0 md:border-l border-naomi-bg pt-6 md:pt-0 md:pl-8">
                        @if($booking->payments->isNotEmpty())
                        <div>
                            <span class="text-[10px] uppercase tracking-widest text-charcoal/40 font-black">Metode Pembayaran</span>
                            <div class="flex items-center gap-3 mt-3">
                                <div class="px-4 py-2 bg-naomi-bg rounded-lg text-sm font-bold text-charcoal uppercase">
                                    {{ str_replace('transfer_', '', $booking->payments->last()->payment_method) }}
                                </div>
                            </div>
                            <p class="text-xs text-charcoal/40 mt-1">
                                Dibayar pada {{ $booking->payments->last()->paid_at?->format('d M Y, H:i') ?? '-' }}
                            </p>
                        </div>
                        @endif

                        <div class="bg-primary/5 rounded-2xl p-5">
                            <span class="text-[10px] uppercase tracking-widest text-primary font-black">Status Pembayaran</span>
                            @php $lastPayment = $booking->payments->last(); @endphp
                            @if($lastPayment && $lastPayment->status === 'verified')
                                <div class="flex items-center gap-3 mt-3">
                                    @if($booking->remaining_amount == 0)
                                        <x-payment-status status="verified" />
                                        <span class="text-xl font-bold text-blue-600">LUNAS</span>
                                    @else
                                        <x-payment-status status="dp" />
                                        <span class="text-xl font-bold text-amber-600">DP</span>
                                    @endif
                                </div>
                            @elseif($lastPayment && $lastPayment->status === 'pending')
                                <div class="flex items-center gap-3 mt-3">
                                    <span class="material-symbols-outlined text-slate-400 text-3xl">hourglass_empty</span>
                                    <span class="text-xl font-bold text-slate-500">MENUNGGU VERIFIKASI</span>
                                </div>
                            @else
                                <div class="flex items-center gap-3 mt-3">
                                    <span class="material-symbols-outlined text-charcoal/30 text-3xl">payments</span>
                                    <span class="text-xl font-bold text-charcoal/30">BELUM BAYAR</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Rincian Biaya --}}
                <div class="px-8 pb-8">
                    <div class="bg-naomi-bg rounded-2xl p-6">
                        <h3 class="serif-title text-2xl font-bold mb-5 border-b border-charcoal/5 pb-3 text-charcoal">Rincian Biaya</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between text-charcoal/70">
                                <span>Sewa {{ $booking->studio->name }} ({{ $booking->duration_hours }} Jam × Rp{{ number_format($booking->studio->price_per_hour, 0, ',', '.') }})</span>
                                <span class="font-medium">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</span>
                            </div>
                            @if($booking->dp_amount > 0)
                            <div class="flex justify-between text-charcoal/70">
                                <span>DP Dibayar</span>
                                <span class="font-medium text-green-600">- Rp{{ number_format($booking->dp_amount, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            <div class="pt-4 border-t border-charcoal/5 flex justify-between text-lg font-bold text-charcoal">
                                <span>Sisa Tagihan</span>
                                <span class="text-primary">Rp{{ number_format($booking->remaining_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Info --}}
                <div class="px-8 pb-10">
                    <h3 class="serif-title text-2xl font-bold mb-5 flex items-center gap-2 text-charcoal">
                        <span class="material-symbols-outlined text-primary">info</span>
                        Apa langkah selanjutnya?
                    </h3>
                    <ul class="space-y-4">
                        <li class="flex gap-4">
                            <div class="mt-1 w-6 h-6 bg-primary/10 text-primary rounded-full flex items-center justify-center text-sm font-bold shrink-0">1</div>
                            <p class="text-sm text-charcoal/60">Harap datang 15 menit sebelum waktu pemesanan untuk proses registrasi di resepsionis.</p>
                        </li>
                        <li class="flex gap-4">
                            <div class="mt-1 w-6 h-6 bg-primary/10 text-primary rounded-full flex items-center justify-center text-sm font-bold shrink-0">2</div>
                            <p class="text-sm text-charcoal/60">Gunakan pakaian yang nyaman dan bawa sepatu indoor jika diperlukan.</p>
                        </li>
                        <li class="flex gap-4">
                            <div class="mt-1 w-6 h-6 bg-primary/10 text-primary rounded-full flex items-center justify-center text-sm font-bold shrink-0">3</div>
                            <p class="text-sm text-charcoal/60">Tunjukkan ID Transaksi <strong>{{ $booking->booking_code }}</strong> kepada petugas di lokasi.</p>
                        </li>
                    </ul>
                </div>

                {{-- Actions --}}
                <div class="px-8 py-8 bg-naomi-bg/50 border-t border-charcoal/5 flex flex-col sm:flex-row items-center gap-4">
                    @php $displayStatus = $booking->getDisplayStatus(); @endphp

                    @if($displayStatus === 'pending')
                        <a href="{{ route('checkout', ['booking_id' => $booking->id]) }}"
                           class="flex-1 w-full flex items-center justify-center gap-3 px-10 py-5 bg-primary text-naomi-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-xl shadow-primary/20 hover:bg-charcoal transition-all">
                            <span class="material-symbols-outlined text-lg">payments</span>
                            Bayar Sekarang
                        </a>
                    @elseif(in_array($displayStatus, ['confirmed', 'waiting_settlement', 'completed']))
                        <a href="{{ route('profil.invoice', $booking->id) }}"
                           class="flex-1 w-full flex items-center justify-center gap-3 px-10 py-5 bg-blue-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-xl hover:bg-blue-700 transition-all">
                            <span class="material-symbols-outlined text-lg">download</span>
                            Download Invoice PDF
                        </a>
                    @endif

                    <a href="{{ route('profil.riwayat-booking') }}"
                       class="flex-1 w-full flex items-center justify-center gap-3 px-10 py-5 border-2 border-charcoal/10 text-charcoal rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-naomi-bg transition-all">
                        <span class="material-symbols-outlined text-lg">arrow_back</span>
                        Kembali ke Riwayat
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
