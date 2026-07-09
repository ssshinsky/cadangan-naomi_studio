@extends('layouts.app')

@section('title', 'Alur & Panduan | Naomi Studio')

@section('content')
<main class="bg-naomi-bg min-h-screen">

    <div class="max-w-7xl mx-auto px-6 py-20 lg:py-28">

        {{-- HEADER SECTION --}}
        <div class="mb-24">
            <span class="uppercase tracking-[0.4em] text-[10px] text-primary font-black">Editorial Guide</span>
            <h1 class="serif-title text-5xl md:text-8xl font-bold leading-[0.9] tracking-tighter mt-8 text-charcoal">
                The <span class="italic text-primary">Seamless</span> Journey to Your Stage.
            </h1>
            <div class="w-20 h-[1px] bg-charcoal/20 my-12"></div>
            <p class="max-w-xl text-xl leading-relaxed text-charcoal/120 font-light">
                Kami merancang setiap langkah untuk memastikan kenyamanan Anda dalam berkarya. 
                Ikuti panduan mendetail kami untuk mulai berekspresi di Naomi Studio.
            </p>
        </div>

        {{-- GUIDE GRID --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">

            {{-- 01. SEWA STUDIO --}}
            <div class="bg-naomi-white px-8 md:px-14 py-16 rounded-[3rem] border border-charcoal/5 shadow-sm">
                <div class="flex items-center gap-6 mb-16">
                    <span class="serif-title text-7xl text-primary/10 font-bold">01</span>
                    <h2 class="serif-title text-4xl font-bold text-charcoal tracking-tight">
                        Alur Sewa Studio
                    </h2>
                </div>

                <div class="space-y-12 relative pl-8">
                    {{-- Vertical Timeline Line --}}
                    <div class="absolute left-[1.45rem] top-2 bottom-2 w-[1px] bg-charcoal/30"></div>

                    @php
                        $sewaSteps = [
                            ['01','Login ke akun Naomi Studio','Masuk ke dashboard personal Anda untuk memulai proses reservasi.'],
                            ['02','Pilih studio yang diinginkan','Tersedia pilihan Studio Besar atau Studio Kecil sesuai kebutuhan.'],
                            ['03','Tentukan tanggal dan jam','Pilih slot waktu yang tersedia melalui sistem kalender kami.'],
                            ['04','Isi formulir pemesanan','Lengkapi detail pemesanan dengan informasi yang akurat.'],
                            ['05','Lakukan pembayaran','Pilih metode Down Payment (DP) 50% atau pelunasan langsung.'],
                            ['06','Unggah bukti & Submit','Unggah tangkapan layar bukti transfer Anda secara digital.'],
                            ['07','Cek status di Profil','Pantau status konfirmasi di bagian Riwayat Pemesanan.'],
                            ['08','Pelunasan sisa pembayaran','Sisa pembayaran dilunasi di tempat saat tiba di studio.'],
                            ['09','Datang & Taati aturan','Datang tepat waktu dan patuhi seluruh peraturan studio.']
                        ];
                    @endphp

                    @foreach($sewaSteps as $step)
                    <div class="flex gap-8 relative group">
                        <div class="w-12 h-12 rounded-full bg-naomi-bg border border-charcoal/5 text-primary flex items-center justify-center font-black text-xs shrink-0 z-10 group-hover:bg-primary group-hover:text-naomi-white transition-colors duration-500">
                            {{ $step[0] }}
                        </div>
                        <div>
                            <h3 class="serif-title text-xl font-bold text-charcoal mb-2">{{ $step[1] }}</h3>
                            <p class="text-charcoal/50 text-sm leading-relaxed font-light">{{ $step[2] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-20">
                    <img src="{{ asset('storage/aset aku/s kecil.PNG') }}" 
                        class="w-full h-80 object-cover rounded-[2.5rem] shadow-2xl transition-transform duration-700" 
                        alt="Studio Interior">
                </div>
            </div>

            {{-- 02. OPEN CLASS --}}
            <div class="bg-naomi-white px-8 md:px-14 py-16 rounded-[3rem] border border-charcoal/5 shadow-sm">
                <div class="flex items-center gap-6 mb-16">
                    <span class="serif-title text-7xl text-primary/10 font-bold">02</span>
                    <h2 class="serif-title text-4xl font-bold text-charcoal tracking-tight">
                        Alur Daftar Open Class
                    </h2>
                </div>

                <div class="space-y-12 relative pl-8">
                    {{-- Vertical Timeline Line --}}
                    <div class="absolute left-[1.45rem] top-2 bottom-2 w-[1px] bg-charcoal/30"></div>

                    @php
                        $classSteps = [
                            ['01','Buka Halaman Open Class','Lihat daftar kelas dan jadwal mingguan tanpa perlu login.'],
                            ['02','Pilih Kelas & Mentor','Cari kelas yang sesuai minat dan pelajari detail informasinya.'],
                            ['03','Klik Daftar via WhatsApp','Gunakan tombol pendaftaran untuk terhubung dengan mentor.'],
                            ['04','Konfirmasi Pendaftaran','Sampaikan ketertarikan Anda melalui pesan otomatis WhatsApp.'],
                            ['05','Selesaikan Pembayaran','Lakukan transaksi langsung dengan mentor sesuai instruksi.'],
                            ['06','Datang & Bersenang-senang','Hadir di Naomi Studio sesuai jadwal yang telah disepakati.']
                        ];
                    @endphp

                    @foreach($classSteps as $step)
                    <div class="flex gap-8 relative group">
                        <div class="w-12 h-12 rounded-full bg-naomi-bg border border-charcoal/5 text-primary flex items-center justify-center font-black text-xs shrink-0 z-10 group-hover:bg-primary group-hover:text-naomi-white transition-colors duration-500">
                            {{ $step[0] }}
                        </div>
                        <div>
                            <h3 class="serif-title text-xl font-bold text-charcoal mb-2">{{ $step[1] }}</h3>
                            <p class="text-charcoal/50 text-sm leading-relaxed font-light">{{ $step[2] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-20">
                    <img src="{{ asset('storage/aset aku/open class.JPEG') }}"  
                         class="w-full h-80 object-cover rounded-[2.5rem] shadow-2xl transition-transform duration-700" alt="Dancer Motion">
                </div>
            </div>
        </div>

        {{-- CTA SECTION --}}
        <div class="mt-32 bg-naomi-white rounded-[4rem] p-12 md:p-24 text-center border border-charcoal/5">
            <h2 class="serif-title text-5xl md:text-6xl font-bold mb-8 text-charcoal tracking-tight">
                Siap Berekspresi?
            </h2>
            <p class="text-charcoal/50 text-xl max-w-2xl mx-auto mb-16 font-light">
                Pilih ruang Anda sekarang atau temukan komunitas baru melalui kelas-kelas inspiratif kami.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-6">
                <a href="{{ route('studios.index') }}" 
                   class="bg-primary text-naomi-white px-12 py-5 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-primary/20 hover:bg-charcoal transition-all duration-500">
                    Sewa Studio
                </a>
                <a href="{{ route('open-class.index') }}" 
                   class="border-2 border-primary text-primary px-12 py-5 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-primary hover:text-naomi-white transition-all duration-500">
                    Daftar Open Class
                </a>
            </div>
        </div>

    </div>
</main>
@endsection