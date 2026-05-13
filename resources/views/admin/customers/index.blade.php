@extends('admin.layouts.admin')

@section('title', 'Database Pelanggan')

@section('content')

    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-8">
        <div>
            <h2 class="font-serif text-3xl font-bold text-charcoal">Database Pelanggan</h2>
            <p class="text-naomi-muted text-sm mt-1">Pantau status keaktifan dan riwayat pelanggan Naomi Studio.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <form method="GET" action="{{ route('admin.customers.index') }}" class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-naomi-muted text-sm">search</span>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama / email..."
                       class="pl-10 pr-4 py-2.5 bg-white border border-charcoal/5 rounded-xl text-xs focus:ring-1 focus:ring-primary focus:border-primary w-64 transition-all">
            </form>
            <a href="{{ route('admin.customers.export-pdf') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white rounded-xl text-sm font-semibold shadow-sm hover:bg-primary/90 transition-all">
                <span class="material-symbols-outlined text-base">download</span>
                Unduh Laporan
            </a>
        </div>
    </div>

    {{-- TABEL PELANGGAN --}}
    <div class="bg-naomi-white rounded-[2.5rem] border border-naomi-muted/20 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-naomi-muted text-[10px] font-black uppercase tracking-[0.2em] bg-naomi-bg/30">
                        <th class="px-8 py-5">Info Pelanggan</th>
                        <th class="px-8 py-5">No. WhatsApp</th>
                        <th class="px-8 py-5 text-center">Total Booking</th>
                        <th class="px-8 py-5 text-center">Status</th>
                        <th class="px-8 py-5">Bergabung</th>
                        <th class="px-8 py-5">Booking Terakhir</th>
                        <th class="px-8 py-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-naomi-bg">
                    @forelse($customers as $customer)
                    <tr class="group hover:bg-naomi-bg/20 transition-all {{ !$customer->user->is_active ? 'opacity-60' : '' }}">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-3">
                                <div class="size-10 rounded-xl bg-naomi-surface overflow-hidden border border-charcoal/5 shrink-0">
                                    @if($customer->avatar)
                                        <img src="{{ asset('storage/' . $customer->avatar) }}" class="w-full h-full object-cover" alt="{{ $customer->name }}">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&background=E5E1DA&color=746763" class="w-full h-full" alt="{{ $customer->name }}">
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-charcoal">{{ $customer->name }}</p>
                                    <p class="text-[10px] text-naomi-muted font-medium">{{ $customer->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <p class="text-xs font-medium text-charcoal/70">{{ $customer->phone ?? '-' }}</p>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <span class="text-sm font-black text-charcoal/80">{{ $customer->bookings_count }}x</span>
                        </td>
                        <td class="px-8 py-5 text-center">
                            @if($customer->user->is_active)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-600 rounded-full text-[9px] font-black uppercase tracking-widest border border-green-100">
                                    <span class="size-1.5 bg-green-600 rounded-full animate-pulse"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-50 text-slate-400 rounded-full text-[9px] font-black uppercase tracking-widest border border-slate-200">
                                    <span class="size-1.5 bg-slate-400 rounded-full"></span>
                                    Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-5">
                            <p class="text-xs font-medium text-charcoal/70">
                                {{ ($customer->joined_at ?? $customer->created_at)->format('d M Y') }}
                            </p>
                        </td>
                        <td class="px-8 py-5">
                            @php $lastBooking = $customer->bookings->sortByDesc('created_at')->first(); @endphp
                            <p class="text-xs font-medium text-charcoal/70">
                                {{ $lastBooking ? $lastBooking->created_at->format('d M Y') : '-' }}
                            </p>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <div class="flex justify-center gap-2">
                                <form method="POST" action="{{ route('admin.customers.toggle-active', $customer) }}" id="toggleForm{{ $customer->id }}">
                                    @csrf
                                    <button type="button"
                                        title="{{ $customer->user->is_active ? 'Nonaktifkan akun' : 'Aktifkan akun' }}"
                                        class="size-9 flex items-center justify-center rounded-xl transition-all
                                            {{ $customer->user->is_active
                                                ? 'bg-red-50 text-red-500 hover:bg-red-500 hover:text-white'
                                                : 'bg-green-50 text-green-600 hover:bg-green-500 hover:text-white' }}"
                                        onclick="naomiConfirm(
                                            '{{ $customer->user->is_active ? 'Nonaktifkan' : 'Aktifkan' }} akun <strong>{{ $customer->name }}</strong>?',
                                            () => document.getElementById('toggleForm{{ $customer->id }}').submit(),
                                            { danger: {{ $customer->user->is_active ? 'true' : 'false' }}, confirmText: '{{ $customer->user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}' }
                                        )">
                                        <span class="material-symbols-outlined text-base">{{ $customer->user->is_active ? 'block' : 'check_circle' }}</span>
                                    </button>
                                </form>
                                <button type="button"
                                    title="Reset password"
                                    onclick="openResetModal('{{ $customer->id }}', '{{ addslashes($customer->name) }}')"
                                    class="size-9 flex items-center justify-center rounded-xl bg-slate-100 text-slate-500 hover:bg-primary hover:text-white transition-all">
                                    <span class="material-symbols-outlined text-base">lock_reset</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-16 text-center">
                            <span class="material-symbols-outlined text-4xl text-naomi-muted block mb-2">person_off</span>
                            <p class="text-naomi-muted text-sm">Belum ada pelanggan terdaftar.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="px-8 py-6 bg-naomi-bg/10 flex items-center justify-between border-t border-naomi-bg">
            <p class="text-[10px] font-black text-naomi-muted uppercase tracking-[0.15em]">
                Menampilkan {{ $customers->firstItem() ?? 0 }}–{{ $customers->lastItem() ?? 0 }} dari {{ $customers->total() }} pelanggan
            </p>
            <div>{{ $customers->links() }}</div>
        </div>
    </div>

@endsection

{{-- Modal Reset Password --}}
<div id="resetPasswordModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl p-8 max-w-sm w-full shadow-2xl border border-slate-100">
        <div class="flex items-center gap-3 mb-6">
            <div class="size-10 bg-primary/10 rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-primary">lock_reset</span>
            </div>
            <div>
                <h3 class="font-bold text-slate-800">Reset Password</h3>
                <p id="resetModalName" class="text-xs text-slate-400"></p>
            </div>
        </div>

        <form id="resetPasswordForm" method="POST" action="" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Password Baru</label>
                <input type="password" name="password" required minlength="8"
                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none"
                       placeholder="Minimal 8 karakter">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required minlength="8"
                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none"
                       placeholder="Ulangi password baru">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeResetModal()"
                        class="flex-1 py-3 border border-slate-200 rounded-xl text-sm font-medium text-slate-500 hover:bg-slate-50 transition-all">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 py-3 bg-primary text-white rounded-xl text-sm font-bold hover:bg-charcoal transition-all shadow-lg">
                    Reset Password
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openResetModal(customerId, customerName) {
    document.getElementById('resetModalName').textContent = customerName;
    document.getElementById('resetPasswordForm').action = '/admin/customers/' + customerId + '/reset-password';
    document.getElementById('resetPasswordModal').classList.remove('hidden');
    document.getElementById('resetPasswordModal').classList.add('flex');
}
function closeResetModal() {
    document.getElementById('resetPasswordModal').classList.add('hidden');
    document.getElementById('resetPasswordModal').classList.remove('flex');
    document.getElementById('resetPasswordForm').reset();
}
</script>
