@extends('layouts.app')

@section('title', 'Profil Saya - Naomi Studio')

@section('content')
<main class="bg-naomi-bg min-h-screen pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12 sm:py-20">

        <div class="flex flex-col lg:flex-row gap-10">

            {{-- SIDEBAR --}}
            <div class="w-full lg:w-64 lg:shrink-0 lg:max-w-[256px]">
                <div class="bg-naomi-white rounded-[2.5rem] p-8 shadow-sm border border-charcoal/10">
                    <div class="flex items-center gap-4 mb-10 pb-6 border-b border-naomi-bg">
                        <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-primary/20">
                            @if($customer->avatar)
                                <img src="{{ asset('storage/' . $customer->avatar) }}" class="w-full h-full object-cover" alt="Avatar">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&background=2D2A28&color=fff&bold=true"
                                     class="w-full h-full object-cover" alt="Avatar">
                            @endif
                        </div>
                        <div>
                            <p class="font-black text-charcoal leading-tight">{{ $customer->name }}</p>
                            <p class="text-[10px] text-charcoal/40 uppercase tracking-widest mt-1 font-bold">Member</p>
                        </div>
                    </div>

                    <nav class="space-y-2">
                        <a href="{{ route('profil') }}"
                           class="flex items-center gap-3 px-4 py-4 bg-primary text-naomi-white rounded-2xl font-black text-[11px] uppercase tracking-wider shadow-lg shadow-primary/20 whitespace-nowrap">
                            <span class="material-symbols-outlined text-lg shrink-0">person</span>
                            Profil Saya
                        </a>
                        <a href="{{ route('profil.riwayat-booking') }}"
                           class="flex items-center gap-3 px-4 py-4 hover:bg-naomi-bg rounded-2xl text-charcoal/60 font-black text-[11px] uppercase tracking-wider transition-all whitespace-nowrap">
                            <span class="material-symbols-outlined text-lg shrink-0">history</span>
                            Riwayat Booking
                        </a>
                        <div class="pt-6 border-t border-naomi-bg mt-4">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-4 text-red-500/60 hover:text-red-500 hover:bg-red-50 rounded-2xl font-black text-[11px] uppercase tracking-wider transition-all">
                                    <span class="material-symbols-outlined text-lg shrink-0">logout</span>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </nav>
                </div>
            </div>

            {{-- KONTEN KANAN --}}
            <div class="flex-1 space-y-8">

                {{-- Header Card --}}
                <div class="bg-naomi-white rounded-[2rem] md:rounded-[3rem] p-6 sm:p-8 md:p-10 flex flex-col md:flex-row gap-6 md:gap-10 items-center md:items-start shadow-sm border border-charcoal/10 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-full -z-0"></div>

                    <div class="relative z-10">
                        <div class="w-32 h-32 rounded-[2.5rem] overflow-hidden border-4 border-naomi-bg shadow-xl rotate-3">
                            @if($customer->avatar)
                                <img src="{{ asset('storage/' . $customer->avatar) }}"
                                     class="w-full h-full object-cover" alt="{{ $customer->name }}">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&background=2D2A28&color=fff&bold=true&size=256"
                                     class="w-full h-full object-cover" alt="{{ $customer->name }}">
                            @endif
                        </div>
                    </div>

                    <div class="flex-1 z-10 w-full">
                        <div class="flex flex-col sm:flex-row justify-between items-center sm:items-start gap-4">
                            <div class="text-center sm:text-left">
                                <h1 class="serif-title text-3xl sm:text-4xl md:text-5xl font-bold text-charcoal tracking-tighter">{{ $customer->name }}</h1>
                                <p class="text-charcoal/50 mt-2 font-medium">
                                    Bergabung sejak {{ ($customer->joined_at ?? $customer->created_at)->format('F Y') }}
                                </p>
                            </div>
                            <div class="bg-naomi-bg px-8 py-4 rounded-[2rem] border border-charcoal/5 text-center">
                                <div class="text-4xl font-black text-primary tracking-tighter">{{ $totalBookings }}</div>
                                <p class="text-[9px] uppercase tracking-[0.2em] font-black text-charcoal/40 mt-1">Total Booking</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Info Pribadi --}}
                <div class="bg-naomi-white rounded-[2rem] md:rounded-[3rem] p-6 sm:p-8 md:p-10 shadow-sm border border-charcoal/10">
                    <div class="flex flex-wrap justify-between items-center gap-3 mb-8 sm:mb-12">
                        <!-- Judul di sebelah kiri -->
                        <h2 class="serif-title text-2xl md:text-3xl font-bold text-charcoal">
                            Informasi Pribadi
                        </h2>

                        <!-- Grup Tombol di pojok kanan, tidak melebar -->
                        <div class="flex items-center gap-2 shrink-0">
                            <button 
                                onclick="document.getElementById('passwordModal').classList.remove('hidden'); document.getElementById('passwordModal').classList.add('flex')"
                                class="whitespace-nowrap px-4 py-2.5 border-2 border-charcoal/5 rounded-xl text-[10px] font-black uppercase tracking-widest text-charcoal/60 hover:bg-naomi-bg transition-colors"
                            >
                                Ubah Password
                            </button>
                            
                            <a 
                                href="{{ route('profil.edit') }}"
                                class="whitespace-nowrap px-5 py-2.5 bg-charcoal text-naomi-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-primary transition-all shadow-md"
                            >
                                Edit Profil
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-12 gap-x-16">
                        <div>
                            <p class="text-[10px] uppercase font-black text-charcoal/30 tracking-[0.2em] mb-2">Nama Lengkap</p>
                            <p class="font-medium text-charcoal text-lg">{{ $customer->name }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase font-black text-charcoal/30 tracking-[0.2em] mb-2">Nomor WhatsApp</p>
                            <p class="font-medium text-lg {{ $customer->phone ? 'text-charcoal' : 'text-charcoal/30' }}">
                                {{ $customer->phone ?? 'Belum ditambahkan' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase font-black text-charcoal/30 tracking-[0.2em] mb-2">Alamat Email</p>
                            <p class="font-medium text-charcoal text-lg">{{ auth()->user()->email }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase font-black text-charcoal/30 tracking-[0.2em] mb-2">Tanggal Lahir</p>
                            <p class="font-medium text-lg {{ $customer->date_of_birth ? 'text-charcoal' : 'text-charcoal/30' }}">
                                {{ $customer->date_of_birth ? $customer->date_of_birth->format('d F Y') : 'Belum ditambahkan' }}
                            </p>
                        </div>
                        <div class="md:col-span-2 pt-6 border-t border-naomi-bg">
                            <p class="text-[10px] uppercase font-black text-charcoal/30 tracking-[0.2em] mb-2">Alamat Domisili</p>
                            <p class="font-medium text-lg {{ $customer->address ? 'text-charcoal' : 'text-charcoal/30' }}">
                                {{ $customer->address ?? 'Belum ditambahkan' }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
@endsection

{{-- Modal Ubah Password --}}
<div id="passwordModal" class="hidden fixed inset-0 bg-charcoal/80 backdrop-blur-sm items-center justify-center z-50">
    <div class="bg-naomi-white rounded-[2rem] md:rounded-[3rem] p-6 sm:p-10 md:p-12 max-w-md w-full mx-4 shadow-2xl border border-charcoal/10">
        <div class="flex justify-between items-center mb-8">
            <h3 class="serif-title text-2xl font-bold text-charcoal">Ubah Password</h3>
            <button onclick="document.getElementById('passwordModal').classList.add('hidden'); document.getElementById('passwordModal').classList.remove('flex')"
                    class="text-charcoal/30 hover:text-charcoal transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            @if(session('status') === 'password-updated')
                <div class="bg-green-50 text-green-700 px-4 py-3 rounded-xl text-sm font-medium">
                    Password berhasil diubah!
                </div>
            @endif

            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-charcoal/40">Password Saat Ini</label>
                <input type="password" name="current_password"
                       class="w-full px-5 py-4 bg-naomi-bg border-2 border-transparent rounded-2xl focus:border-primary/30 focus:bg-white outline-none font-medium text-charcoal transition-all"
                       placeholder="••••••••">
                @error('current_password', 'updatePassword')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-charcoal/40">Password Baru</label>
                <input type="password" name="password"
                       class="w-full px-5 py-4 bg-naomi-bg border-2 border-transparent rounded-2xl focus:border-primary/30 focus:bg-white outline-none font-medium text-charcoal transition-all"
                       placeholder="••••••••">
                @error('password', 'updatePassword')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-charcoal/40">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation"
                       class="w-full px-5 py-4 bg-naomi-bg border-2 border-transparent rounded-2xl focus:border-primary/30 focus:bg-white outline-none font-medium text-charcoal transition-all"
                       placeholder="••••••••">
            </div>

            <div class="flex gap-4 pt-4">
                <button type="button"
                        onclick="document.getElementById('passwordModal').classList.add('hidden'); document.getElementById('passwordModal').classList.remove('flex')"
                        class="flex-1 py-4 border-2 border-charcoal/5 rounded-2xl text-[10px] font-black uppercase tracking-widest text-charcoal/40 hover:bg-naomi-bg transition-all">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 py-4 bg-primary text-naomi-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg hover:bg-charcoal transition-all">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@if(session('status') === 'password-updated')
<script>
    document.getElementById('passwordModal').classList.remove('hidden');
    document.getElementById('passwordModal').classList.add('flex');
</script>
@endif
