@extends('layouts.app')

@section('title', 'Detail Studio - Naomi Studio')

@section('content')
<main class="bg-naomi-bg text-charcoal">

    {{-- HERO SECTION --}}
    <section class="relative h-[85vh] md:h-[90vh] overflow-hidden">
        <div class="absolute inset-0 bg-charcoal/40 z-10"></div>
        @if($studio->primaryImage)
            <div class="absolute inset-0 bg-cover bg-center animate-slow-zoom"
                 style="background-image: url('{{ asset('storage/' . $studio->primaryImage->image_url) }}')"></div>
        @else
            <div class="absolute inset-0 bg-naomi-surface"></div>
        @endif

        <div class="relative z-20 max-w-7xl mx-auto px-6 h-full flex flex-col justify-center items-start text-naomi-white">
            <span class="inline-block px-5 py-2 bg-naomi-white/10 backdrop-blur-md rounded-full text-[10px] font-black uppercase tracking-[0.3em] mb-6">
                Premium Studio
            </span>
            <h1 class="serif-title text-6xl md:text-8xl font-black leading-none mb-6 tracking-tight">
                {{ $studio->name }}
            </h1>
            <p class="text-xl md:text-2xl max-w-2xl font-light leading-relaxed opacity-90">
                {{ $studio->description }}
            </p>
        </div>

        {{-- Floating Price Bar --}}
        <div class="absolute bottom-12 left-1/2 -translate-x-1/2 bg-naomi-white shadow-2xl rounded-[2.5rem] px-10 py-6 flex flex-col sm:flex-row items-center gap-8 z-30 w-[90%] md:w-auto">
            <div class="flex items-baseline gap-2">
                <span class="text-primary text-4xl font-black">Rp{{ number_format($studio->price_per_hour, 0, ',', '.') }}</span>
                <span class="text-naomi-muted text-sm font-bold uppercase tracking-widest">/ Jam</span>
            </div>
            <a href="{{ route('booking.index', ['studio' => $studio->id]) }}"
               class="btn-main px-12 py-5 shadow-xl hover:scale-105 transition-transform text-sm font-black uppercase tracking-widest w-full sm:w-auto">
                Mulai Booking
            </a>
        </div>
    </section>

    {{-- GALLERY SECTION - BENTO STYLE --}}
    <section class="py-32 px-6 max-w-7xl mx-auto">
        <div class="mb-20">
            <span class="text-primary font-bold tracking-[0.2em] uppercase text-xs mb-4 block">Visual Tour</span>
            <h2 class="serif-title text-5xl font-bold text-charcoal tracking-tight leading-none">Detail Estetika Ruang</h2>
        </div>

        @php $images = $studio->images->sortByDesc('is_primary'); @endphp

        @if($images->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
            {{-- Gambar utama --}}
            <div class="md:col-span-8 h-[600px] overflow-hidden rounded-[2rem] group relative shadow-lg">
                <img src="{{ asset('storage/' . $images->first()->image_url) }}"
                     class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110"
                     alt="{{ $studio->name }}">
                <div class="absolute inset-0 bg-gradient-to-t from-charcoal/60 to-transparent"></div>
                <div class="absolute bottom-10 left-10 text-naomi-white">
                    <p class="text-[10px] uppercase tracking-[0.3em] font-bold mb-2 opacity-80">Main Floor</p>
                    <h3 class="serif-title text-4xl font-bold">{{ $studio->size_sqm }}</h3>
                </div>
            </div>
            {{-- Gambar tambahan --}}
            <div class="md:col-span-4 grid grid-rows-2 gap-8">
                @foreach($images->skip(1)->take(2) as $image)
                <div class="h-[284px] overflow-hidden rounded-[2rem] group relative shadow-lg">
                    <img src="{{ asset('storage/' . $image->image_url) }}"
                         class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110"
                         alt="{{ $studio->name }}">
                    <div class="absolute inset-0 bg-charcoal/20 group-hover:bg-transparent transition-all"></div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        {{-- Fallback kalau belum ada foto di DB --}}
        <div class="h-[400px] rounded-[2rem] bg-naomi-surface flex items-center justify-center">
            <div class="text-center">
                <span class="material-symbols-outlined text-6xl text-naomi-muted">image</span>
                <p class="text-naomi-muted mt-4 font-medium">Foto studio belum tersedia</p>
            </div>
        </div>
        @endif
    </section>

    {{-- FASILITAS SECTION --}}
    <section class="py-32 bg-naomi-surface/10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="mb-20 text-center">
                <span class="text-primary font-bold tracking-[0.2em] uppercase text-xs mb-4 block">Facilities</span>
                <h2 class="serif-title text-5xl font-bold text-charcoal tracking-tight">Fasilitas Premium</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($studio->facilities as $facility)
                <div class="bg-naomi-white p-10 rounded-[2rem] shadow-sm hover:shadow-xl transition-all group">
                    <span class="material-symbols-outlined text-5xl text-primary mb-8 transition-transform group-hover:scale-110 duration-500 block">
                        {{ $facility->icon ?? 'check_circle' }}
                    </span>
                    <h3 class="serif-title text-2xl font-bold mb-4 text-charcoal tracking-tight">{{ $facility->name }}</h3>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- RULES SECTION --}}
    @if($studio->rules)
    <section class="py-24 px-6 max-w-4xl mx-auto">
        <div class="text-center mb-16">
            <span class="text-primary font-bold tracking-[0.2em] uppercase text-xs mb-4 block">Rules</span>
            <h2 class="serif-title text-5xl font-bold text-charcoal tracking-tight">Peraturan Studio</h2>
        </div>
        <div class="bg-naomi-white rounded-[2.5rem] p-10 shadow-sm border border-charcoal/5">
            <ul class="space-y-4">
                @foreach(array_filter(explode("\n", $studio->rules)) as $rule)
                @php $rule = trim($rule); @endphp
                @if($rule)
                <li class="flex items-start gap-4">
                    <span class="material-symbols-outlined text-primary mt-0.5 shrink-0">check_circle</span>
                    <span class="text-charcoal/80 font-medium leading-relaxed">{{ ltrim($rule, '-•* ') }}</span>
                </li>
                @endif
                @endforeach
            </ul>
        </div>
    </section>
    @endif

    {{-- INFO SECTION --}}
    <section class="py-32 px-6 max-w-4xl mx-auto">
        <div class="text-center mb-16">
            <span class="text-primary font-bold tracking-[0.2em] uppercase text-xs mb-4 block">Detail</span>
            <h2 class="serif-title text-5xl font-bold text-charcoal tracking-tight">Informasi Studio</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 text-center">
            <div class="bg-naomi-white p-8 rounded-[2rem] shadow-sm">
                <span class="material-symbols-outlined text-4xl text-primary mb-4 block">groups</span>
                <p class="text-naomi-muted text-xs font-black uppercase tracking-widest mb-2">Kapasitas</p>
                <p class="text-2xl font-black text-charcoal">{{ $studio->capacity }}+ Orang</p>
            </div>
            <div class="bg-naomi-white p-8 rounded-[2rem] shadow-sm">
                <span class="material-symbols-outlined text-4xl text-primary mb-4 block">straighten</span>
                <p class="text-naomi-muted text-xs font-black uppercase tracking-widest mb-2">Ukuran</p>
                <p class="text-2xl font-black text-charcoal">{{ $studio->size_sqm ?? '-' }}</p>
            </div>
            <div class="bg-naomi-white p-8 rounded-[2rem] shadow-sm">
                <span class="material-symbols-outlined text-4xl text-primary mb-4 block">floor</span>
                <p class="text-naomi-muted text-xs font-black uppercase tracking-widest mb-2">Lantai</p>
                <p class="text-2xl font-black text-charcoal">{{ $studio->floor_type ?? '-' }}</p>
            </div>
        </div>
    </section>

</main>

<style>
    @keyframes slow-zoom { from { transform: scale(1); } to { transform: scale(1.1); } }
    .animate-slow-zoom { animation: slow-zoom 20s ease-in-out infinite alternate; }
</style>
@endsection