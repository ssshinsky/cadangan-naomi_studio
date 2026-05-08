@extends('admin.layouts.admin')

@section('title', 'Kelola Studio')

@section('content')

    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="font-serif text-3xl font-bold text-slate-900">Kelola Studio</h2>
            <p class="text-slate-500 text-sm mt-1">Atur informasi, harga, dan ketersediaan ruangan studio Anda</p>
        </div>
        <a href="{{ route('admin.studios.create') }}"
           class="flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-xl font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
            <span class="material-symbols-outlined">add_circle</span>
            Tambah Studio Baru
        </a>
    </div>

    <div class="space-y-6">
        @forelse($studios as $studio)
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden flex flex-col md:flex-row">
            <div class="relative md:w-2/5 h-64 md:h-auto">
                @if($studio->primaryImage)
                    <img src="{{ asset('storage/' . $studio->primaryImage->image_url) }}"
                         alt="{{ $studio->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-slate-100 flex items-center justify-center">
                        <span class="material-symbols-outlined text-5xl text-slate-300">image</span>
                    </div>
                @endif
                <div class="absolute top-4 left-4">
                    <span class="{{ $studio->is_available ? 'bg-emerald-500' : 'bg-slate-400' }} text-white text-[10px] font-bold px-3 py-1 rounded-lg uppercase tracking-wider">
                        {{ $studio->is_available ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
            </div>

            <div class="p-8 md:w-3/5 flex flex-col justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-2">{{ $studio->name }}</h3>
                    <div class="flex items-baseline gap-1 mb-2">
                        <span class="text-2xl font-bold text-primary">Rp{{ number_format($studio->price_per_hour, 0, ',', '.') }}</span>
                        <span class="text-slate-400 text-sm">/ JAM</span>
                    </div>
                    @if($studio->extra_price_threshold > 0)
                    <p class="text-xs text-slate-400 mb-4 italic">
                        &gt;{{ $studio->extra_price_threshold }} orang: Rp{{ number_format($studio->extra_price_per_hour, 0, ',', '.') }}/jam
                    </p>
                    @endif

                    <div class="grid grid-cols-2 gap-y-2 mb-4">
                        <div class="flex items-center gap-2 text-slate-600">
                            <span class="material-symbols-outlined text-primary text-lg">groups</span>
                            <span class="text-sm">Kapasitas {{ $studio->capacity }} orang</span>
                        </div>
                        @if($studio->size_sqm)
                        <div class="flex items-center gap-2 text-slate-600">
                            <span class="material-symbols-outlined text-primary text-lg">straighten</span>
                            <span class="text-sm">{{ $studio->size_sqm }}</span>
                        </div>
                        @endif
                        @foreach($studio->facilities->take(2) as $f)
                        <div class="flex items-center gap-2 text-slate-600">
                            <span class="material-symbols-outlined text-primary text-lg">{{ $f->icon ?? 'check_circle' }}</span>
                            <span class="text-sm">{{ $f->name }}</span>
                        </div>
                        @endforeach
                    </div>

                    @if($studio->description)
                    <p class="text-slate-500 text-sm leading-relaxed mb-6 line-clamp-2">{{ $studio->description }}</p>
                    @endif
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.studios.edit', $studio->id) }}"
                       class="flex-1 flex items-center justify-center gap-2 py-3 bg-white border border-slate-200 text-slate-700 rounded-xl font-bold text-sm hover:bg-slate-50 transition-all">
                        <span class="material-symbols-outlined text-primary text-lg">edit</span>
                        Edit Data
                    </a>
                    <button onclick="document.getElementById('deleteModal{{ $studio->id }}').classList.remove('hidden')"
                            class="px-5 py-3 bg-slate-100 text-slate-500 rounded-xl font-bold text-sm hover:bg-red-50 hover:text-red-500 transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">delete</span>
                        Hapus
                    </button>
                </div>
            </div>
        </div>

        {{-- Modal Hapus --}}
        <div id="deleteModal{{ $studio->id }}" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50">
            <div class="bg-white rounded-3xl p-10 max-w-sm w-full mx-4 shadow-2xl text-center">
                <span class="material-symbols-outlined text-5xl text-red-500 mb-4 block">delete</span>
                <h3 class="text-xl font-bold mb-2">Hapus Studio?</h3>
                <p class="text-slate-500 text-sm mb-6">Studio <strong>{{ $studio->name }}</strong> akan dihapus permanen beserta semua fotonya.</p>
                <div class="flex gap-3">
                    <button onclick="document.getElementById('deleteModal{{ $studio->id }}').classList.add('hidden')"
                            class="flex-1 py-3 border border-slate-200 rounded-xl text-sm font-medium">Batal</button>
                    <form method="POST" action="{{ route('admin.studios.destroy', $studio->id) }}" class="flex-1">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full py-3 bg-red-500 text-white rounded-xl text-sm font-bold">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-20 text-slate-400">
            <span class="material-symbols-outlined text-5xl block mb-3">image</span>
            Belum ada studio. Tambahkan studio pertama!
        </div>
        @endforelse
    </div>

@endsection
