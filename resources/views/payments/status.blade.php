@extends('layouts.app')

@section('title', 'Status Pemesanan - Naomi Studio')

@section('content')
<main class="bg-naomi-bg min-h-screen pb-20">
    <div class="max-w-2xl mx-auto px-6 py-16">

        {{-- SUCCESS ICON --}}
        <div class="text-center mb-10">
            <div class="relative inline-flex">
                <div class="w-28 h-28 bg-green-50 border-4 border-green-200 rounded-[2.5rem] flex items-center justify-center shadow-xl shadow-green-100">
                    <span class="material-symbols-outlined text-6xl text-green-500" style="font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24">check_circle</span>
                </div>
                <span class="absolute -top-2 -right-2 w-8 h-8 bg-primary rounded-full flex items-center justify-center shadow-lg">
                    <span class="material-symbols-outlined text-white text-base">receipt_long</span>
                </span>
            </div>

            <h1 class="serif-title text-4xl md:text-5xl font-bold text-charcoal mt-8 mb-3 tracking-tighter">
                Pembayaran Diterima!
            </h1>
            <p class="text-charcoal/60 font-medium text-lg max-w-sm mx-auto leading-relaxed">
                Bukti pembayaran kamu sudah kami terima dan sedang dalam proses verifikasi.
            </p>
        </div>

        {{-- STATUS CARD --}}
        <div class="bg-amber-50 border-2 border-amber-200 rounded-3xl px-8 py-5 flex items-center gap-4 mb-8">
            <div class="size-10 bg-amber-100 rounded-xl flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-amber-500 text-xl">hourglass_empty</span>
            </div>
            <div>
                <p class="font-black text-amber-700 text-sm uppercase tracking-widest">Menunggu Verifikasi Admin</p>
                <p class="text-amber-600/80 text-xs mt-0.5">Status akan diperbarui setelah admin mengkonfirmasi</p>
            </div>
        </div>

        {{-- BOOKING CARDS --}}
        <div class="space-y-4 mb-8">
            @foreach($bookings as $booking)
            <div class="bg-naomi-white rounded-[2.5rem] border border-charcoal/5 shadow-sm overflow-hidden">
                <div class="px-8 py-6 flex items-center gap-5 border-b border-naomi-bg">
                    <div class="size-12 bg-primary/10 rounded-2xl flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-primary text-2xl">calendar_today</span>
                    </div>
                    <div class="flex-1">
                        <p class="font-black text-charcoal">{{ $booking->studio->name }}</p>
                        <p class="text-sm text-charcoal/50 mt-0.5">
                            {{ $booking->date->format('d F Y') }} &nbsp;·&nbsp;
                            {{ substr($booking->start_time, 0, 5) }}–{{ substr($booking->end_time, 0, 5) }} WIB
                        </p>
                    </div>
                    <span class="text-[10px] font-black text-primary bg-primary/5 px-3 py-1.5 rounded-xl">
                        {{ $booking->booking_code }}
                    </span>
                </div>
                <div class="px-8 py-5 grid grid-cols-3 gap-4 text-center">
                    <div>
                        <p class="text-[9px] font-black uppercase tracking-widest text-charcoal/30 mb-1">Total Harga</p>
                        <p class="font-black text-charcoal text-sm">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black uppercase tracking-widest text-charcoal/30 mb-1">Dibayar</p>
                        @if($booking->payments->isNotEmpty())
                        <p class="font-black text-green-600 text-sm">Rp{{ number_format($booking->payments->last()->amount, 0, ',', '.') }}</p>
                        @else
                        <p class="font-black text-charcoal/30 text-sm">—</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-[9px] font-black uppercase tracking-widest text-charcoal/30 mb-1">Sisa</p>
                        <p class="font-black text-sm {{ $booking->remaining_amount > 0 ? 'text-amber-600' : 'text-green-600' }}">
                            {{ $booking->remaining_amount > 0 ? 'Rp'.number_format($booking->remaining_amount, 0, ',', '.') : 'LUNAS ✓' }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- INFO STEPS --}}
        <div class="bg-naomi-white rounded-3xl border border-charcoal/5 shadow-sm px-8 py-7 mb-8">
            <p class="text-[10px] font-black uppercase tracking-widest text-charcoal/40 mb-5">Langkah Selanjutnya</p>
            <div class="space-y-5">
                <div class="flex items-start gap-4">
                    <div class="size-7 bg-primary text-white rounded-full flex items-center justify-center text-xs font-black shrink-0 mt-0.5">1</div>
                    <p class="text-sm text-charcoal/70 leading-relaxed">
                        Pantau status booking kamu secara berkala di halaman
                        <a href="{{ route('profil.riwayat-booking') }}" class="text-primary font-black hover:underline">Riwayat Booking</a>
                        di profil kamu.
                    </p>
                </div>
                <div class="flex items-start gap-4">
                    <div class="size-7 bg-primary text-white rounded-full flex items-center justify-center text-xs font-black shrink-0 mt-0.5">2</div>
                    <p class="text-sm text-charcoal/70 leading-relaxed">
                        Setelah admin memverifikasi, status akan berubah menjadi <span class="font-black text-charcoal">Dikonfirmasi</span> dan kamu bisa download invoice.
                    </p>
                </div>
                <div class="flex items-start gap-4">
                    <div class="size-7 bg-primary text-white rounded-full flex items-center justify-center text-xs font-black shrink-0 mt-0.5">3</div>
                    <p class="text-sm text-charcoal/70 leading-relaxed">
                        Hadir <span class="font-black text-charcoal">10 menit sebelum</span> jadwal dan tunjukkan kode booking saat check-in.
                    </p>
                </div>
            </div>
        </div>

        {{-- ACTIONS --}}
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('profil.riwayat-booking') }}"
               class="flex-1 bg-primary text-naomi-white py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] flex items-center justify-center gap-3 shadow-xl shadow-primary/20 hover:bg-charcoal transition-all">
                <span class="material-symbols-outlined text-lg">history</span>
                Cek Riwayat Booking
            </a>
            <a href="{{ route('home') }}"
               class="flex-1 bg-naomi-white border-2 border-charcoal/10 text-charcoal/60 py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] flex items-center justify-center gap-3 hover:border-primary/30 hover:text-charcoal transition-all">
                <span class="material-symbols-outlined text-lg">home</span>
                Beranda
            </a>
        </div>

    </div>
</main>
@endsection
