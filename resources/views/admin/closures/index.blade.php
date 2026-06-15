@extends('admin.layouts.admin')

@section('title', 'Kelola Closure Studio')

@section('content')

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="font-serif text-3xl font-bold text-slate-900">Kelola Closure Studio</h2>
            <p class="text-slate-500 text-sm mt-1">Daftar penutupan slot studio yang telah dijadwalkan</p>
        </div>
        <a href="{{ route('admin.closures.create') }}"
           class="flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-xl font-bold shadow-lg shadow-primary/20 hover:bg-charcoal transition-all">
            <span class="material-symbols-outlined">add_circle</span>
            Buat Closure Baru
        </a>
    </div>

    {{-- Content --}}
    @if($closures->isEmpty())
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm py-20 text-center">
            <span class="material-symbols-outlined text-5xl text-slate-300 block mb-3">event_busy</span>
            <p class="text-slate-400 font-medium">Belum ada data closure.</p>
            <p class="text-slate-400 text-sm mt-1">Klik tombol "Buat Closure Baru" untuk menambahkan penutupan slot studio.</p>
        </div>
    @else
        <div class="space-y-8">
            @foreach($closures as $studioId => $studioClosures)
            @php
                $studio = $studioClosures->first()->studio;
            @endphp

            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                {{-- Studio Header --}}
                <div class="flex items-center gap-3 px-8 py-5 border-b border-slate-100 bg-slate-50/50">
                    <div class="size-9 bg-primary/10 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-lg">photo_camera</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800">{{ $studio->name }}</h3>
                        <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold">
                            {{ $studioClosures->count() }} closure terdaftar
                        </p>
                    </div>
                </div>

                {{-- Closure Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em] border-b border-slate-50 bg-slate-50/30">
                                <th class="px-8 py-5">Tanggal</th>
                                <th class="px-6 py-5">Waktu</th>
                                <th class="px-6 py-5">Alasan</th>
                                <th class="px-6 py-5">Dibuat Oleh</th>
                                <th class="px-6 py-5 text-center">Status</th>
                                <th class="px-6 py-5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($studioClosures as $closure)
                            @php
                                $isPast = $closure->date->isPast() && !$closure->date->isToday();
                            @endphp
                            <tr class="group hover:bg-slate-50/80 transition-colors {{ $isPast ? 'opacity-60' : '' }}">
                                <td class="px-8 py-5">
                                    <p class="text-sm font-bold text-slate-800">
                                        {{ $closure->date->translatedFormat('d M Y') }}
                                    </p>
                                    <p class="text-[10px] text-slate-400 mt-0.5">
                                        {{ $closure->date->translatedFormat('l') }}
                                    </p>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-slate-400 text-base">schedule</span>
                                        <span class="text-sm font-semibold text-slate-700">
                                            {{ substr($closure->start_time, 0, 5) }} – {{ substr($closure->end_time, 0, 5) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-sm text-slate-600 max-w-xs leading-relaxed line-clamp-2">
                                        {{ $closure->reason }}
                                    </p>
                                </td>
                                <td class="px-6 py-5">
                                    @if($closure->admin)
                                        <div class="flex items-center gap-2">
                                            <div class="size-7 rounded-full bg-primary/10 flex items-center justify-center text-primary text-[10px] font-bold">
                                                {{ strtoupper(substr($closure->admin->name, 0, 2)) }}
                                            </div>
                                            <span class="text-xs text-slate-600 font-medium">{{ $closure->admin->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-xs text-slate-400 italic">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @if($isPast)
                                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-slate-100 text-slate-400 text-[10px] font-black uppercase tracking-wider rounded-full border border-slate-200">
                                            <span class="material-symbols-outlined text-xs">history</span>
                                            Selesai
                                        </span>
                                    @elseif($closure->date->isToday())
                                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-amber-50 text-amber-600 text-[10px] font-black uppercase tracking-wider rounded-full border border-amber-200">
                                            <span class="material-symbols-outlined text-xs">today</span>
                                            Hari Ini
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-red-50 text-red-600 text-[10px] font-black uppercase tracking-wider rounded-full border border-red-200">
                                            <span class="material-symbols-outlined text-xs">event_busy</span>
                                            Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <div class="flex justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <form method="POST"
                                              action="{{ route('admin.closures.destroy', $closure->id) }}"
                                              id="deleteClosure{{ $closure->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                onclick="naomiConfirm(
                                                    'Hapus closure studio <strong>{{ addslashes($studio->name) }}</strong> pada tanggal <strong>{{ $closure->date->format('d M Y') }}</strong>?',
                                                    () => document.getElementById('deleteClosure{{ $closure->id }}').submit(),
                                                    { danger: true, confirmText: 'Ya, Hapus' }
                                                )"
                                                class="size-9 flex items-center justify-center rounded-xl bg-naomi-bg text-red-500 hover:bg-red-500 hover:text-white transition-all shadow-sm"
                                                title="Hapus Closure">
                                                <span class="material-symbols-outlined text-base">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        </div>
    @endif

@endsection
