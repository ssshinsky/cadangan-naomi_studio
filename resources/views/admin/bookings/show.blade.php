@extends('admin.layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')

    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="font-serif text-3xl font-bold text-slate-900">Detail Pesanan</h2>
            <p class="text-slate-500 text-sm mt-1">{{ $booking->booking_code }}</p>
        </div>
        <a href="{{ route('admin.bookings.index') }}"
           class="text-primary hover:underline text-sm font-medium flex items-center gap-1">
            ← Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        {{-- Bukti Bayar --}}
        <div class="lg:col-span-8 space-y-6">
            @forelse($booking->payments as $payment)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">
                            Bukti Bayar — {{ strtoupper($payment->payment_type) }}
                        </span>
                        <p class="text-xs text-slate-400 mt-1">{{ $payment->paid_at?->format('d M Y, H:i') }}</p>
                    </div>
                    @if($payment->status === 'pending')
                        <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-[10px] font-bold uppercase">MENUNGGU VERIFIKASI</span>
                    @elseif($payment->status === 'verified')
                        <span class="px-3 py-1 bg-green-50 text-green-600 rounded-full text-[10px] font-bold uppercase">TERVERIFIKASI</span>
                    @else
                        <span class="px-3 py-1 bg-red-50 text-red-600 rounded-full text-[10px] font-bold uppercase">DITOLAK</span>
                    @endif
                </div>

                @if($payment->proof_image)
                <div class="rounded-xl overflow-hidden bg-slate-50 border border-slate-100 mb-6">
                    <img src="{{ asset('storage/' . $payment->proof_image) }}"
                         alt="Bukti Transfer" class="w-full h-auto object-contain max-h-96">
                </div>
                @endif

                {{-- Nominal yang dibayarkan --}}
                <div class="bg-slate-50 rounded-xl px-6 py-4 mb-6 flex justify-between items-center">
                    <span class="text-sm text-slate-500 font-medium">Nominal Dibayarkan</span>
                    <span class="text-xl font-black text-primary">Rp{{ number_format($payment->amount, 0, ',', '.') }}</span>
                </div>

                @if($payment->status === 'pending')
                <div class="flex gap-3">
                    {{-- Tombol Konfirmasi → pop-up --}}
                    <button onclick="document.getElementById('confirmModal{{ $payment->id }}').classList.remove('hidden')"
                            class="flex-1 py-3 bg-primary text-white rounded-xl font-bold text-sm flex items-center justify-center gap-2 hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
                        <span class="material-symbols-outlined text-lg">verified</span>
                        KONFIRMASI PEMBAYARAN
                    </button>
                    {{-- Tombol Tolak → pop-up --}}
                    <button onclick="document.getElementById('rejectModal{{ $payment->id }}').classList.remove('hidden')"
                            class="px-6 py-3 border border-red-200 text-red-500 rounded-xl text-sm font-bold flex items-center gap-2 hover:bg-red-50 transition-all">
                        <span class="material-symbols-outlined text-sm">cancel</span>
                        Tolak
                    </button>
                </div>
                @endif
            </div>

            {{-- Modal Konfirmasi Pembayaran --}}
            <div id="confirmModal{{ $payment->id }}" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50">
                <div class="bg-white rounded-3xl p-10 max-w-sm w-full mx-4 shadow-2xl text-center">
                    <span class="material-symbols-outlined text-5xl text-green-600 mb-4 block">verified</span>
                    <h3 class="text-xl font-bold mb-2">Konfirmasi Pembayaran?</h3>
                    <p class="text-slate-500 text-sm mb-2">Nominal: <strong>Rp{{ number_format($payment->amount, 0, ',', '.') }}</strong></p>
                    <p class="text-slate-500 text-sm mb-6">Pastikan bukti transfer sudah valid sebelum mengkonfirmasi.</p>
                    <div class="flex gap-3">
                        <button onclick="document.getElementById('confirmModal{{ $payment->id }}').classList.add('hidden')"
                                class="flex-1 py-3 border border-slate-200 rounded-xl text-sm font-medium">Batal</button>
                        <form method="POST" action="{{ route('admin.bookings.payment.confirm', $payment->id) }}" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full py-3 bg-primary text-white rounded-xl text-sm font-bold">Ya, Konfirmasi</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Modal Tolak Pembayaran --}}
            <div id="rejectModal{{ $payment->id }}" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50">
                <div class="bg-white rounded-3xl p-10 max-w-sm w-full mx-4 shadow-2xl">
                    <h3 class="text-xl font-bold mb-4">Tolak Bukti Pembayaran?</h3>
                    <form method="POST" action="{{ route('admin.bookings.payment.reject', $payment->id) }}">
                        @csrf
                        <textarea name="reason" rows="3" placeholder="Alasan penolakan..."
                                  class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm mb-4 focus:ring-2 focus:ring-primary/20 outline-none resize-none"></textarea>
                        <div class="flex gap-3">
                            <button type="button"
                                    onclick="document.getElementById('rejectModal{{ $payment->id }}').classList.add('hidden')"
                                    class="flex-1 py-3 border border-slate-200 rounded-xl text-sm font-medium">Batal</button>
                            <button type="submit"
                                    class="flex-1 py-3 bg-red-500 text-white rounded-xl text-sm font-bold">Tolak</button>
                        </div>
                    </form>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-12 text-center text-slate-400">
                <span class="material-symbols-outlined text-5xl block mb-3">receipt_long</span>
                Belum ada bukti pembayaran
            </div>
            @endforelse
        </div>

        {{-- Detail Transaksi --}}
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
                <div class="flex items-center gap-2 mb-6">
                    <span class="material-symbols-outlined text-primary">description</span>
                    <h3 class="font-bold text-slate-800">Detail Transaksi</h3>
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between items-center border-t border-slate-50 pt-4">
                        <span class="text-sm text-slate-400">Booking ID</span>
                        <span class="text-xs font-bold font-mono bg-slate-50 px-3 py-1 rounded-lg">{{ $booking->booking_code }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-slate-400">Pelanggan</span>
                        <div class="text-right">
                            <p class="text-sm font-bold text-slate-800">{{ $booking->customer->name }}</p>
                            @if($booking->customer->phone)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $booking->customer->phone) }}"
                                   target="_blank" class="text-[10px] text-green-600 font-bold hover:underline">
                                    {{ $booking->customer->phone }}
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="flex justify-between items-center border-t border-slate-50 pt-4">
                        <span class="text-sm text-slate-400">Studio</span>
                        <span class="text-sm font-bold">{{ $booking->studio->name }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-slate-400">Tanggal</span>
                        <span class="text-sm font-bold">{{ $booking->date->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-slate-400">Waktu</span>
                        <span class="text-sm font-bold">{{ substr($booking->start_time,0,5) }} – {{ substr($booking->end_time,0,5) }}</span>
                    </div>
                    <div class="flex justify-between items-center border-t border-slate-50 pt-4">
                        <span class="text-sm text-slate-400">Total Harga</span>
                        <span class="text-sm font-bold">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </div>
                    @foreach($booking->payments->where('status', 'verified') as $p)
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-slate-400">Dibayar ({{ strtoupper($p->payment_type) }})</span>
                        <span class="text-sm font-bold text-green-600">- Rp{{ number_format($p->amount, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                    <div class="flex justify-between items-center border-t border-slate-50 pt-4">
                        <span class="text-sm text-slate-400">Sisa Tagihan</span>
                        <span class="text-sm font-bold {{ $booking->remaining_amount > 0 ? 'text-amber-600' : 'text-green-600' }}">
                            Rp{{ number_format($booking->remaining_amount, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center border-t border-slate-50 pt-4">
                        <span class="text-sm text-slate-400">Status</span>
                        <x-booking-status :status="$booking->getDisplayStatus()" />
                    </div>

                    {{-- Tombol Konfirmasi Pelunasan di bawah status --}}
                    @if($booking->booking_status === 'confirmed' && $booking->remaining_amount > 0)
                    <div class="pt-2">
                        <button onclick="document.getElementById('settlementModal').classList.remove('hidden')"
                                class="w-full py-3 bg-blue-600 text-white rounded-xl font-bold text-sm flex items-center justify-center gap-2 hover:bg-blue-700 transition-all shadow-lg">
                            <span class="material-symbols-outlined text-lg">payments</span>
                            KONFIRMASI PELUNASAN
                        </button>
                    </div>
                    @endif

                    {{-- Tombol Download Invoice --}}
                    @if(in_array($booking->booking_status, ['confirmed', 'completed']))
                    <div class="pt-2">
                        <a href="{{ route('admin.bookings.invoice', $booking->id) }}"
                           class="w-full py-3 bg-charcoal text-white rounded-xl font-bold text-sm flex items-center justify-center gap-2 hover:bg-primary transition-all shadow-lg">
                            <span class="material-symbols-outlined text-lg">download</span>
                            DOWNLOAD INVOICE PDF
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Batalkan Booking --}}
            @if(!in_array($booking->booking_status, ['cancelled', 'completed']))
            <button onclick="document.getElementById('cancelModal').classList.remove('hidden')"
                    class="w-full py-3 border border-slate-200 text-slate-500 rounded-xl text-sm font-bold flex items-center justify-center gap-2 hover:bg-red-50 hover:text-red-500 hover:border-red-200 transition-all">
                <span class="material-symbols-outlined text-sm">block</span>
                Batalkan Booking
            </button>
            @endif
        </div>
    </div>

    {{-- Modal Konfirmasi Pelunasan --}}
    <div id="settlementModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50">
        <div class="bg-white rounded-3xl p-10 max-w-sm w-full mx-4 shadow-2xl text-center">
            <span class="material-symbols-outlined text-5xl text-blue-600 mb-4 block">payments</span>
            <h3 class="text-xl font-bold mb-2">Konfirmasi Pelunasan?</h3>
            <p class="text-slate-500 text-sm mb-2">
                Sisa tagihan: <strong class="text-blue-600">Rp{{ number_format($booking->remaining_amount, 0, ',', '.') }}</strong>
            </p>
            <p class="text-slate-500 text-sm mb-6">Pastikan customer sudah membayar tunai di lokasi.</p>
            <div class="flex gap-3">
                <button onclick="document.getElementById('settlementModal').classList.add('hidden')"
                        class="flex-1 py-3 border border-slate-200 rounded-xl text-sm font-medium">Batal</button>
                <form method="POST" action="{{ route('admin.bookings.settlement', $booking->id) }}" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-xl text-sm font-bold">Ya, Konfirmasi</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Batalkan Booking --}}
    <div id="cancelModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50">
        <div class="bg-white rounded-3xl p-10 max-w-sm w-full mx-4 shadow-2xl text-center">
            <span class="material-symbols-outlined text-5xl text-red-500 mb-4 block">block</span>
            <h3 class="text-xl font-bold mb-2">Batalkan Booking?</h3>
            <p class="text-slate-500 text-sm mb-6">
                Booking <strong>{{ $booking->booking_code }}</strong> akan dibatalkan. Hubungi customer untuk proses refund manual.
            </p>
            @if($booking->customer->phone)
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $booking->customer->phone) }}?text={{ urlencode('Halo ' . $booking->customer->name . ', booking Anda (' . $booking->booking_code . ') telah dibatalkan. Kami akan memproses refund segera.') }}"
               target="_blank"
               class="block w-full py-3 bg-green-500 text-white rounded-xl text-sm font-bold mb-3 hover:bg-green-600 transition-all">
                Hubungi via WhatsApp
            </a>
            @endif
            <div class="flex gap-3">
                <button onclick="document.getElementById('cancelModal').classList.add('hidden')"
                        class="flex-1 py-3 border border-slate-200 rounded-xl text-sm font-medium">Batal</button>
                <form method="POST" action="{{ route('admin.bookings.cancel', $booking->id) }}" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full py-3 bg-red-500 text-white rounded-xl text-sm font-bold">Ya, Batalkan</button>
                </form>
            </div>
        </div>
    </div>

@endsection
