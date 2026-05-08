@extends('admin.layouts.admin')

@section('title', 'Data Maintenance Studio')

@section('content')

    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10">
        <div>
            <h2 class="font-serif text-3xl font-bold text-charcoal tracking-tight">Riwayat Maintenance</h2>
            <p class="text-naomi-muted text-sm mt-1 font-light">Pantau dan filter pengeluaran operasional studio</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <form action="{{ route('admin.maintenance.index') }}" method="GET"
                  class="flex items-center gap-2 bg-white border border-naomi-muted/20 p-1.5 rounded-2xl shadow-sm">
                <select name="month" class="bg-transparent border-none text-xs font-bold text-charcoal focus:ring-0 cursor-pointer px-3">
                    @foreach(range(1,12) as $m)
                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                        {{ strtoupper(date('F', mktime(0,0,0,$m,1))) }}
                    </option>
                    @endforeach
                </select>
                <div class="w-[1px] h-4 bg-naomi-muted/20"></div>
                <select name="year" class="bg-transparent border-none text-xs font-bold text-charcoal focus:ring-0 cursor-pointer px-3">
                    @for($y = date('Y'); $y >= 2024; $y--)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
                <button type="submit" class="bg-charcoal text-white p-2 rounded-xl hover:bg-primary transition-all">
                    <span class="material-symbols-outlined text-sm block">filter_list</span>
                </button>
            </form>

            <a href="{{ route('admin.maintenance.create') }}"
               class="px-6 py-3 bg-primary text-white rounded-xl text-sm font-black shadow-lg shadow-primary/20 hover:bg-charcoal transition-all flex items-center gap-2 uppercase tracking-widest">
                <span class="material-symbols-outlined text-sm">add</span>
                Tambah Data
            </a>
        </div>
    </div>

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-8 rounded-[2rem] border border-charcoal/5 shadow-sm">
            <div class="size-10 bg-primary/10 rounded-xl flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-primary text-xl">account_balance_wallet</span>
            </div>
            <p class="text-[10px] font-black text-naomi-muted uppercase tracking-[0.2em] mb-1">Total Pengeluaran</p>
            <h4 class="text-2xl font-black text-charcoal tracking-tight">Rp{{ number_format($totalAll, 0, ',', '.') }}</h4>
            <p class="text-[10px] text-naomi-muted mt-2">
                {{ date('F', mktime(0,0,0,$month,1)) }} {{ $year }}
            </p>
        </div>

        <div class="bg-white p-8 rounded-[2rem] border border-charcoal/5 shadow-sm">
            <div class="size-10 bg-blue-500/10 rounded-xl flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-blue-500 text-xl">bolt</span>
            </div>
            <p class="text-[10px] font-black text-naomi-muted uppercase tracking-[0.2em] mb-1">Biaya Listrik</p>
            <h4 class="text-2xl font-black text-charcoal tracking-tight">Rp{{ number_format($totalListrik, 0, ',', '.') }}</h4>
            <p class="text-[10px] text-naomi-muted mt-2">
                {{ $totalAll > 0 ? round($totalListrik / $totalAll * 100) : 0 }}% dari total biaya
            </p>
        </div>

        <div class="bg-white p-8 rounded-[2rem] border border-charcoal/5 shadow-sm">
            <div class="size-10 bg-purple-500/10 rounded-xl flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-purple-500 text-xl">category</span>
            </div>
            <p class="text-[10px] font-black text-naomi-muted uppercase tracking-[0.2em] mb-1">Biaya Lain-lain</p>
            <h4 class="text-2xl font-black text-charcoal tracking-tight">Rp{{ number_format($totalLainnya, 0, ',', '.') }}</h4>
            <p class="text-[10px] text-naomi-muted mt-2">Air, WiFi, Kebersihan, dll</p>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-charcoal/5 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-naomi-bg/30 border-b border-charcoal/5">
                        <th class="px-8 py-5 text-[10px] font-black text-naomi-muted uppercase tracking-[0.2em]">Info Pembayaran</th>
                        <th class="px-8 py-5 text-[10px] font-black text-naomi-muted uppercase tracking-[0.2em]">Kategori</th>
                        <th class="px-8 py-5 text-[10px] font-black text-naomi-muted uppercase tracking-[0.2em]">Keterangan</th>
                        <th class="px-8 py-5 text-[10px] font-black text-naomi-muted uppercase tracking-[0.2em]">Nominal</th>
                        <th class="px-8 py-5 text-[10px] font-black text-naomi-muted uppercase tracking-[0.2em] text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-charcoal/5">
                    @forelse($costs as $cost)
                    @php
                        $catColors = [
                            'listrik'    => 'bg-blue-50 text-blue-600',
                            'air'        => 'bg-cyan-50 text-cyan-600',
                            'wifi'       => 'bg-indigo-50 text-indigo-600',
                            'kebersihan' => 'bg-green-50 text-green-600',
                            'lain-lain'  => 'bg-purple-50 text-purple-600',
                        ];
                        $color = $catColors[$cost->category] ?? 'bg-slate-50 text-slate-500';
                    @endphp
                    <tr class="group hover:bg-naomi-bg/10 transition-colors">
                        <td class="px-8 py-6">
                            <span class="text-sm font-bold text-charcoal block mb-0.5">
                                {{ $cost->payment_date->format('d M Y') }}
                            </span>
                            <span class="text-[10px] font-medium text-naomi-muted bg-naomi-bg px-2 py-0.5 rounded">
                                {{ $cost->cost_code }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1.5 {{ $color }} text-[9px] font-black rounded-lg uppercase tracking-wider">
                                {{ $cost->category }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <p class="text-sm text-charcoal/70 font-light max-w-xs leading-relaxed">
                                {{ $cost->description ?? '-' }}
                            </p>
                        </td>
                        <td class="px-8 py-6 font-black text-charcoal text-sm">
                            Rp{{ number_format($cost->amount, 0, ',', '.') }}
                        </td>
                        <td class="px-8 py-6 text-center">
                            <div class="flex justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.maintenance.edit', $cost) }}"
                                   class="size-9 flex items-center justify-center rounded-xl bg-naomi-bg text-charcoal hover:bg-primary hover:text-white transition-all shadow-sm">
                                    <span class="material-symbols-outlined text-base">edit</span>
                                </a>
                                <form method="POST" action="{{ route('admin.maintenance.destroy', $cost) }}" id="deleteCost{{ $cost->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button"
                                        onclick="naomiConfirm(
                                            'Hapus data <strong>{{ $cost->cost_code }}</strong>?',
                                            () => document.getElementById('deleteCost{{ $cost->id }}').submit(),
                                            { danger: true, confirmText: 'Ya, Hapus' }
                                        )"
                                        class="size-9 flex items-center justify-center rounded-xl bg-naomi-bg text-red-500 hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                        <span class="material-symbols-outlined text-base">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-16 text-center text-naomi-muted">
                            <span class="material-symbols-outlined text-5xl block mb-3">receipt_long</span>
                            Belum ada data pengeluaran untuk periode ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
