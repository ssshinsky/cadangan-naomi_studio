@extends('layouts.app')

@section('title', 'Menunggu Konfirmasi - Naomi Studio')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-20">

    <!-- Main Card -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

        <!-- Header Icon -->
        <div class="flex justify-center pt-12 pb-8">
            <div class="w-28 h-28 bg-amber-100 rounded-full flex items-center justify-center ring-8 ring-amber-50">
                <span class="material-symbols-outlined text-8xl text-amber-500">hourglass_empty</span>
            </div>
        </div>

        <!-- Title -->
        <div class="text-center px-8 pb-10 border-b">
            <h1 class="serif-title text-4xl font-bold text-charcoal mb-3">
                Menunggu Konfirmasi
            </h1>
            <p class="text-xl text-gray-600 max-w-md mx-auto leading-relaxed">
                Terima kasih telah mendaftar kelas <span class="font-semibold text-primary">Ladies with Lintang</span>.
            </p>
        </div>

        <!-- Status -->
        <div class="px-8 py-10 text-center">
            <div class="inline-flex items-center gap-3 bg-amber-50 text-amber-700 px-8 py-4 rounded-2xl mb-10">
                <span class="material-symbols-outlined">hourglass_empty</span>
                <span class="font-medium">Status: Menunggu Konfirmasi Admin</span>
            </div>

            <p class="text-gray-600 leading-relaxed max-w-md mx-auto">
                Admin kami sedang memverifikasi bukti pembayaran Anda.<br>
            </p>
        </div>

        <!-- Detail Pemesanan -->
        <div class="px-8 pb-10 border-t pt-10">
            <p class="text-xs uppercase font-bold text-gray-500 mb-6">DETAIL KELAS</p>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                <div>
                    <p class="text-xs uppercase tracking-widest text-gray-500">Kelas</p>
                    <p class="font-semibold text-lg mt-1">Ladies with Lintang</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-widest text-gray-500">Jadwal</p>
                    <p class="font-semibold text-lg mt-1">19 April 2025 • 19.00 WIB</p>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="border-t px-8 py-10 flex flex-col sm:flex-row gap-4">
            <a href="{{ route('profil.riwayat-booking') }}" 
               class="flex-1 bg-primary hover:bg-[#b8962d] text-charcoal py-5 rounded-2xl font-bold flex items-center justify-center gap-3 transition-all active:scale-[0.98]">
                <span class="material-symbols-outlined">history</span>
                Lihat Riwayat Kelas
            </a>
            
            <a href="/" 
               class="flex-1 border-2 border-gray-300 hover:bg-gray-50 py-5 rounded-2xl font-bold flex items-center justify-center gap-3 transition-all">
                <span class="material-symbols-outlined">home</span>
                Kembali ke Beranda
            </a>
        </div>

    </div>

</div>
@endsection