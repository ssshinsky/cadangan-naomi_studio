@extends('layouts.app')

@section('title', 'Masuk | Naomi Studio')

@section('content')
<div class="min-h-screen flex bg-white overflow-hidden">

    <!-- LEFT SIDE - Gambar (Locked) -->
    <div class="hidden md:block w-1/2 lg:w-3/5 relative flex-shrink-0 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center h-full" 
             style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCQJg-_hsZAx3lFFdhzIaDDt3CaDf2KGjUXrL46CyP1OmN9l9Dx76ZySGWwf7TE5eaTV-FbsHsLX-TlW4hnLI1oU0YaUNoGOiYYc_n6fVWHpvI5Zr6ZLNh_OZXYqYbmOGi4QEypEHzW7grhJcmRmF5In8lUu9jpmcnZ6yq1HxGmEQ7gAKXc9SXw7L79DXnK_n73gi0lxHbIJm7cIPzf5f8eQqP-JhN3c5OfIgALduod3oLTPJcLfBtqUuJ6geTfTB1TUeLXS_nbMSj6');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#171612]/90 via-[#171612]/40 to-transparent"></div>

        <div class="absolute bottom-0 left-0 right-0 p-16 text-white z-10">
            <div class="max-w-md">
                <h1 class="text-5xl font-extrabold leading-tight mb-6">Ruang Bebas untuk Setiap Kreativitasmu.</h1>
                <p class="text-xl text-white/80 font-light">Sewa studio multifungsi dengan fasilitas premium. Tempat terbaik untuk berlatih, berkarya, dan berkolaborasi di Naomi Studio.</p>
            </div>
        </div>
    </div>

    <!-- RIGHT SIDE - Form dengan Slide -->
    <div class="flex-1 md:w-1/2 lg:w-2/5 bg-white flex flex-col overflow-hidden relative">

        <header class="sticky top-0 bg-white border-b border-gray-100 z-50 px-8 py-6 md:px-12">
            <div class="flex items-center gap-3">
                <img src="{{ asset('storage/images/logo.png') }}" alt="Naomi Studio" class="h-10 w-auto">
                <span class="text-[#171612] text-xl font-bold tracking-tight">Naomi Studio</span>
            </div>
        </header>

        <div id="slider" class="flex transition-transform duration-700 ease-in-out h-full" style="transform: translateX(0%);">

            <!-- LOGIN FORM -->
            <div class="w-full flex-shrink-0 px-8 md:px-12 lg:px-20 py-12 overflow-y-auto">
                <div class="max-w-md mx-auto">
                    <h2 class="text-4xl font-black tracking-tight mb-3">Selamat Datang</h2>
                    <p class="text-[#857d66] mb-10">Silakan masuk untuk melanjutkan latihan Anda.</p>

                    @if(session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl text-sm font-medium flex items-center gap-3">
                        <span class="material-symbols-outlined text-red-500 shrink-0">block</span>
                        {{ session('error') }}
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl text-sm font-medium">
                        {{ $errors->first() }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-[#171612] uppercase tracking-wider mb-2">Email</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-[#857d66]">person</span>
                                    <input name="email" type="text" required autofocus
                                           class="w-full pl-12 pr-4 py-4 rounded-2xl border border-[#e4e3dc] focus:border-primary focus:ring-2 focus:ring-primary outline-none text-lg"
                                           placeholder="Contoh: nama@email.com">
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between mb-2">
                                    <label class="block text-sm font-bold text-[#171612] uppercase tracking-wider">Kata Sandi</label>
                                </div>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-[#857d66]">lock</span>
                                    <input name="password" type="password" required
                                           class="w-full pl-12 pr-4 py-4 rounded-2xl border border-[#e4e3dc] focus:border-primary focus:ring-2 focus:ring-primary outline-none text-lg"
                                           placeholder="••••••••">
                                </div>
                            </div>

                            <button type="submit"
                                    class="w-full bg-primary hover:bg-charcoal text-white py-4 rounded-2xl font-bold text-lg shadow-lg transition-all active:scale-[0.98]">
                                Masuk Ke Akun
                            </button>
                        </div>
                    </form>

                    <p class="text-center mt-8 text-[#857d66]">
                        Belum punya akun? 
                        <a href="#" onclick="goToRegister()" class="text-primary font-bold hover:underline">Daftar di sini</a>
                    </p>
                </div>
            </div>

            <!-- ==================== REGISTER FORM (SUDAH DITAMBAH CENTANG) ==================== -->
            <div class="w-full flex-shrink-0 px-8 md:px-12 lg:px-20 py-12 overflow-y-auto">
                <div class="max-w-md mx-auto">
                    <button onclick="goToLogin()" 
                            class="flex items-center gap-2 text-primary font-medium mb-6 hover:gap-1 transition-all">
                        <span class="material-symbols-outlined">arrow_back</span>
                        Kembali ke Masuk
                    </button>

                    <h2 class="text-4xl font-black tracking-tight mb-3">Buat Akun Baru</h2>
                    <p class="text-[#857d66] mb-10">Mulai perjalanan tari Anda hari ini.</p>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="space-y-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-[#171612] uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                                    <input name="name" type="text" required 
                                           class="w-full px-4 py-3 rounded-xl border border-[#e4e3dc] focus:border-primary focus:ring-2 focus:ring-primary outline-none"
                                           placeholder="Nama lengkap Anda">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-[#171612] uppercase tracking-wider mb-1.5">No. WhatsApp</label>
                                    <input name="whatsapp" type="tel" required 
                                           class="w-full px-4 py-3 rounded-xl border border-[#e4e3dc] focus:border-primary focus:ring-2 focus:ring-primary outline-none"
                                           placeholder="08123456789">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-[#171612] uppercase tracking-wider mb-1.5">Email</label>
                                <input name="email" type="email" required 
                                       class="w-full px-4 py-3 rounded-xl border border-[#e4e3dc] focus:border-primary focus:ring-2 focus:ring-primary outline-none"
                                       placeholder="nama@email.com">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-[#171612] uppercase tracking-wider mb-1.5">Kata Sandi</label>
                                <input name="password" type="password" required 
                                       class="w-full px-4 py-3 rounded-xl border border-[#e4e3dc] focus:border-primary focus:ring-2 focus:ring-primary outline-none"
                                       placeholder="Minimal 8 karakter">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-[#171612] uppercase tracking-wider mb-1.5">Konfirmasi Kata Sandi</label>
                                <input name="password_confirmation" type="password" required 
                                       class="w-full px-4 py-3 rounded-xl border border-[#e4e3dc] focus:border-primary focus:ring-2 focus:ring-primary outline-none"
                                       placeholder="Ulangi kata sandi">
                            </div>

                                        <!-- CHECKBOX KUNING EMAS -->
                            <div class="flex items-start gap-3 py-4 border-t border-gray-100">
                                <input type="checkbox" id="terms" name="terms" 
                                    class="mt-1 w-5 h-5 accent-primary cursor-pointer rounded border-[#e4e3dc]"
                                    required>
                                <label for="terms" class="text-sm text-[#857d66] leading-relaxed cursor-pointer select-none">
                                    Saya menyetujui 
                                    <a href="#" class="text-primary font-bold hover:underline">Syarat & Ketentuan</a> 
                                    serta 
                                    <a href="#" class="text-primary font-bold hover:underline">Kebijakan Privasi</a> 
                                    Naomi Studio.
                                </label>
                            </div>

                            <button type="submit"
                                    class="w-full bg-primary hover:bg-charcoal text-white py-4 rounded-xl font-bold text-lg shadow-lg transition-all active:scale-[0.98]">
                                Daftar Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
function goToRegister() {
    document.getElementById('slider').style.transform = 'translateX(-100%)';
}

function goToLogin() {
    document.getElementById('slider').style.transform = 'translateX(0%)';
}
</script>
@endsection