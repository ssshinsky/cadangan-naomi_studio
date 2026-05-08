@extends('layouts.app')

@section('title', 'Detail Kelas - Naomi Studio')

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

            <!-- Header dengan Back Button -->
            <div class="flex justify-between items-start mb-10">
                <div>
                    <h1 class="serif-title text-4xl font-bold text-charcoal">Detail Kelas</h1>
                    <p class="text-gray-500 mt-1">Informasi lengkap kelas yang Anda ikuti</p>
                </div>
                
                <a href="{{ route('profil.riwayat-kelas') }}" 
                       class="text-primary hover:underline text-sm font-medium flex items-center gap-1">
                        ← Kembali
                </a>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

                <!-- Summary -->
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div>
                            <span class="text-xs uppercase tracking-widest text-gray-500 font-medium">ID Kelas</span>
                            <div class="flex items-center gap-3 mt-1">
                                <p class="text-2xl font-bold">#KL-20250419</p>
                                <span class="inline-block px-4 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">
                                    Dikonfirmasi
                                </span>
                            </div>
                        </div>
                        <div>
                            <span class="text-xs uppercase tracking-widest text-gray-500 font-medium">Nama Kelas</span>
                            <p class="font-semibold text-lg">Ladies with Lintang</p>
                        </div>
                        <div>
                            <span class="text-xs uppercase tracking-widest text-gray-500 font-medium">Instruktur</span>
                            <p class="font-semibold text-lg">Lintang Putri</p>
                        </div>
                    </div>

                    <div class="space-y-6 border-t md:border-t-0 md:border-l border-gray-100 pt-6 md:pt-0 md:pl-8">
                        <div>
                            <span class="text-xs uppercase tracking-widest text-gray-500 font-medium">Jadwal</span>
                            <div class="mt-2 space-y-1">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-primary">calendar_today</span>
                                    <span>Sabtu, 19 April 2025</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-primary">schedule</span>
                                    <span>19:00 - 21:00 WIB (2 Jam)</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-primary/5 rounded-2xl p-5">
                            <span class="text-xs uppercase tracking-widest text-primary font-bold">Status Kelas</span>
                            <div class="flex items-center gap-3 mt-3">
                                <span class="material-symbols-outlined text-primary text-3xl">verified_user</span>
                                <span class="text-xl font-bold text-primary">Aktif</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rincian Kelas -->
                <div class="px-8 pb-8">
                    <div class="bg-gray-50 rounded-2xl p-6">
                        <h3 class="serif-title text-2xl font-bold mb-5 border-b pb-3">Rincian Kelas</h3>
                        <div class="space-y-4 text-gray-600">
                            <div class="flex justify-between">
                                <span>Harga Kelas</span>
                                <span class="font-medium">Rp150.000</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Termasuk</span>
                                <span class="font-medium">Materi, Snack & Dokumentasi</span>
                            </div>
                            <div class="pt-4 border-t flex justify-between text-lg font-bold">
                                <span>Total</span>
                                <span class="text-primary">Rp150.000</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Langkah Selanjutnya -->
                <div class="px-8 pb-10">
                    <h3 class="serif-title text-2xl font-bold mb-5 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">info</span>
                        Apa yang harus dilakukan?
                    </h3>
                    <ul class="space-y-4">
                        <li class="flex gap-4">
                            <div class="mt-1 w-6 h-6 bg-primary/10 text-primary rounded-full flex items-center justify-center text-sm font-bold">1</div>
                            <p class="text-sm text-gray-600">Datang 15 menit sebelum kelas dimulai untuk registrasi.</p>
                        </li>
                        <li class="flex gap-4">
                            <div class="mt-1 w-6 h-6 bg-primary/10 text-primary rounded-full flex items-center justify-center text-sm font-bold">2</div>
                            <p class="text-sm text-gray-600">Gunakan pakaian yang nyaman dan bawa sepatu indoor jika diperlukan.</p>
                        </li>
                        <li class="flex gap-4">
                            <div class="mt-1 w-6 h-6 bg-primary/10 text-primary rounded-full flex items-center justify-center text-sm font-bold">3</div>
                            <p class="text-sm text-gray-600">Tunjukkan ID Kelas <strong>#KL-20250419</strong> kepada instruktur.</p>
                        </li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="px-8 py-8 bg-gray-50 border-t flex flex-col sm:flex-row gap-4">
                    <button onclick="showDownloadConfirm()" 
                            class="flex-1 py-4 border border-primary text-primary rounded-2xl font-medium flex items-center justify-center gap-2 hover:bg-primary/5 transition-colors">
                        <span class="material-symbols-outlined">download</span>
                        Download Sertifikat / Invoice
                    </button>
                    <a href="{{ route('profil.riwayat-kelas') }}" 
                       class="flex-1 py-4 bg-primary text-charcoal font-bold rounded-2xl text-center hover:bg-[#b8962d] transition-colors">
                        Kembali ke Riwayat Kelas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pop-up Konfirmasi Download -->
<div id="downloadModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50">
    <div class="bg-white rounded-3xl p-10 max-w-sm w-full mx-4 text-center shadow-2xl">
        <span class="material-symbols-outlined text-6xl text-primary mb-6">download</span>
        <h3 class="text-2xl font-bold mb-3">Download Dokumen?</h3>
        <p class="text-gray-600 mb-8">File sertifikat/invoice akan diunduh dalam format PDF. Apakah Anda yakin?</p>
        
        <div class="flex gap-4">
            <button onclick="hideDownloadModal()" 
                    class="flex-1 py-4 border border-gray-300 rounded-2xl font-medium hover:bg-gray-50">
                Batal
            </button>
            <button onclick="downloadInvoice()" 
                    class="flex-1 py-4 bg-primary text-charcoal font-bold rounded-2xl hover:bg-[#b8962d]">
                Ya, Download
            </button>
        </div>
    </div>
</div>

<!-- Pop-up Sukses Download -->
<div id="successModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50">
    <div class="bg-white rounded-3xl p-10 max-w-sm w-full mx-4 text-center shadow-2xl">
        <span class="material-symbols-outlined text-6xl text-green-500 mb-6">check_circle</span>
        <h3 class="text-2xl font-bold text-green-600 mb-3">Berhasil!</h3>
        <p class="text-gray-600 mb-6">✅ Dokumen berhasil diunduh!<br><span class="font-medium">(File: KL-20250419.pdf)</span></p>
        
        <button onclick="closeSuccessModal()" 
                class="w-full py-4 bg-primary text-charcoal font-bold rounded-2xl hover:bg-[#b8962d] transition-colors">
            Tutup
        </button>
    </div>
</div>

<script>
function showDownloadConfirm() {
    document.getElementById('downloadModal').classList.remove('hidden');
    document.getElementById('downloadModal').classList.add('flex');
}

function hideDownloadModal() {
    document.getElementById('downloadModal').classList.add('hidden');
    document.getElementById('downloadModal').classList.remove('flex');
}

function downloadInvoice() {
    hideDownloadModal();
    
    setTimeout(() => {
        document.getElementById('successModal').classList.remove('hidden');
        document.getElementById('successModal').classList.add('flex');
    }, 400);
}

function closeSuccessModal() {
    document.getElementById('successModal').classList.add('hidden');
    document.getElementById('successModal').classList.remove('flex');
}
</script>
@endsection