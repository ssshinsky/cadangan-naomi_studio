@extends('layouts.app')

@section('title', 'About - Naomi Studio')

@section('content')
<main class="bg-naomi-bg min-h-screen">

    {{-- HERO SECTION --}}
    <section class="relative min-h-[80vh] flex items-center pt-20 pb-32 px-8 overflow-hidden">
        {{-- Dekorasi Abstract Shape --}}
        <div class="absolute top-0 right-0 w-1/2 h-full bg-naomi-surface/50 -z-10 skew-x-[-12deg] translate-x-20"></div>
        
        <div class="max-w-7xl mx-auto w-full grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
            <div class="lg:col-span-7">
                <span class="inline-block px-4 py-1.5 bg-primary/10 text-primary text-[10px] font-black tracking-[0.4em] uppercase mb-8 rounded-full">
                    The Editorial Stage
                </span>
                <h1 class="serif-title text-6xl md:text-[100px] font-bold leading-[0.85] tracking-tighter mb-10 text-charcoal">
                    Tentang <br/><span class="text-primary italic font-medium">Naomi Studio</span>
                </h1>
                <p class="text-xl md:text-2xl text-charcoal/120 max-w-xl leading-relaxed mb-12 font-light">
                    Wadah Kreativitas & Eksperimen Gerak di <span class="text-charcoal font-medium">Yogyakarta.</span>
                </p>
                <div class="flex items-center gap-6">
                    <div class="h-[1px] w-20 bg-charcoal/20"></div>
                    <span class="uppercase tracking-[0.3em] text-[10px] text-charcoal/40 font-black italic">Est. 2024</span>
                </div>
            </div>

            <div class="lg:col-span-5 relative">
                {{-- Frame Foto Premium --}}
                <div class="relative z-10 -rotate-2 group shadow-2xl rounded-[3rem] overflow-hidden aspect-[4/5] border-[12px] border-naomi-white">
                    <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuBNmZfJSrqb3HsmM9-uWJMcDWLmtCB8G_xeySOBDv0SNgSbr6dWjiXSfULJvLPEiVE_xzMtlGuxFW38IDA4RYz5WpUBjDyox4JyIoGaSTFHwvpuJ9ZaCuvzel441Qd2iTOEULmBfNDBirOC2lhOR1rmfT9xxk_2TAIn3Xrr0y292u-JWiFRBuGVNwnEJMVOnpiDQHQg0RDGDoZpmuxwLN70oLf0_aVGhWP5fno8BoANnJqefi7q95bVaDL286BOD8H0LROR-hj0mHgR" 
                         class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt="Professional dancer">
                </div>
                {{-- Aksen Lingkaran --}}
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-primary/10 rounded-full blur-3xl -z-0"></div>
            </div>
        </div>
    </section>

    {{-- OUR STORY --}}
    <section class="py-32 bg-naomi-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-24 items-center">
                <div class="order-2 lg:order-1 relative">
                    <div class="bg-naomi-bg p-4 rounded-[2.5rem] shadow-sm relative z-10">
                        <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuDhc8NhNiA_ddeM8Cq1-CvHQStqukFl_pX9WRrGhmdtIc7pl0HYSNFvzsFx2I_6pwZiP2RmrXFS9rG-H-pSs7HWWmJid257s2ousoXNZpec3TO3cpWzIzhL_eriVGq15FI-KBDFlGo2VuVtH7rinaWfx0frTwauK9urKoW2-12RC8bWOAqPOcoCK_JurFudAm5uj8ZcKUvTk_JwRfzzjxCTBHiNxBTPhUy_UIuJN6GlJoOw_EB1agRE3ac6TVWmAIT8OV4LdgyHqGGV" 
                             class="rounded-[2rem] grayscale hover:grayscale-0 transition-all duration-1000 aspect-[4/3] object-cover" alt="Cornelia at studio">
                    </div>
                    {{-- Badge Melayang --}}
                    <div class="absolute -top-8 -right-8 p-10 bg-charcoal text-naomi-white rounded-full shadow-2xl z-20 flex flex-col items-center justify-center border-4 border-naomi-white">
                        <span class="text-[10px] font-black tracking-widest uppercase opacity-50">Since</span>
                        <span class="serif-title italic text-3xl font-bold">2024</span>
                    </div>
                </div>

                <div class="order-1 lg:order-2 space-y-10">
                    <div class="inline-flex items-center gap-3">
                        <div class="w-2 h-2 bg-primary rounded-full"></div>
                        <span class="uppercase tracking-[0.3em] text-[10px] text-primary font-black">Our Origin Story</span>
                    </div>
                    <h2 class="serif-title text-5xl md:text-6xl font-bold leading-tight text-charcoal tracking-tight">
                        Visi Cornelia: <br/><span class="italic text-primary font-medium">Ruang Tanpa Batas</span>
                    </h2>
                    <div class="space-y-6 text-charcoal/120 text-lg leading-relaxed font-light">
                        <p>Berawal dari keresahan <span class="text-charcoal font-medium italic">Cornelia</span> akan kurangnya ruang representatif di Yogyakarta, Naomi Studio lahir sebagai manifestasi dari dedikasi terhadap estetika dan fungsionalitas.</p>
                        <p>Kami percaya bahwa setiap gerak, nada, dan ekspresi membutuhkan panggung yang layak. Naomi Studio dirancang untuk menjadi rumah yang inklusif—tempat kolaborasi lintas disiplin untuk melampaui batasan kreatif.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- THE SPACES --}}
    <section class="py-32 bg-naomi-bg">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="text-center mb-24">
                <span class="text-primary text-[10px] uppercase tracking-[0.5em] font-black mb-4 block">Fasilitas Eksklusif</span>
                <h2 class="serif-title text-5xl md:text-6xl font-bold text-charcoal mb-6 tracking-tighter ">The Spaces</h2>
                <div class="w-12 h-[1px] bg-charcoal/20 mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
                {{-- Studio Besar --}}
                <div class="group">
                    <div class="relative aspect-[16/10] rounded-[2.5rem] overflow-hidden shadow-2xl mb-10">
                        <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuBru3ocpef44bNhlyzpqE_D6nJi1uuhAD0SdzhUWURGOoXNMSvlzriZ2Kq6gpgitPeQYdWNM2kZpww7nLr3WVaXMep5aQ6fM9a4HZanNiR1HkjhCsL7YwP_CWyT1bo_psSv8yD9r1qZnFy6VhNWr27vBkikBePOhZQ1bw1cK6FDKOXNh7jpbrkguTp7x7ouQzVT08TiU5NsMuz7hwaCILoBEbva7eduAAxSn8MTyAl7uJbnVjZFmSHe8c8QIQuHV-eE4TKuVMnJlvqB" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000" alt="Studio Besar">
                        <div class="absolute top-6 right-6 bg-naomi-white/90 backdrop-blur-md px-5 py-2 rounded-full shadow-sm">
                            <p class="text-[10px] font-black tracking-widest text-charcoal uppercase">120 SQM</p>
                        </div>
                    </div>
                    <h3 class="serif-title text-3xl font-bold text-charcoal mb-4 group-hover:text-primary transition-colors ">Studio Besar</h3>
                    <p class="text-charcoal/120 leading-relaxed mb-8 font-light">
                        Langit-langit tinggi dan akustik yang disempurnakan menciptakan atmosfer megah namun tetap privat untuk latihan kelompok besar.
                    </p>
                    <div class="flex items-center gap-4 text-primary font-black text-[10px] uppercase tracking-[0.2em]">
                        <span class="flex items-center gap-2"><span class="size-1.5 bg-primary rounded-full"></span> Full Mirror Wall</span>
                    </div>
                </div>

                {{-- Studio Kecil --}}
                <div class="group md:mt-24">
                    <div class="relative aspect-[16/10] rounded-[2.5rem] overflow-hidden shadow-2xl mb-10">
                        <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuDBWq5wFsgqWn-8dTYyppgj2v7REU8oW2Yy3CdgNCnr95XH2BfE9Q4sBd6vxP_Yyw4cEVyFHGkdHZ7Mee6DaqVeX_cobHYtDkG3N1JiDbHzmELvqsNv03RaLAqebeOQMaV2B-7BSxSbzX1wzwOu5CIY2KDELwpQfvCgKYEjdYLUnixN1rLTPszY22nWxqw6oRtcrAnomVNNwEz0ML4hYpyMQLbCz5MCbrvBwP3-lNnR67OH6fQJJgLfPQEVHBsPfvL_k05GoO7nJZA-" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000" alt="Studio Kecil">
                        <div class="absolute top-6 right-6 bg-naomi-white/90 backdrop-blur-md px-5 py-2 rounded-full shadow-sm">
                            <p class="text-[10px] font-black tracking-widest text-charcoal uppercase">45 SQM</p>
                        </div>
                    </div>
                    <h3 class="serif-title text-3xl font-bold text-charcoal mb-4 group-hover:text-primary transition-colors ">Studio Kecil</h3>
                    <p class="text-charcoal/120 leading-relaxed mb-8 font-light">
                        Ruang kontemplatif untuk eksplorasi personal. Menawarkan ketenangan mendalam melalui desain minimalis yang fokus.
                    </p>
                    <div class="flex items-center gap-4 text-primary font-black text-[10px] uppercase tracking-[0.2em]">
                        <span class="flex items-center gap-2"><span class="size-1.5 bg-primary rounded-full"></span> Private Audio System</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

{{-- VISION MISSION --}}
    <section class="py-32 bg-white rounded-t-[4rem]">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-20">
                
                {{-- Vision --}}
                <div class="space-y-6">
                    <p class="text-primary font-black text-[10px] uppercase tracking-[0.4em]">Vision</p>
                    <h4 class="serif-title text-4xl font-bold tracking-tight text-charcoal">Gravitasi Seni</h4>
                    <p class="text-charcoal/70 leading-relaxed font-light">
                        Menjadi pusat seni gerak kontemporer di Yogyakarta yang diakui secara internasional atas kualitas dan integritas artistiknya.
                    </p>
                </div>

                {{-- Mission --}}
                <div class="space-y-6">
                    <p class="text-primary font-black text-[10px] uppercase tracking-[0.4em]">Mission</p>
                    <h4 class="serif-title text-4xl font-bold tracking-tight text-charcoal">Eksplorasi</h4>
                    <p class="text-charcoal/70 leading-relaxed font-light">
                        Menyediakan fasilitas premium yang mendukung kebebasan berekspresi serta membangun ekosistem kolaboratif yang inklusif.
                    </p>
                </div>

                {{-- Core Values --}}
                <div class="space-y-6">
                    <p class="text-primary font-black text-[10px] uppercase tracking-[0.4em]">Core Values</p>
                    <div class="grid grid-cols-1 gap-4">
                        @foreach(['Inspirasi', 'Kualitas', 'Komunitas'] as $value)
                        <div class="flex items-center gap-4 group">
                            <div class="w-8 h-[1px] bg-primary group-hover:w-12 transition-all"></div>
                            <span class="serif-title text-2xl font-light text-charcoal">{{ $value }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </section>

</main>
@endsection