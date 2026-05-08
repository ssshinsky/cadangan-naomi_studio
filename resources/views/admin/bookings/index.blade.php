@extends('admin.layouts.admin')

@section('title', 'Kelola Pesanan')

@section('content')

    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-8">
        <div>
            <h2 class="font-serif text-3xl font-bold text-slate-900">Kelola Pesanan</h2>
            <p class="text-slate-500 text-sm mt-1">Verifikasi pembayaran dan kelola status booking</p>
        </div>

        <div class="flex items-center gap-3">
            <form action="{{ route('admin.bookings.index') }}" method="GET" class="flex items-center gap-2">
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari nama / kode booking..."
                           class="pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs focus:ring-1 focus:ring-primary w-56 transition-all outline-none">
                </div>
                <div class="flex items-center gap-2 bg-white border border-slate-200 p-1.5 rounded-2xl shadow-sm">
                <select name="month" class="bg-transparent border-none text-xs font-bold text-slate-700 focus:ring-0 cursor-pointer px-3">
                    <option value="">BULAN</option>
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                            {{ strtoupper(date('F', mktime(0, 0, 0, $m, 1))) }}
                        </option>
                    @endforeach
                </select>
                <div class="w-[1px] h-4 bg-slate-200"></div>
                <select name="year" class="bg-transparent border-none text-xs font-bold text-slate-700 focus:ring-0 cursor-pointer px-3">
                    <option value="">TAHUN</option>
                    @for($y = date('Y'); $y >= 2023; $y--)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
                <button type="submit" class="bg-slate-900 text-white p-2 rounded-xl hover:bg-primary transition-all">
                    <span class="material-symbols-outlined text-sm block">filter_list</span>
                </button>
            </div>
            </form>
        </div>
    </div>

    <div class="flex flex-wrap gap-3 mb-8">
        <a href="{{ route('admin.bookings.index') }}"
           class="px-8 py-2.5 {{ !request('status') ? 'bg-primary text-white' : 'bg-white text-slate-600 border border-slate-100' }} rounded-full text-sm font-semibold shadow-sm">
            Semua
        </a>
        <a href="{{ route('admin.bookings.index', ['status' => 'menunggu']) }}"
           class="px-6 py-2.5 {{ request('status') == 'menunggu' ? 'bg-primary text-white' : 'bg-white text-slate-600 border border-slate-100' }} rounded-full text-sm font-medium hover:bg-slate-50 transition-colors">
            Menunggu Konfirmasi
        </a>
        <a href="{{ route('admin.bookings.index', ['status' => 'dikonfirmasi']) }}"
           class="px-6 py-2.5 {{ request('status') == 'dikonfirmasi' ? 'bg-primary text-white' : 'bg-white text-slate-600 border border-slate-100' }} rounded-full text-sm font-medium hover:bg-slate-50 transition-colors">
            Dikonfirmasi
        </a>
        <a href="{{ route('admin.bookings.index', ['status' => 'ditolak']) }}"
           class="px-6 py-2.5 {{ request('status') == 'ditolak' ? 'bg-primary text-white' : 'bg-white text-slate-600 border border-slate-100' }} rounded-full text-sm font-medium hover:bg-slate-50 transition-colors">
            Dibatalkan
        </a>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em] border-b border-slate-50 bg-slate-50/30">
                        <th class="px-8 py-6">Booking ID</th>
                        <th class="px-6 py-6">Nama Pelanggan</th>
                        <th class="px-6 py-6">Waktu & Ruangan</th>
                        <th class="px-6 py-6 text-center">Status Pembayaran</th>
                        <th class="px-6 py-6 text-center">Status Pemesanan</th>
                        <th class="px-6 py-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($bookings as $booking)
                    @php
                        $lastPayment = $booking->payments->last();
                        $displayStatus = $booking->getDisplayStatus();
                    @endphp
                    <tr class="group hover:bg-slate-50/80 transition-colors">
                        <td class="px-8 py-6">
                            <span class="text-slate-400 text-xs font-medium">{{ $booking->booking_code }}</span>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex items-center gap-3">
                                <div class="size-9 rounded-full bg-primary/10 flex items-center justify-center text-primary text-xs font-bold">
                                    {{ strtoupper(substr($booking->customer->name, 0, 2)) }}
                                </div>
                                <div>
                                    <span class="text-sm font-bold text-slate-800">{{ $booking->customer->name }}</span>
                                    @if($booking->customer->phone)
                                        <p class="text-[10px] text-slate-400">{{ $booking->customer->phone }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <p class="text-sm font-bold text-slate-800">{{ $booking->date->format('d M Y') }}</p>
                            <p class="text-xs text-slate-400 italic">{{ $booking->studio->name }} • {{ substr($booking->start_time,0,5) }}–{{ substr($booking->end_time,0,5) }}</p>
                        </td>
                        <td class="px-6 py-6 text-center">
                            @if(!$lastPayment)
                                <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-[10px] font-black uppercase border border-slate-200 whitespace-nowrap">BELUM BAYAR</span>
                            @elseif($lastPayment->status === 'pending')
                                <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-[10px] font-black uppercase border border-slate-200 whitespace-nowrap">MENUNGGU VERIFIKASI</span>
                            @elseif($booking->remaining_amount == 0)
                                <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-[10px] font-black uppercase border border-blue-200 whitespace-nowrap">LUNAS</span>
                            @else
                                <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-[10px] font-black uppercase border border-amber-200 whitespace-nowrap">DP</span>
                            @endif
                        </td>
                        <td class="px-6 py-6 text-center">
                            <div class="space-y-2">
                                <x-booking-status :status="$displayStatus" />
                                {{-- Tombol konfirmasi pelunasan kalau confirmed + ada sisa --}}
                                @if($booking->booking_status === 'confirmed' && $booking->remaining_amount > 0)
                                <button onclick="document.getElementById('settlementModal{{ $booking->id }}').classList.remove('hidden')"
                                        class="block w-full py-1.5 border border-blue-300 text-blue-600 rounded-full text-[9px] font-black uppercase tracking-wider hover:bg-blue-600 hover:text-white transition-all">
                                    Konfirmasi Pelunasan
                                </button>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-6 text-center">
                            <div class="flex justify-center gap-2">
                                {{-- Lihat detail selalu ada --}}
                                <a href="{{ route('admin.bookings.show', $booking->id) }}"
                                   class="inline-flex items-center justify-center size-9 rounded-xl bg-slate-100 text-charcoal hover:bg-primary hover:text-white transition-all shadow-sm"
                                   title="Lihat Detail">
                                    <span class="material-symbols-outlined text-base">visibility</span>
                                </a>

                                <!-- {{-- Konfirmasi pelunasan kalau confirmed + masih ada sisa --}}
                                @if($booking->booking_status === 'confirmed' && $booking->remaining_amount > 0)
                                <button onclick="document.getElementById('settlementModal{{ $booking->id }}').classList.remove('hidden')"
                                        class="inline-flex items-center justify-center size-9 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all shadow-sm"
                                        title="Konfirmasi Pelunasan">
                                    <span class="material-symbols-outlined text-base">payments</span>
                                </button>
                                @endif -->

                                {{-- Batalkan kalau belum cancelled/completed --}}
                                @if(!in_array($booking->booking_status, ['cancelled', 'completed']))
                                <button onclick="document.getElementById('cancelModal{{ $booking->id }}').classList.remove('hidden')"
                                        class="inline-flex items-center justify-center size-9 rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all shadow-sm"
                                        title="Batalkan Booking">
                                    <span class="material-symbols-outlined text-base">block</span>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-16 text-center text-slate-400">
                            <span class="material-symbols-outlined text-5xl block mb-3">calendar_today</span>
                            Belum ada booking
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-8 py-6 flex items-center justify-between border-t border-slate-50">
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                Menampilkan {{ $bookings->count() }} dari {{ $bookings->total() }} pemesanan
            </p>
            {{ $bookings->links() }}
        </div>
    </div>

@foreach($bookings as $booking)
{{-- Modal Konfirmasi Pelunasan --}}
@if($booking->booking_status === 'confirmed' && $booking->remaining_amount > 0)
<div id="settlementModal{{ $booking->id }}" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50">
    <div class="bg-white rounded-3xl p-10 max-w-sm w-full mx-4 shadow-2xl text-center">
        <span class="material-symbols-outlined text-5xl text-blue-600 mb-4 block">payments</span>
        <h3 class="text-xl font-bold mb-2">Konfirmasi Pelunasan?</h3>
        <p class="text-slate-500 text-sm mb-2">
            Booking: <strong>{{ $booking->booking_code }}</strong>
        </p>
        <p class="text-slate-500 text-sm mb-6">
            Sisa: <strong class="text-blue-600">Rp{{ number_format($booking->remaining_amount, 0, ',', '.') }}</strong><br>
            Pastikan customer sudah membayar tunai di lokasi.
        </p>
        <div class="flex gap-3">
            <button onclick="document.getElementById('settlementModal{{ $booking->id }}').classList.add('hidden')"
                    class="flex-1 py-3 border border-slate-200 rounded-xl text-sm font-medium">Batal</button>
            <form method="POST" action="{{ route('admin.bookings.settlement', $booking->id) }}" class="flex-1">
                @csrf
                <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-xl text-sm font-bold">Ya, Konfirmasi</button>
            </form>
        </div>
    </div>
</div>
@endif

{{-- Modal Batalkan Booking --}}
@if(!in_array($booking->booking_status, ['cancelled', 'completed']))
<div id="cancelModal{{ $booking->id }}" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50">
    <div class="bg-white rounded-3xl p-10 max-w-sm w-full mx-4 shadow-2xl text-center">
        <span class="material-symbols-outlined text-5xl text-red-500 mb-4 block">block</span>
        <h3 class="text-xl font-bold mb-2">Batalkan Booking?</h3>
        <p class="text-slate-500 text-sm mb-6">
            <strong>{{ $booking->booking_code }}</strong> — {{ $booking->customer->name }}<br>
            Hubungi customer untuk proses refund manual.
        </p>
        @if($booking->customer->phone)
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $booking->customer->phone) }}?text={{ urlencode('Halo ' . $booking->customer->name . ', booking Anda (' . $booking->booking_code . ') telah dibatalkan.') }}"
           target="_blank"
           class="block w-full py-3 bg-green-500 text-white rounded-xl text-sm font-bold mb-3 hover:bg-green-600 transition-all">
            Hubungi via WhatsApp
        </a>
        @endif
        <div class="flex gap-3">
            <button onclick="document.getElementById('cancelModal{{ $booking->id }}').classList.add('hidden')"
                    class="flex-1 py-3 border border-slate-200 rounded-xl text-sm font-medium">Batal</button>
            <form method="POST" action="{{ route('admin.bookings.cancel', $booking->id) }}" class="flex-1">
                @csrf
                <button type="submit" class="w-full py-3 bg-red-500 text-white rounded-xl text-sm font-bold">Ya, Batalkan</button>
            </form>
        </div>
    </div>
</div>
@endif
@endforeach

@endsection
