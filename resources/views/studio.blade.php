@extends('layouts.app')

@section('title', 'Detail Studio | Naomi Studio')

@section('content')
<main>
    <section class="relative py-20 lg:py-32 overflow-hidden bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="flex-1 space-y-8">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 border border-primary/20 text-primary text-xs font-bold uppercase tracking-widest">
                        <span class="size-2 rounded-full bg-primary animate-pulse"></span>
                        Premium Dance Space
                    </div>
                    <h1 class="text-5xl lg:text-7xl font-black text-charcoal leading-tight">
                        Detail <span class="text-primary italic">Studio</span> Kami
                    </h1>
                    <p class="text-lg text-gray-700 max-w-2xl leading-relaxed">
                        Ruang latihan premium dengan standar kualitas tinggi untuk ekspresi seni tanpa batas. Dirancang khusus untuk kenyamanan dan performa maksimal para artis di Yogyakarta.
                    </p>
                    <div class="flex items-center gap-6">
                        <a href="#studio-list" class="bg-charcoal text-white px-10 py-4 rounded-xl font-bold flex items-center gap-3 group hover:bg-charcoal/90 transition-all">
                            Eksplorasi Fasilitas
                            <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_downward</span>
                        </a>
                    </div>
                </div>
                <div class="flex-1 w-full relative">
                    <div class="aspect-[4/3] rounded-3xl overflow-hidden shadow-2xl border-8 border-white rotate-2">
                        <div class="w-full h-full bg-cover bg-center" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuC60v8ynFPTN5KKXAlT-sm7EtQMlIQjXU3yDcaIW7m-jOlsJG8w74q7NUk513C63pcL7ii7fBwb78Xua0UkzM-X0otF-PGjWZw86csNRYWAb1T0bAdhhtAFUowoYUy9hcSulNVLeP5Q0rN25HpJKWEJdAtjGEK2mhn2GjQpTZJDP2Aoxzwn4oMQO1ppNCX9lpJd00M4sATPzXFmNiypEpdKlrH0AP0f5-adYJUo7b8AKaGjNmHQg-o_--kkHKYhaGvqqhW3rx27Lq6k')"></div>
                    </div>
                    <div class="absolute -bottom-10 -left-10 aspect-video w-64 rounded-2xl overflow-hidden shadow-xl border-4 border-white -rotate-6 hidden lg:block">
                        <div class="w-full h-full bg-cover bg-center" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCzXoowEQqzHYVfK_rUu3ye63XN7jCh3tZh1yAyNPRWGnJy4Hlvs_mGXMC8KANw_vZq8wJo6UFn_NSBoMv2P7H-75iThS6E43huA1jUde7mBVSGtyGqIxA78S2lP0XSyurgLUntAh1_27H0MN0rbniPacwBlJV1jJ9QDWMrqvtggkf550bhopeaeMf0uJXp6B84Ta8SztGi_1HonGuEy7hxxNMJ5r5NJKzQdsiaWtaQBsNG11hfaGlzVqW-ztdeAzz5PTUbfIeafNYB')"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="absolute top-0 right-0 w-1/3 h-full bg-primary/5 -skew-x-12 transform origin-top translate-x-1/2 -z-0"></div>
    </section>

    <section id="studio-list" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="flex flex-col lg:flex-row gap-16 items-center">
                <div class="w-full lg:w-3/5 grid grid-cols-2 gap-4">
                    <div class="col-span-2 aspect-video rounded-2xl overflow-hidden shadow-md">
                        <div class="w-full h-full bg-cover bg-center hover:scale-105 transition-transform duration-700" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDtpNUXrmH51e-6bkTiQL1XPcP56Rn43bvP9gXaetJrKKOKlrGpOZqMpj1aypjwLF3M7e0RVAtfvBhF4wCUZrbySmTWVPwg8_l_oXwBJ1ZDrcbSnv6GvD3Wvk4o-CWm-WRZEDR_gBA0WfVGP_bxNMZy4muhJM5r4_k6ENrBbUain08u1e0yS7ZZO86Xc9ot7DcP0gfoUmfgaZdSJtWuf5yu7E3tOdHDLVMrWr237de5_sYEUIannjPDwZaaOaX75ecaA9fxcSPsjrtA')"></div>
                    </div>
                    <div class="aspect-square rounded-2xl overflow-hidden shadow-md">
                        <div class="w-full h-full bg-cover bg-center hover:scale-105 transition-transform duration-700" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBluXCVQTArQUZHaVaPYWCMVvWCYpFqb2g0PzvOprsHaA7MoDL3zUZguNVP48pK4FVyDk25p2zYBFbDxMNADHkkRJsMlJuviwu6fFIMiaPYS4aY3Fe0fMSbVjlGIHmJ32FfSDsKMek-yJ_2C6f-ImzMwNYxpF3NHQX8VV543-QhswFglaeJeaLARnMKzwdQgLZbBzVUUmTrOGKuiyh_bVfBh3AD9Jj5DgsSXAIxw3VjO5TXzopMwvn5cCWqLKfkjEpPeuQecDJ3_K2v')"></div>
                    </div>
                    <div class="aspect-square rounded-2xl overflow-hidden shadow-md">
                        <div class="w-full h-full bg-cover bg-center hover:scale-105 transition-transform duration-700" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDAqtlVzW6YHoESWlCzse7WNj0gCBVqb3anVJI-3hOYzVQ1iVzhvypqIDN8cQpzWfFVvoWg1Laeaz3uC1nlrM6NlT-jkzyk9UvD74dv3-mSdcn1qU-GdLtq0DkHM5AZAibC3W_TUD-7DttMTSQKU6_S0JJ8jWCUv66Id5SH7sPhs6_-QL8JRFuGi5d0V5HiBc9rSOBuuwEpc1sIIH9g7WTOXys0yFHtH6C_0wnNIq38t4hJtpHBY94BWai4Uvd2MIli2PiJiMa6hR4N')"></div>
                    </div>
                </div>

                <div class="w-full lg:w-2/5 space-y-8">
                    <div>
                        <span class="text-primary font-bold uppercase tracking-widest text-xs mb-3 block">Pilihan Utama</span>
                        <h2 class="text-4xl font-bold text-charcoal">Studio Besar</h2>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-6 border-y border-gray-200 py-8">
                        <div>
                            <span class="text-gray-400 text-xs font-bold uppercase tracking-tighter">Kapasitas</span>
                            <p class="text-charcoal font-bold text-xl">20+ Orang</p>
                        </div>
                        <div>
                            <span class="text-gray-400 text-xs font-bold uppercase tracking-tighter">Harga Sewa</span>
                            <p class="text-primary font-bold text-xl">Rp60.000 <span class="text-gray-400 text-sm font-normal">/ Jam</span></p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <p class="font-bold text-charcoal flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">verified</span> Fasilitas Eksklusif
                        </p>
                        <ul class="grid grid-cols-2 gap-y-4">
                            <li class="flex items-center gap-3 text-gray-600 text-sm">
                                <span class="material-symbols-outlined text-primary text-xl">speaker</span> JBL Sound
                            </li>
                            <li class="flex items-center gap-3 text-gray-600 text-sm">
                                <span class="material-symbols-outlined text-primary text-xl">rectangle</span> Full Mirror
                            </li>
                            <li class="flex items-center gap-3 text-gray-600 text-sm">
                                <span class="material-symbols-outlined text-primary text-xl">ac_unit</span> AC Central
                            </li>
                            <li class="flex items-center gap-3 text-gray-600 text-sm">
                                <span class="material-symbols-outlined text-primary text-xl">layers</span> Parquet Floor
                            </li>
                        </ul>
                    </div>

                   <div class="pt-6 flex flex-col sm:flex-row gap-4">
                        <a href="#" class="flex-1 bg-primary text-charcoal py-4 rounded-xl font-bold flex items-center justify-center gap-2 hover:shadow-xl hover:shadow-primary/30 transition-all text-sm">
                            <span class="material-symbols-outlined text-xl">calendar_month</span>
                            Booking
                        </a>
                        <a href="#" class="flex-1 border-2 border-charcoal text-charcoal py-4 rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-charcoal hover:text-white transition-all text-sm">
                            <span class="material-symbols-outlined text-xl">info</span>
                            Detail Studio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="flex flex-col lg:flex-row-reverse gap-16 items-center">
                <div class="w-full lg:w-3/5 grid grid-cols-2 gap-4">
                    <div class="col-span-2 aspect-video rounded-2xl overflow-hidden shadow-md">
                        <div class="w-full h-full bg-cover bg-center hover:scale-105 transition-transform duration-700" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBcpG__CCH4v1u4Ph3gRQYVTxnb8g8qHTYvIOPrDD395giC6OedzEV7kVF7tBzNIuICnLUmt8LDo15qK8hSV3L7L_rORgxoKAc8Jg-u7MX7rbcat9lsnRgV-oB9tTF9jJ4qCxTlI56DEpXUGjFaF0v2VBqi0ekqqitLRfgdcg40G5EyuOl4nPobludqdBjJiX5fQtfyTnBSBFKmab0wxfKDOKnMowe4aH__dpapgKWGaoNWTpr1egtFMp9Fnjkt1Q7jewjfoQI8E-ih')"></div>
                    </div>
                    <div class="aspect-square rounded-2xl overflow-hidden shadow-md">
                        <div class="w-full h-full bg-cover bg-center hover:scale-105 transition-transform duration-700" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCoXDoYtdNX1DGIlAKWp_0WniUkCSaNxVSbbAr7Yel70SlhUx_VmJQao7j0aB5O8zOGZl5sCBE3_STx1ZSnkVZ1aisnnoxCj9-TVZOmVZCy53_JB9Kyuz5c6gF_CAsl6rAKDic0gioeviyTdEjqQ2le_NBUKJWNbrtIyRaL0qbF1cTSyO79v1lyd7N7zaICfC_ZH2FQuZDm_r3p1WlWz2UfG8Aq51P9-dxRaOq5W84wpxvbGdiFFyCBbJJHBqYNvcWkQ-2KLa7KbuRG')"></div>
                    </div>
                    <div class="aspect-square rounded-2xl overflow-hidden shadow-md">
                        <div class="w-full h-full bg-cover bg-center hover:scale-105 transition-transform duration-700" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDvARqxM1OgaAtUIdcRzX4xSSuZaoV-M9kUujHGQ_hwcn9Z1ux-Ek6K4B1vyHwGgcKtkD4Iot9Ow7qxfKfZ07XQ49dxHuK020ikPidX2Doti0gubGixNjcebGr8MJC1uBsRW9Mk9aK21AWOmmpy3GRacASV6lgWMl1bb9j3l6svDFK58ROQNU5BgTXQJAy8NLznz8ibisG4OzT7rD7CNj9GOX4S-m-Fft3Q3dyJBKUEZzOI5j3H-HuALr2Ct-ZUGOYLu5H47UG5Wm8p')"></div>
                    </div>
                </div>

                <div class="w-full lg:w-2/5 space-y-8">
                    <div>
                        <span class="text-primary font-bold uppercase tracking-widest text-xs mb-3 block">Private Session</span>
                        <h2 class="text-4xl font-bold text-charcoal">Studio Kecil</h2>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-6 border-y border-gray-200 py-8">
                        <div>
                            <span class="text-gray-400 text-xs font-bold uppercase tracking-tighter">Kapasitas</span>
                            <p class="text-charcoal font-bold text-xl">5-8 Orang</p>
                        </div>
                        <div>
                            <span class="text-gray-400 text-xs font-bold uppercase tracking-tighter">Harga Sewa</span>
                            <p class="text-primary font-bold text-xl">Rp40.000 <span class="text-gray-400 text-sm font-normal">/ Jam</span></p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <p class="font-bold text-charcoal flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">verified</span> Fasilitas Nyaman
                        </p>
                        <ul class="grid grid-cols-2 gap-y-4">
                            <li class="flex items-center gap-3 text-gray-600 text-sm">
                                <span class="material-symbols-outlined text-primary text-xl">bluetooth</span> Bluetooth
                            </li>
                            <li class="flex items-center gap-3 text-gray-600 text-sm">
                                <span class="material-symbols-outlined text-primary text-xl">rectangle</span> Full Mirror
                            </li>
                            <li class="flex items-center gap-3 text-gray-600 text-sm">
                                <span class="material-symbols-outlined text-primary text-xl">ac_unit</span> AC Sejuk
                            </li>
                            <li class="flex items-center gap-3 text-gray-600 text-sm">
                                <span class="material-symbols-outlined text-primary text-xl">photo_camera</span> Content Friendly
                            </li>
                        </ul>
                    </div>

                   <<div class="pt-6 flex flex-col sm:flex-row gap-4">
                        <a href="#" class="flex-1 bg-primary text-charcoal py-4 rounded-xl font-bold flex items-center justify-center gap-2 hover:shadow-xl hover:shadow-primary/30 transition-all text-sm">
                            <span class="material-symbols-outlined text-xl">calendar_month</span>
                            Booking
                        </a>
                        <a href="#" class="flex-1 border-2 border-charcoal text-charcoal py-4 rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-charcoal hover:text-white transition-all text-sm">
                            <span class="material-symbols-outlined text-xl">info</span>
                            Detail Studio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-charcoal text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 relative z-10">
            <div class="text-center mb-20">
                <h2 class="text-4xl font-bold mb-4">Fasilitas <span class="text-primary">Umum</span></h2>
                <div class="w-20 h-1 bg-primary mx-auto rounded-full"></div>
            </div>
            
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-12">
                @php
                    $facilities = [
                        ['icon' => 'weekend', 'title' => 'Area Tunggu', 'desc' => 'Lounge estetik & nyaman'],
                        ['icon' => 'local_drink', 'title' => 'Dispenser', 'desc' => 'Air mineral gratis'],
                        ['icon' => 'wc', 'title' => 'Toilet Bersih', 'desc' => 'Selalu terjaga harian'],
                        ['icon' => 'local_parking', 'title' => 'Parkir Luas', 'desc' => 'Aman untuk mobil & motor']
                    ];
                @endphp

                @foreach($facilities as $f)
                <div class="text-center group">
                    <div class="size-16 bg-white/5 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-primary group-hover:rotate-6 transition-all duration-300">
                        <span class="material-symbols-outlined text-3xl text-primary group-hover:text-charcoal">{{ $f['icon'] }}</span>
                    </div>
                    <h4 class="text-lg font-bold mb-1">{{ $f['title'] }}</h4>
                    <p class="text-gray-400 text-xs">{{ $f['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#d4af35_1px,transparent_1px)] [background-size:20px_20px]"></div>
    </section>
</main>
@endsection