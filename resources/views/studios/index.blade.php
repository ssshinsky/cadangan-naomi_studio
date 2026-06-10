@extends('layouts.app')

@section('title', 'Detail Studio | Naomi Studio')

@section('content')
<main class="bg-naomi-bg">

    {{-- HERO SECTION --}}
    <section class="relative py-14 lg:py-20 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-10">
                <div class="flex-1 space-y-5">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 border border-primary/20 text-primary text-[10px] font-black uppercase tracking-[0.2em]">
                        <span class="size-2 rounded-full bg-primary animate-pulse"></span>
                        Premium Dance Space
                    </div>
                    <h1 class="serif-title text-5xl lg:text-7xl font-black text-charcoal leading-tight tracking-tight">
                        Detail <span class="text-primary">Studio</span> Kami
                    </h1>
                    <p class="text-lg text-charcoal/70 max-w-xl leading-relaxed font-light">
                        Ruang latihan premium dengan standar kualitas tinggi untuk ekspresi seni tanpa batas.
                    </p>
                    <a href="#studio-cards" class="btn-main px-10 py-4 shadow-lg inline-flex items-center gap-2">
                        <span>Eksplorasi Ruang</span>
                        <span class="material-symbols-outlined">arrow_downward</span>
                    </a>
                </div>
                <div class="flex-1 w-full relative">
                    <div class="aspect-[4/3] rounded-[2.5rem] overflow-hidden shadow-2xl border-8 border-naomi-white rotate-2">
                        <div class="w-full h-full bg-cover bg-center animate-slow-zoom" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuC60v8ynFPTN5KKXAlT-sm7EtQMlIQjXU3yDcaIW7m-jOlsJG8w74q7NUk513C63pcL7ii7fBwb78Xua0UkzM-X0otF-PGjWZw86csNRYWAb1T0bAdhhtAFUowoYUy9hcSulNVLeP5Q0rN25HpJKWEJdAtjGEK2mhn2GjQpTZJDP2Aoxzwn4oMQO1ppNCX9lpJd00M4sATPzXFmNiypEpdKlrH0AP0f5-adYJUo7b8AKaGjNmHQg-o_--kkHKYhaGvqqhW3rx27Lq6k')"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="absolute top-0 right-0 w-1/3 h-full bg-primary/5 -skew-x-12 transform origin-top translate-x-1/2 -z-0"></div>
    </section>

    {{-- STUDIO CARDS SECTION --}}
    <section id="studio-cards" class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 space-y-12">

            @foreach($studios as $i => $studio)
            <div class="bg-naomi-white rounded-[3rem] overflow-hidden shadow-xl border border-charcoal/5 flex flex-col {{ $i % 2 === 0 ? 'lg:flex-row' : 'lg:flex-row-reverse' }} group">

                {{-- Gambar --}}
                <div class="lg:w-3/5 h-[400px] lg:h-auto relative overflow-hidden">
                    @if($studio->primaryImage)
                        <div class="w-full h-full bg-cover bg-center transition-transform duration-1000 group-hover:scale-105"
                             style="background-image: url('{{ asset('storage/' . $studio->primaryImage->image_url) }}')"></div>
                    @else
                        <div class="w-full h-full bg-naomi-surface flex items-center justify-center">
                            <span class="material-symbols-outlined text-6xl text-naomi-muted">image</span>
                        </div>
                    @endif
                    <div class="absolute top-6 {{ $i % 2 === 0 ? 'left-6' : 'right-6' }}">
                        <span class="bg-primary text-naomi-white px-5 py-2 rounded-full text-[10px] font-black uppercase tracking-widest shadow-lg">
                            {{ $i === 0 ? 'Most Requested' : 'Private Session' }}
                        </span>
                    </div>
                </div>

                {{-- Info --}}
                <div class="lg:w-2/5 p-8 lg:p-10 flex flex-col justify-center">
                    <span class="text-primary font-bold uppercase tracking-[0.2em] text-xs mb-2 block">
                        {{ $studio->size_sqm ?? 'Premium Space' }}
                    </span>
                    <h2 class="serif-title text-4xl lg:text-5xl font-bold text-charcoal mb-5 tracking-tight">
                        {{ $studio->name }}
                    </h2>

                    <div class="grid grid-cols-2 gap-4 border-y border-charcoal/5 py-5 mb-5">
                        <div>
                            <span class="text-naomi-muted text-[10px] font-black uppercase tracking-widest block mb-1">Kapasitas</span>
                            <p class="text-charcoal font-bold text-xl">{{ $studio->capacity }}+ Orang</p>
                        </div>
                        <div>
                            <span class="text-naomi-muted text-[10px] font-black uppercase tracking-widest block mb-1">Harga Sewa</span>
                            <p class="text-primary font-black text-xl">
                                Rp{{ number_format($studio->price_per_hour, 0, ',', '.') }}
                                <span class="text-xs font-normal text-charcoal/50">/jam</span>
                            </p>
                        </div>
                    </div>

                    <ul class="space-y-3 mb-6">
                        @foreach($studio->facilities->take(3) as $facility)
                        <li class="flex items-center gap-4 text-charcoal/70 text-sm font-medium">
                            <span class="material-symbols-outlined text-primary text-xl">{{ $facility->icon ?? 'check_circle' }}</span>
                            {{ $facility->name }}
                        </li>
                        @endforeach
                    </ul>

                    <div class="flex gap-4">
                        <a href="{{ route('booking.index', ['studio' => $studio->id]) }}" class="btn-main flex-1 py-4 text-xs font-black uppercase tracking-widest text-center">
                            Booking Sekarang
                        </a>
                        <a href="{{ route('studios.show', $studio->slug) }}" class="size-14 border border-charcoal/10 rounded-2xl flex items-center justify-center hover:bg-charcoal hover:text-naomi-white transition-all">
                            <span class="material-symbols-outlined">info</span>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </section>

    {{-- FASILITAS UMUM --}}
    <section class="py-12 bg-naomi-bg">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 relative">
            <div class="text-center mb-10">
                <h2 class="serif-title text-4xl font-bold mb-4 text-charcoal tracking-tight">Fasilitas <span class="text-primary">Umum</span></h2>
                <div class="w-20 h-1 bg-primary mx-auto rounded-full"></div>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach([
                    ['icon' => 'weekend', 'title' => 'Area Tunggu', 'desc' => 'Lounge estetik & nyaman'],
                    ['icon' => 'shopping_basket', 'title' => 'Snack Shop', 'desc' => 'Menjual minuman & camilan'],
                    ['icon' => 'wc', 'title' => 'Toilet Bersih', 'desc' => 'Selalu terjaga harian'],
                    ['icon' => 'local_parking', 'title' => 'Parkir Luas', 'desc' => 'Aman untuk mobil & motor']
                ] as $f)
                <div class="text-center group">
                    <div class="size-14 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-primary group-hover:rotate-6 transition-all duration-300">
                        <span class="material-symbols-outlined text-2xl text-primary group-hover:text-naomi-white transition-colors">{{ $f['icon'] }}</span>
                    </div>
                    <h4 class="serif-title text-lg font-bold mb-1 text-charcoal tracking-tight">{{ $f['title'] }}</h4>
                    <p class="text-naomi-muted text-xs font-medium">{{ $f['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</main>

<style>
    @keyframes slow-zoom { from { transform: scale(1); } to { transform: scale(1.1); } }
    .animate-slow-zoom { animation: slow-zoom 20s ease-in-out infinite alternate; }
</style>
@endsection
