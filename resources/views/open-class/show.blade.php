@extends('layouts.app')

@section('title', 'Detail Kelas - Naomi Studio')

@section('content')
<main class="bg-naomi-bg text-charcoal antialiased">

    {{-- HERO SECTION --}}
    <section class="relative h-[85vh] md:h-[90vh] overflow-hidden">
        <div class="absolute inset-0 bg-charcoal/40 z-10"></div>
        @if($class->thumbnail)
            <div class="absolute inset-0 bg-cover bg-center animate-slow-zoom"
                 style="background-image: url('{{ asset('storage/' . $class->thumbnail) }}')"></div>
        @else
            <div class="absolute inset-0 bg-naomi-surface"></div>
        @endif

        <div class="relative z-20 max-w-7xl mx-auto px-6 h-full flex flex-col justify-center items-start text-naomi-white">
            <span class="inline-block px-5 py-2 bg-naomi-white/10 backdrop-blur-md rounded-full text-[10px] font-black uppercase tracking-[0.3em] mb-6">
                Premium Open Class
            </span>
            <h1 class="serif-title text-6xl md:text-8xl font-black leading-none mb-6 tracking-tight max-w-5xl">
                {{ $class->title }}
            </h1>
            <p class="text-xl md:text-2xl max-w-2xl font-light leading-relaxed opacity-90">
                Tingkatkan skill koreografi dan ekspresimu langsung bersama mentor berpengalaman di Naomi Studio Yogyakarta.
            </p>
        </div>

        {{-- Floating Price & CTA Bar --}}
        <div class="absolute bottom-12 left-1/2 -translate-x-1/2 bg-naomi-white shadow-2xl rounded-[2.5rem] px-10 py-6 flex flex-col sm:flex-row items-center gap-8 z-30 w-[90%] md:w-auto border border-charcoal/5">
            <div class="flex items-center gap-6">
                @if($class->early_bird_price)
                <div>
                    <span class="text-naomi-muted text-[10px] font-black uppercase tracking-widest block mb-0.5">Early Bird</span>
                    <span class="text-charcoal text-xl font-black">Rp{{ number_format($class->early_bird_price, 0, ',', '.') }}</span>
                </div>
                <div class="w-[1px] h-8 bg-charcoal/10"></div>
                @endif
                <div>
                    <span class="text-primary text-[10px] font-black uppercase tracking-widest block mb-0.5">D-Day Price</span>
                    <span class="text-primary text-3xl font-black">Rp{{ number_format($class->price, 0, ',', '.') }}</span>
                </div>
            </div>
            
            <a href="{{ $class->whatsapp_link }}?text={{ urlencode('Halo ' . $class->instructor_name . ', saya mau daftar kelas ' . $class->title . ' lewat Naomi Studio') }}"
               target="_blank"
               class="bg-[#128C7E] hover:bg-charcoal text-white text-center px-10 py-5 shadow-xl rounded-full transition-all text-sm font-black uppercase tracking-widest w-full sm:w-auto flex items-center justify-center gap-2">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.588-5.946 0-6.556 5.332-11.888 11.888-11.888 3.176 0 6.161 1.237 8.404 3.48s3.481 5.229 3.481 8.404c0 6.556-5.332 11.888-11.888 11.888-2.01 0-3.986-.511-5.741-1.481l-6.243 1.706z"/>
                </svg>
                Daftar via WA
            </a>
        </div>
    </section>

    {{-- KELAS INFO SECTION (Rapet & Padat) --}}
    <section class="py-12 px-6 max-w-7xl mx-auto">
        <div class="mb-8">
            <span class="text-primary font-bold tracking-[0.2em] uppercase text-xs mb-2 block">Schedule & Details</span>
            <h2 class="serif-title text-5xl font-bold text-charcoal tracking-tight leading-none">Informasi Pelaksanaan</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
            <div class="bg-naomi-white p-10 rounded-[2.5rem] shadow-sm border border-charcoal/5">
                <span class="material-symbols-outlined text-5xl text-primary mb-6 block">schedule</span>
                <p class="text-naomi-muted text-xs font-black uppercase tracking-widest mb-2">Waktu & Tanggal</p>
                <p class="text-2xl font-black text-charcoal leading-tight">{{ $class->day_of_week }}</p>
                <p class="text-base font-bold text-charcoal/70 mt-1">{{ substr($class->time_start, 0, 5) }} – {{ substr($class->time_end, 0, 5) }} WIB</p>
                <p class="text-sm text-slate-400 mt-2">{{ $class->class_date ? $class->class_date->format('d M Y') : 'Segera Ditentukan' }}</p>
            </div>
            
            <div class="bg-naomi-white p-10 rounded-[2.5rem] shadow-sm border border-charcoal/5 flex flex-col justify-center items-center md:items-start">
                <span class="material-symbols-outlined text-5xl text-primary mb-6 block">person</span>
                <p class="text-naomi-muted text-xs font-black uppercase tracking-widest mb-2">Mentor / Koreografer</p>
                <p class="text-3xl font-black text-charcoal leading-tight">{{ $class->mentor ? $class->mentor->name : $class->instructor_name }}</p>
            </div>

            <div class="bg-naomi-white p-10 rounded-[2.5rem] shadow-sm border border-charcoal/5 flex flex-col justify-center items-center md:items-start">
                <span class="material-symbols-outlined text-5xl text-primary mb-6 block">music_note</span>
                <p class="text-naomi-muted text-xs font-black uppercase tracking-widest mb-2">Song / Backsound</p>
                <p class="text-3xl font-black text-charcoal italic leading-tight">{{ $class->song_title ?? 'Diumumkan di Kelas' }}</p>
            </div>
        </div>
    </section>

    {{-- DESKRIPSI MATERI SECTION (Jarak py dipangkas total) --}}
    @if($class->description)
    <section class="py-12 bg-naomi-surface/30 border-y border-charcoal/5">
        <div class="max-w-7xl mx-auto px-6">
            <div class="mb-8">
                <span class="text-primary font-bold tracking-[0.2em] uppercase text-xs mb-2 block">Syllabus</span>
                <h2 class="serif-title text-5xl font-bold text-charcoal tracking-tight leading-none">Tentang Kelas Ini</h2>
            </div>
            <div class="bg-naomi-white rounded-[2.5rem] p-10 shadow-sm border border-charcoal/5">
                <p class="text-charcoal/80 font-light leading-relaxed text-lg whitespace-pre-line">
                    {{ $class->description }}
                </p>
            </div>
        </div>
    </section>
    @endif

    {{-- PROFIL MENTOR SECTION --}}
    @if($class->mentor)
    <section class="py-12 px-6 max-w-7xl mx-auto">
        <div class="mb-8">
            <span class="text-primary font-bold tracking-[0.2em] uppercase text-xs mb-2 block">Instructor</span>
            <h2 class="serif-title text-5xl font-bold text-charcoal tracking-tight leading-none">Kenalan Sama Mentor</h2>
        </div>

        <div class="bg-naomi-white p-10 md:p-14 rounded-[2.5rem] shadow-sm border border-charcoal/5">
            <div class="flex flex-col md:flex-row gap-10 items-center md:items-start text-center md:text-left">
                <div class="shrink-0">
                    @if($class->mentor->photo)
                        <img src="{{ asset('storage/' . $class->mentor->photo) }}"
                             alt="{{ $class->mentor->name }}"
                             class="w-32 h-32 rounded-[2rem] object-cover shadow-md border border-charcoal/5">
                    @else
                        <div class="w-32 h-32 rounded-[2rem] bg-primary/10 flex items-center justify-center border border-charcoal/5">
                            <span class="material-symbols-outlined text-5xl text-primary">person</span>
                        </div>
                    @endif
                </div>

                <div class="flex-1 space-y-6 w-full">
                    <h3 class="serif-title text-4xl font-bold text-charcoal tracking-tight">{{ $class->mentor->name }}</h3>
                    @if($class->mentor->bio)
                        <p class="text-charcoal/70 leading-relaxed font-light text-base md:text-lg">{{ $class->mentor->bio }}</p>
                    @endif
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2 text-left">
                        @if($class->mentor->experience)
                        <div class="bg-naomi-bg p-6 rounded-2xl border border-charcoal/5">
                            <p class="text-[10px] uppercase tracking-[0.2em] text-naomi-muted font-black mb-2">Pengalaman</p>
                            <p class="text-charcoal/80 text-sm font-light leading-relaxed">{{ $class->mentor->experience }}</p>
                        </div>
                        @endif
                        @if($class->mentor->expertise)
                        <div class="bg-naomi-bg p-6 rounded-2xl border border-charcoal/5">
                            <p class="text-[10px] uppercase tracking-[0.2em] text-naomi-muted font-black mb-2">Keunggulan</p>
                            <p class="text-charcoal/80 text-sm font-light leading-relaxed">{{ $class->mentor->expertise }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- FOOTER MURNI --}}
    <footer class="py-8 text-center">
        <div class="w-10 h-[1px] bg-charcoal/10 mx-auto mb-4"></div>
        <p class="text-charcoal/30 text-[10px] uppercase tracking-[0.2em] font-medium">© 2026 Naomi Studio Yogyakarta</p>
    </footer>

</main>

<style>
    @keyframes slow-zoom { from { transform: scale(1); } to { transform: scale(1.1); } }
    .animate-slow-zoom { animation: slow-zoom 20s ease-in-out infinite alternate; }
</style>
@endsection