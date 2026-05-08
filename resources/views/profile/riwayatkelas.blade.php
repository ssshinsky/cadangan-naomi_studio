@extends('layouts.app')

@section('title', 'Riwayat Kelas - Naomi Studio')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-20">

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <!-- Sidebar -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 bg-primary/10 rounded-2xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary">person</span>
                    </div>
                    <div>
                        <p class="font-medium">Gabrielle Shins</p>
                        <p class="text-xs text-gray-500">Member sejak Januari 2023</p>
                    </div>
                </div>

                <nav class="space-y-1">
                    <a href="{{ route('profil') }}" class="flex items-center gap-3 px-5 py-4 hover:bg-gray-50 rounded-2xl text-gray-700 transition-colors">
                        <span class="material-symbols-outlined">person</span>
                        Profil Saya
                    </a>
                    <a href="{{ route('profil.riwayat-booking') }}" class="flex items-center gap-3 px-5 py-4 hover:bg-gray-50 rounded-2xl text-gray-700 transition-colors">
                        <span class="material-symbols-outlined">history</span>
                        Riwayat Booking
                    </a>
                    <a href="{{ route('profil.riwayat-kelas') }}" class="flex items-center gap-3 px-5 py-4 bg-primary text-charcoal rounded-2xl font-medium">
                        <span class="material-symbols-outlined">school</span>
                        Riwayat Kelas
                    </a>
                    <a href="#" class="flex items-center gap-3 px-5 py-4 text-red-600 hover:bg-red-50 rounded-2xl transition-colors mt-8">
                        <span class="material-symbols-outlined">logout</span>
                        Keluar
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-9">
            <h1 class="serif-title text-4xl font-bold mb-2">Riwayat Kelas</h1>
            <p class="text-gray-500 mb-10">Pantau semua kelas yang pernah kamu ikuti di Naomi Studio.</p>

            <!-- Tabs -->
            <div class="flex border-b mb-10">
                <button onclick="switchTab(0)" id="tab0" 
                        class="tab-button px-8 py-4 border-b-2 border-primary text-primary font-medium">Kelas Aktif</button>
                <button onclick="switchTab(1)" id="tab1" 
                        class="tab-button px-8 py-4 text-gray-500 hover:text-gray-700 transition-colors">Riwayat Selesai</button>
            </div>

            <!-- Tab 1: Kelas Aktif -->
            <div id="content0" class="tab-content space-y-8">

                <!-- Card Kelas Aktif -->
                <div class="group bg-white rounded-3xl overflow-hidden border border-gray-100 hover:shadow-xl transition-all flex flex-col md:flex-row">
                    <div class="md:w-80 h-56 relative overflow-hidden">
                        <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuDzDg3iySBYLaOt2hf16M3-pT4FkxwGQt3VGcd6oQc9ueO1y9ZE3CHW7UtgIfvHq8nJrx1I4Ib2-8efyMDTfVDyfHGr0wakoeJHo_HR_pSp4-nZ0EYCEVhvCPGVNv50PMxKF3Q5AYpTnT4ecSnyrP_mKypgBUsQa7QRCS7O2Adn40wExuw8nz59XUSIZOvDCfG-4ICKndhbuslTgDwyHs-B1zoAIczvcHc9I8f5mFjyQbIvH6jSHyBMqtDPJmEUarHYlOPx1vOuHO1Z" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Ladies with Lintang">
                        <div class="absolute top-4 left-4 bg-green-100 text-green-700 text-xs font-bold px-4 py-1 rounded-full">
                            Dikonfirmasi
                        </div>
                    </div>
                    <div class="flex-1 p-8 flex flex-col">
                        <h3 class="serif-title text-2xl font-bold mb-2">Ladies with Lintang</h3>
                        <div class="flex items-center gap-2 text-sm text-gray-500 mb-8">
                            <span class="material-symbols-outlined">calendar_today</span>
                            <span>Sabtu, 19 April 2025</span>
                            <span class="mx-2">•</span>
                            <span>19:00 - 21:00 WIB</span>
                        </div>
                        <div class="mt-auto flex items-center justify-between">
                            <div>
                                <p class="text-xs text-gray-400">ID Kelas</p>
                                <p class="font-mono font-medium">#KL-20250419</p>
                            </div>
                            <a href="#" 
                               class="px-8 py-3.5 bg-primary text-charcoal font-bold rounded-2xl hover:bg-[#b8962d] transition-all">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Tab 2: Riwayat Selesai -->
            <div id="content1" class="tab-content hidden space-y-8">

                <div class="group bg-white rounded-3xl overflow-hidden border border-gray-100 hover:shadow-xl transition-all flex flex-col md:flex-row">
                    <div class="md:w-80 h-56 relative overflow-hidden">
                        <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuDzDg3iySBYLaOt2hf16M3-pT4FkxwGQt3VGcd6oQc9ueO1y9ZE3CHW7UtgIfvHq8nJrx1I4Ib2-8efyMDTfVDyfHGr0wakoeJHo_HR_pSp4-nZ0EYCEVhvCPGVNv50PMxKF3Q5AYpTnT4ecSnyrP_mKypgBUsQa7QRCS7O2Adn40wExuw8nz59XUSIZOvDCfG-4ICKndhbuslTgDwyHs-B1zoAIczvcHc9I8f5mFjyQbIvH6jSHyBMqtDPJmEUarHYlOPx1vOuHO1Z" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Ladies with Lintang">
                        <div class="absolute top-4 left-4 bg-gray-100 text-gray-600 text-xs font-bold px-4 py-1 rounded-full">
                            Selesai
                        </div>
                    </div>
                    <div class="flex-1 p-8 flex flex-col">
                        <h3 class="serif-title text-2xl font-bold mb-2">Ladies with Lintang</h3>
                        <div class="flex items-center gap-2 text-sm text-gray-500 mb-8">
                            <span class="material-symbols-outlined">calendar_today</span>
                            <span>Sabtu, 12 April 2025</span>
                            <span class="mx-2">•</span>
                            <span>19:00 - 21:00 WIB</span>
                        </div>
                        <div class="mt-auto flex items-center justify-between">
                            <div>
                                <p class="text-xs text-gray-400">ID Kelas</p>
                                <p class="font-mono font-medium">#KL-20250412</p>
                            </div>
                            <a href="#" 
                               class="px-8 py-3.5 border border-gray-300 hover:bg-gray-50 font-medium rounded-2xl transition-all">
                                Lihat Sertifikat
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- CTA -->
            <div class="mt-16 bg-primary/5 rounded-3xl p-12 text-center">
                <div class="mx-auto w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined text-primary text-5xl">school</span>
                </div>
                <h2 class="serif-title text-3xl font-bold mb-3">Ingin ikut kelas lagi?</h2>
                <p class="text-gray-600 max-w-md mx-auto">Temukan kelas open class menarik lainnya di Naomi Studio.</p>
                <a href="{{ route('open-class.index') }}" 
                   class="mt-8 inline-flex items-center gap-3 bg-primary text-charcoal px-8 py-4 rounded-2xl font-bold hover:bg-[#b8962d] transition-all">
                    Lihat Semua Kelas
                    <span class="material-symbols-outlined">arrow_forward</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function switchTab(tab) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    document.getElementById('content' + tab).classList.remove('hidden');

    document.querySelectorAll('.tab-button').forEach(el => {
        el.classList.remove('border-b-2', 'border-primary', 'text-primary');
    });
    document.getElementById('tab' + tab).classList.add('border-b-2', 'border-primary', 'text-primary');
}
</script>
@endsection