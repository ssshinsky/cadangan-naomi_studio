@extends('admin.layouts.admin')

@section('title', 'Kelola Mentor')

@section('content')

    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="font-serif text-3xl font-bold text-slate-900">Kelola Mentor</h2>
            <p class="text-slate-500 text-sm mt-1">Daftar mentor yang dapat di-assign ke kelas open class.</p>
        </div>
        <a href="{{ route('admin.mentors.create') }}"
            class="bg-primary text-white px-6 py-3 rounded-xl text-sm font-bold shadow-lg shadow-primary/20 flex items-center gap-2 hover:bg-primary/90 transition-all">
            <span class="material-symbols-outlined text-sm">add</span>
            TAMBAH MENTOR
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.1em] border-b border-slate-50 bg-slate-50/30">
                        <th class="px-8 py-5">Mentor</th>
                        <th class="px-6 py-5">Keunggulan</th>
                        <th class="px-6 py-5">Pengalaman</th>
                        <th class="px-6 py-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($mentors as $mentor)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="size-14 rounded-2xl overflow-hidden border border-slate-100 bg-slate-50 shrink-0">
                                    @if($mentor->photo)
                                        <img src="{{ asset('storage/' . $mentor->photo) }}" class="w-full h-full object-cover" alt="{{ $mentor->name }}">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <span class="material-symbols-outlined text-slate-300 text-2xl">person</span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">{{ $mentor->name }}</p>
                                    @if($mentor->bio)
                                    <p class="text-[10px] text-slate-400 mt-0.5 max-w-xs truncate">{{ $mentor->bio }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-xs text-slate-600 max-w-xs truncate">{{ $mentor->expertise ?? '—' }}</p>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-xs text-slate-600 max-w-xs truncate">{{ $mentor->experience ?? '—' }}</p>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.mentors.edit', $mentor) }}"
                                   class="size-9 flex items-center justify-center rounded-xl bg-slate-100 text-slate-500 hover:bg-primary hover:text-white transition-all">
                                    <span class="material-symbols-outlined text-base">edit</span>
                                </a>
                                <form method="POST" action="{{ route('admin.mentors.toggle-active', $mentor) }}" id="toggleMentor{{ $mentor->id }}">
                                    @csrf
                                    <button type="button"
                                        onclick="naomiConfirm(
                                            '{{ $mentor->is_active ? 'Nonaktifkan' : 'Aktifkan' }} mentor <strong>{{ $mentor->name }}</strong>?',
                                            () => document.getElementById('toggleMentor{{ $mentor->id }}').submit(),
                                            { danger: {{ $mentor->is_active ? 'true' : 'false' }}, confirmText: '{{ $mentor->is_active ? 'Nonaktifkan' : 'Aktifkan' }}' }
                                        )"
                                        class="size-9 flex items-center justify-center rounded-xl transition-all
                                            {{ $mentor->is_active ? 'bg-green-50 text-green-600 border border-green-100 hover:bg-red-50 hover:text-red-500' : 'bg-slate-100 text-slate-500 border border-slate-200 hover:bg-green-50 hover:text-green-600' }}">
                                        <span class="material-symbols-outlined text-base">{{ $mentor->is_active ? 'check' : 'block' }}</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-16 text-center text-slate-400">
                            <span class="material-symbols-outlined text-5xl block mb-3">person_off</span>
                            Belum ada mentor. Tambahkan mentor pertama!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
