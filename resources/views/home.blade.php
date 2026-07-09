@extends('layouts.app')

@section('title', 'Naomi Studio | Sewa Studio & Open Class Elegan di Jogja')

@section('content')
<main class="bg-naomi-bg">

    {{-- HERO SECTION --}}
    <section class="relative h-screen w-full overflow-hidden">
        <div class="absolute inset-0 bg-charcoal/50 z-10"></div>
        <div class="absolute inset-0 bg-cover bg-center"
             style="background-image: url('{{ asset('storage/aset aku/bg homepagee.JPG') }}')">
        </div>

        <div class="relative z-20 max-w-7xl mx-auto px-6 h-full flex flex-col justify-center items-start">
            <div class="max-w-2xl">
                <h2 class="serif-title text-naomi-white text-5xl md:text-7xl font-black leading-tight mb-6">
                    Naomi Studio – <span class="text-naomi-surface italic">Sewa Studio</span> & Open Class Elegan
                </h2>
                <p class="text-naomi-bg/90 text-lg md:text-xl font-medium leading-relaxed mb-10 max-w-xl">
                    Booking mudah, jadwal real-time, kelas terbuka berkualitas.
                    Nikmati fasilitas studio premium di pusat kota Yogyakarta.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('booking.index') }}" class="btn-main px-8 py-4 shadow-lg">
                        <span>Cek Jadwal & Booking</span>
                        <span class="material-symbols-outlined">calendar_today</span>
                    </a>
                    <a href="{{ route('open-class.index') }}"
                       class="px-8 py-4 border-2 border-naomi-surface text-naomi-surface font-bold rounded-xl hover:bg-naomi-surface/20 transition-all flex items-center justify-center gap-2">
                        Lihat Kelas
                    </a>
                </div>
            </div>
        </div>

        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-20 animate-bounce">
            <span class="material-symbols-outlined text-naomi-bg text-4xl">keyboard_double_arrow_down</span>
        </div>
    </section>

    {{-- OPEN CLASS SECTION --}}
    <section class="py-12 max-w-7xl mx-auto px-6 bg-naomi-bg">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
            <div>
                <span class="text-primary font-bold tracking-[0.2em] uppercase text-sm mb-4 block">Education</span>
                <h2 class="serif-title text-4xl md:text-5xl font-bold text-charcoal">Upcoming Open Class</h2>
            </div>
            <a href="{{ route('open-class.index') }}" class="hover-link text-primary font-bold border-b-2 border-primary/20 pb-1">Lihat Semua Jadwal</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($openClasses as $class)
            <div class="card-naomi bg-naomi-white flex flex-col shadow-sm border-none overflow-hidden group cursor-pointer">
                <div class="relative aspect-[4/5] overflow-hidden">
                    @if($class->thumbnail)
                        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110"
                             style="background-image: url('{{ asset('storage/' . $class->thumbnail) }}')"></div>
                    @else
                        <div class="absolute inset-0 bg-naomi-surface flex items-center justify-center">
                            <span class="material-symbols-outlined text-5xl text-naomi-muted">image</span>
                        </div>
                    @endif
                    <div class="absolute top-4 left-4 bg-naomi-white/90 backdrop-blur-md px-4 py-2 rounded-lg shadow-sm">
                        <span class="text-xs font-bold text-primary italic uppercase tracking-widest">{{ $class->instructor_name }}</span>
                    </div>
                </div>

                <div class="p-6 flex-grow flex flex-col">
                    <div class="flex items-center gap-2 text-naomi-muted text-xs font-bold uppercase mb-2">
                        <span class="material-symbols-outlined text-sm text-primary">schedule</span>
                        <span>{{ $class->day_of_week }}, {{ substr($class->time_start, 0, 5) }} - {{ substr($class->time_end, 0, 5) }}</span>
                    </div>

                    <h3 class="serif-title text-2xl font-bold text-charcoal group-hover:text-primary transition-colors mb-2">
                        {{ $class->title }}
                    </h3>

                    @if($class->song_title)
                    <div class="flex items-center gap-2 text-[10px] font-bold text-charcoal/40 mb-2 italic">
                        <span class="material-symbols-outlined text-xs">music_note</span>
                        {{ $class->song_title }}
                    </div>
                    @endif

                    <p class="text-charcoal/70 text-sm leading-relaxed line-clamp-2 mb-4 flex-grow">
                        {{ $class->description }}
                    </p>

                    <div class="pt-3">
                        <a href="{{ route('open-class.show', $class->slug) }}" class="btn-main w-full py-3 rounded-xl text-sm text-center block">
                            Daftar Kelas
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-10 text-charcoal/40">
                Belum ada open class aktif.
            </div>
            @endforelse
        </div>
    </section>

    {{-- STUDIO RENTAL SECTION --}}
    <section class="py-12 bg-naomi-bg">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-8">
                <span class="text-primary font-bold tracking-[0.2em] uppercase text-sm mb-3 block">Premium Spaces</span>
                <h2 class="serif-title text-4xl md:text-5xl font-bold mb-4 text-charcoal">Sewa Studio Premium</h2>
                <p class="text-naomi-muted max-w-xl mx-auto font-medium">Ruang latihan profesional dengan standar internasional untuk mendukung kreativitas tanpa batas.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-10">
                @foreach($studios as $studio)
                <div class="card-naomi bg-naomi-white flex flex-col shadow-sm border-none">
                    <div class="h-72 overflow-hidden relative">
                        @if($studio->primaryImage)
                            <div class="absolute inset-0 bg-cover bg-center"
                                 style="background-image: url('{{ asset('storage/' . $studio->primaryImage->image_url) }}')"></div>
                        @else
                            <div class="absolute inset-0 bg-naomi-surface flex items-center justify-center">
                                <span class="material-symbols-outlined text-5xl text-naomi-muted">image</span>
                            </div>
                        @endif
                        @if($loop->first)
                            <div class="absolute top-4 right-4 bg-primary text-naomi-white px-4 py-1 rounded text-sm font-bold">Best Value</div>
                        @endif
                    </div>
                    <div class="p-7 flex-grow flex flex-col">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="serif-title text-3xl font-bold text-charcoal">{{ $studio->name }}</h3>
                            <div class="text-right">
                                <span class="text-primary text-2xl font-black">Rp{{ number_format($studio->price_per_hour / 1000, 0) }}k</span>
                                <span class="text-naomi-muted text-sm block">/ Jam</span>
                            </div>
                        </div>
                        <ul class="space-y-3 mb-6 text-charcoal/80 flex-grow">
                            @foreach($studio->facilities->take(3) as $facility)
                            <li class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary">check_circle</span>
                                {{ $facility->name }}
                            </li>
                            @endforeach
                        </ul>
                        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
            <a href="{{ route('booking.index', ['studio' => $studio->id]) }}" class="btn-main py-4 text-center">Booking</a>
                            <a href="{{ route('studios.show', $studio->slug) }}"
                               class="py-4 border-2 border-primary text-primary font-bold rounded-xl hover:bg-primary/5 transition-all text-center">Detail</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    {{-- REVIEW SECTION --}}
    @if($latestReviews->count() > 0)
    <section class="py-12 bg-naomi-surface/10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-8">
                <span class="text-primary font-bold tracking-[0.2em] uppercase text-sm mb-3 block">Testimonials</span>
                <h2 class="serif-title text-4xl md:text-5xl font-bold text-charcoal">Kata Mereka</h2>
                <p class="text-naomi-muted max-w-xl mx-auto font-medium mt-3">Pengalaman nyata dari pelanggan setia Naomi Studio.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($latestReviews as $review)
                @php
                    $firstName  = mb_substr($review->customer->name, 0, 1);
                    $maskedName = $firstName . '***';
                @endphp
                <div class="bg-naomi-white rounded-[2rem] p-8 shadow-sm border border-charcoal/5 flex flex-col gap-4">
                    {{-- Rating --}}
                    <div class="flex items-center gap-1">
                        @for($i = 1; $i <= 5; $i++)
                        <span class="material-symbols-outlined text-lg {{ $i <= $review->rating ? 'text-yellow-400' : 'text-charcoal/20' }}" style="{{ $i <= $review->rating ? "font-variation-settings: 'FILL' 1;" : "font-variation-settings: 'FILL' 0;" }}">star</span>
                        @endfor
                    </div>

                    {{-- Komentar --}}
                    @if($review->comment)
                    <p class="text-charcoal/70 text-sm leading-relaxed italic flex-grow">"{{ $review->comment }}"</p>
                    @else
                    <p class="text-charcoal/30 text-sm italic flex-grow">—</p>
                    @endif

                    {{-- Customer & Studio --}}
                    <div class="flex items-center justify-between pt-4 border-t border-naomi-bg">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
                                <span class="text-primary font-black text-xs">{{ $firstName }}</span>
                            </div>
                            <div>
                                <p class="font-black text-charcoal text-xs">{{ $maskedName }}</p>
                                <p class="text-[10px] text-charcoal/40 font-bold">{{ $review->studio->name }}</p>
                            </div>
                        </div>
                        <p class="text-[10px] text-charcoal/30 font-bold">{{ $review->created_at->format('d M Y') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

</main>
@endsection
