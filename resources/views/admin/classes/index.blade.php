@extends('admin.layouts.admin')

@section('title', 'Kelola Kelas')

@section('content')

    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="font-serif text-3xl font-bold text-slate-900">Kelola Kelas</h2>
            <p class="text-slate-500 text-sm mt-1">Daftar kelas untuk promosi. Pendaftaran diarahkan ke WhatsApp Mentor.</p>
        </div>
        <a href="{{ route('admin.classes.create') }}"
            class="bg-primary text-white px-6 py-3 rounded-xl text-sm font-bold shadow-lg shadow-primary/20 flex items-center gap-2 hover:bg-primary/90 transition-all">
            <span class="material-symbols-outlined text-sm">add</span>
            TAMBAH KELAS
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.1em] border-b border-slate-50 bg-slate-50/30">
                        <th class="px-8 py-5">Nama Kelas & Mentor</th>
                        <th class="px-6 py-5">Jadwal</th>
                        <th class="px-6 py-5">Harga</th>
                        <th class="px-6 py-5">WhatsApp</th>
                        <th class="px-6 py-5 text-center">Status</th>
                        <th class="px-6 py-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($classes as $class)
                    <tr class="hover:bg-slate-50/50 transition-colors {{ !$class->is_active ? 'opacity-60' : '' }}">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="size-14 rounded-2xl overflow-hidden border border-slate-100 bg-slate-50 shrink-0">
                                    @if($class->thumbnail)
                                        <img src="{{ asset('storage/' . $class->thumbnail) }}" class="w-full h-full object-cover" alt="{{ $class->title }}">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <span class="material-symbols-outlined text-slate-300 text-2xl">image</span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">{{ $class->title }}</p>
                                    <p class="text-[10px] text-slate-400 font-medium">{{ $class->instructor_name }}</p>
                                    @if($class->song_title)
                                    <p class="text-[10px] text-slate-300 italic mt-0.5">♪ {{ $class->song_title }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-xs font-bold text-slate-700">{{ $class->day_of_week }}</p>
                            <p class="text-[10px] text-slate-400">{{ substr($class->time_start, 0, 5) }} – {{ substr($class->time_end, 0, 5) }}</p>
                        </td>
                        <td class="px-6 py-5 text-sm font-bold text-slate-800">
                            Rp{{ number_format($class->price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-5">
                            <a href="{{ $class->whatsapp_link }}" target="_blank"
                               class="flex items-center gap-1.5 text-xs text-green-600 font-bold bg-green-50 px-3 py-1.5 rounded-lg w-fit hover:bg-green-100 transition-colors">
                                <span class="material-symbols-outlined text-sm">chat</span>
                                WhatsApp
                            </a>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <form method="POST" action="{{ route('admin.classes.toggle-active', $class) }}" id="toggleClass{{ $class->id }}">
                                @csrf
                                <button type="button"
                                    onclick="naomiConfirm(
                                        '{{ $class->is_active ? 'Nonaktifkan' : 'Aktifkan' }} kelas <strong>{{ $class->title }}</strong>?',
                                        () => document.getElementById('toggleClass{{ $class->id }}').submit(),
                                        { danger: {{ $class->is_active ? 'true' : 'false' }}, confirmText: '{{ $class->is_active ? 'Nonaktifkan' : 'Aktifkan' }}' }
                                    )"
                                    class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider transition-all
                                        {{ $class->is_active
                                            ? 'bg-green-50 text-green-600 border border-green-100 hover:bg-red-50 hover:text-red-500 hover:border-red-100'
                                            : 'bg-slate-100 text-slate-500 border border-slate-200 hover:bg-green-50 hover:text-green-600 hover:border-green-100' }}">
                                    {{ $class->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.classes.edit', $class) }}"
                                   class="size-9 flex items-center justify-center rounded-xl bg-slate-100 text-slate-500 hover:bg-primary hover:text-white transition-all">
                                    <span class="material-symbols-outlined text-base">edit</span>
                                </a>
                                <form method="POST" action="{{ route('admin.classes.destroy', $class) }}" id="deleteClass{{ $class->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button"
                                        onclick="naomiConfirm(
                                            'Hapus kelas <strong>{{ $class->title }}</strong>? Tindakan ini tidak bisa dibatalkan.',
                                            () => document.getElementById('deleteClass{{ $class->id }}').submit(),
                                            { danger: true, confirmText: 'Ya, Hapus' }
                                        )"
                                        class="size-9 flex items-center justify-center rounded-xl bg-slate-100 text-slate-500 hover:bg-red-500 hover:text-white transition-all">
                                        <span class="material-symbols-outlined text-base">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-16 text-center text-slate-400">
                            <span class="material-symbols-outlined text-5xl block mb-3">event_seat</span>
                            Belum ada kelas. Tambahkan kelas pertama!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
