@extends('layouts.app')

@section('title', 'Detail Kelas - Open Class')

@section('content')
<main class="bg-naomi-bg min-h-screen">

    <div class="max-w-7xl mx-auto px-6 py-12 lg:py-20">

        {{-- HERO IMAGE SECTION --}}
        <div class="relative rounded-[3rem] overflow-hidden h-[400px] lg:h-[520px] mb-16 shadow-2xl group">
            @if($class->thumbnail)
                <img src="{{ asset('storage/' . $class->thumbnail) }}"
                     class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105" alt="{{ $class->title }}">
            @else
                <div class="w-full h-full bg-naomi-surface"></div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-charcoal/90 via-charcoal/20 to-transparent"></div>
            
            <div class="absolute bottom-10 left-10 right-10">
                <span class="inline-block px-5 py-2 bg-primary/90 backdrop-blur-sm text-naomi-white text-[10px] font-black rounded-full mb-4 tracking-[0.3em] uppercase">
                    Promotion Only
                </span>
                <h1 class="serif-title text-5xl md:text-7xl font-bold leading-tight text-naomi-white tracking-tight">
                    {{ $class->title }}
                </h1>
            </div>
        </div>

        {{-- CONTENT GRID --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">

            {{-- Info Box --}}
            <div class="lg:col-span-5 bg-naomi-white border border-charcoal/5 rounded-[2.5rem] p-10 lg:p-14 shadow-sm sticky top-8 self-start">
                <h3 class="serif-title text-4xl font-bold mb-10 text-charcoal tracking-tight">Detail Kelas</h3>
                
                <div class="space-y-10">
                    {{-- Jadwal --}}
                    <div class="flex items-start gap-4">
                        <div class="size-12 bg-primary/10 rounded-xl flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-primary">schedule</span>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase tracking-[0.2em] text-naomi-muted font-black mb-1">Jadwal</p>
                            <p class="text-xl font-bold text-charcoal">{{ $class->day_of_week }}, {{ substr($class->time_start, 0, 5) }} – {{ substr($class->time_end, 0, 5) }} WIB</p>
                        </div>
                    </div>

                    {{-- Mentor --}}
                    <div class="flex items-start gap-4">
                        <div class="size-12 bg-primary/10 rounded-xl flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-primary">person</span>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase tracking-[0.2em] text-naomi-muted font-black mb-1">Mentor</p>
                            <p class="text-xl font-bold text-charcoal">{{ $class->instructor_name }}</p>
                        </div>
                    </div>

                    {{-- Lagu --}}
                    @if($class->song_title)
                    <div class="flex items-start gap-4">
                        <div class="size-12 bg-primary/10 rounded-xl flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-primary">music_note</span>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase tracking-[0.2em] text-naomi-muted font-black mb-1">Song / Backsound</p>
                            <p class="text-xl font-bold text-charcoal italic">{{ $class->song_title }}</p>
                        </div>
                    </div>
                    @endif

                    {{-- Harga --}}
                    <div class="flex items-start gap-4">
                        <div class="size-12 bg-primary/10 rounded-xl flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-primary">payments</span>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase tracking-[0.2em] text-naomi-muted font-black mb-1">Harga Sesi</p>
                            <p class="text-4xl font-black text-primary">Rp{{ number_format($class->price, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    @if($class->description)
                    <div class="pt-10 border-t border-charcoal/5">
                        <div class="flex items-center gap-2 text-primary mb-4">
                            <span class="material-symbols-outlined text-sm">auto_awesome</span>
                            <p class="font-black uppercase tracking-widest text-[10px]">Tentang Kelas</p>
                        </div>                        
                        <p class="text-charcoal/70 leading-relaxed font-light text-sm">
                            {{ $class->description }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Action Box (WA) --}}
            <div class="lg:col-span-7 bg-naomi-surface/30 rounded-[3rem] p-12 lg:p-20 border border-charcoal/5 flex flex-col items-center justify-center text-center">
                <div class="size-20 bg-naomi-white rounded-[2rem] shadow-sm flex items-center justify-center mb-8 border border-charcoal/5">
                    <span class="material-symbols-outlined text-4xl text-primary">forum</span>
                </div>
                
                <h3 class="serif-title text-3xl lg:text-4xl font-bold mb-6 text-charcoal tracking-tight">Siap Untuk Join?</h3>
                <p class="text-charcoal/60 mb-12 max-w-md leading-relaxed font-light">
                    Naomi Studio mempromosikan kelas eksklusif ini. Untuk pendaftaran, silakan langsung hubungi WhatsApp {{ $class->instructor_name }}.
                </p>

                <a href="{{ $class->whatsapp_link }}?text={{ urlencode('Halo ' . $class->instructor_name . ', saya mau daftar kelas ' . $class->title . ' lewat Naomi Studio') }}" 
                   target="_blank"
                   class="group relative w-full bg-[#128C7E] hover:bg-charcoal text-naomi-white py-6 rounded-2xl font-black text-sm tracking-[0.2em] transition-all shadow-xl shadow-primary/10 flex items-center justify-center gap-4 overflow-hidden">
                    
                    <div class="absolute inset-0 w-full h-full bg-white/5 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                    
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.588-5.946 0-6.556 5.332-11.888 11.888-11.888 3.176 0 6.161 1.237 8.404 3.48s3.481 5.229 3.481 8.404c0 6.556-5.332 11.888-11.888 11.888-2.01 0-3.986-.511-5.741-1.481l-6.243 1.706z"/>
                    </svg>
                    REGISTER VIA WHATSAPP
                </a>

                <p class="mt-12 text-[9px] text-naomi-muted uppercase tracking-[0.4em] font-black">
                    Official Promotion by Naomi Studio
                </p>
            </div>
        </div>

        <div class="mt-24 text-center">
            <div class="w-10 h-[1px] bg-charcoal/10 mx-auto mb-6"></div>
            <p class="text-charcoal/30 text-[10px] uppercase tracking-[0.2em] font-medium">© 2026 Naomi Studio Yogyakarta</p>
        </div>

    </div>
</main>
@endsection
