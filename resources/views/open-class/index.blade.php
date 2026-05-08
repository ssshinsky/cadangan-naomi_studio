@extends('layouts.app')

@section('title', 'Open Class - Naomi Studio')

@section('content')
<main class="bg-naomi-bg min-h-screen">

    {{-- HEADER --}}
    <section class="py-24 lg:py-32 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full bg-primary/5 -skew-y-6 origin-top-left -z-0"></div>
        <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
            <span class="inline-block px-5 py-2 bg-naomi-white border border-primary/20 text-primary rounded-full text-[10px] font-black uppercase tracking-[0.3em] mb-8 shadow-sm">
                Join the Movement
            </span>
            <h1 class="serif-title text-5xl md:text-7xl font-black text-charcoal mb-6 tracking-tight">
                Jadwal Open Class <span class="text-primary">Bulan Ini</span>
            </h1>
            <p class="text-lg md:text-xl text-charcoal/70 max-w-2xl mx-auto font-light leading-relaxed">
                Temukan kelas yang sesuai dengan gaya dan levelmu bersama instruktur profesional kami di Yogyakarta.
            </p>
        </div>
    </section>

    {{-- GRID KELAS --}}
    <section class="pb-32 px-6 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">

            @forelse($classes as $class)
            <div class="group bg-naomi-white rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 border border-charcoal/5 flex flex-col">

                <div class="relative aspect-[4/5] overflow-hidden">
                    @if($class->thumbnail)
                        <img src="{{ asset('storage/' . $class->thumbnail) }}"
                             class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110"
                             alt="{{ $class->title }}">
                    @else
                        <div class="w-full h-full bg-naomi-surface flex items-center justify-center">
                            <span class="material-symbols-outlined text-6xl text-naomi-muted">image</span>
                        </div>
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t from-charcoal/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                    <div class="absolute top-5 left-5">
                        <span class="bg-naomi-white/90 backdrop-blur-md text-primary text-[10px] font-black px-4 py-1.5 rounded-full shadow-sm uppercase tracking-widest">
                            {{ $class->mentor ? $class->mentor->name : $class->instructor_name }}
                        </span>
                    </div>
                </div>

                <div class="p-10 flex flex-col flex-grow">
                    <div class="flex items-center gap-2 text-[11px] font-black text-primary mb-2 uppercase tracking-[0.1em]">
                        <span class="material-symbols-outlined text-sm">schedule</span>
                        {{ $class->day_of_week }} • {{ substr($class->time_start, 0, 5) }} WIB
                    </div>

                    <h3 class="serif-title text-2xl font-bold text-charcoal mb-2 group-hover:text-primary transition-colors tracking-tight">
                        {{ $class->title }}
                    </h3>

                    @if($class->song_title)
                    <div class="flex items-center gap-2 text-[10px] font-bold text-charcoal/40 mb-4 italic">
                        <span class="material-symbols-outlined text-xs">music_note</span>
                        {{ $class->song_title }}
                    </div>
                    @endif

                    <p class="text-charcoal/60 text-sm font-light leading-relaxed mb-8 flex-grow">
                        {{ $class->description }}
                    </p>

                    <div class="flex items-center justify-between mb-4">
                        <span class="text-primary font-black text-lg">Rp{{ number_format($class->price, 0, ',', '.') }}</span>
                    </div>

                    <div class="pt-4 border-t border-charcoal/5">
                        <a href="{{ route('open-class.show', $class->slug) }}"
                           class="btn-main w-full py-4 rounded-2xl text-xs font-black uppercase tracking-[0.2em] text-center block shadow-lg">
                            Lihat Detail & Daftar
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-20">
                <span class="material-symbols-outlined text-6xl text-naomi-muted">event_busy</span>
                <p class="text-charcoal/40 mt-4 font-medium">Belum ada kelas aktif saat ini.</p>
            </div>
            @endforelse

        </div>
    </section>

</main>
@endsection
