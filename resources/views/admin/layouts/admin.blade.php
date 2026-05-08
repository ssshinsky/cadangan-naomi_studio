<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Naomi Studio</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Background (60%) - Warm Linen
                        "naomi-bg": "#F5F3F0", 
                        
                        // Secondary (30%) - Muted Greige
                        "naomi-surface": "#E6E2DB", 
                        "naomi-muted": "#A8A29E", 
                        
                        // Accent (10%) - Deep Charcoal
                        "primary": "#2D2A28", 
                        
                        // Text & Shadow
                        "charcoal": "#1A1918",
                        "naomi-white": "#FFFFFF",
                    },
                    fontFamily: {
                        "sans": ["Poppins", "sans-serif"],
                        "serif": ["Playfair Display", "serif"],
                        "display": ["Manrope", "sans-serif"],
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined { 
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; 
            transition: all 0.3s ease;
        }
        
        /* Nav Active State - Updated to Deep Charcoal Palette */
        .nav-active { 
            background: linear-gradient(to right, rgba(45, 42, 40, 0.1), rgba(45, 42, 40, 0.02)) !important;
            color: #2D2A28 !important; 
            position: relative;
        }
        .nav-active::after {
            content: "";
            position: absolute;
            right: 0;
            top: 20%;
            height: 60%;
            width: 4px;
            background-color: #2D2A28;
            border-radius: 4px 0 0 4px;
        }
        .nav-active span {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #A8A29E; border-radius: 10px; }
    </style>
</head>
<body class="bg-naomi-bg text-charcoal font-sans antialiased">

<div class="flex h-screen overflow-hidden">
    
    <aside class="w-80 bg-naomi-surface border-r border-naomi-muted/20 flex flex-col z-20">
        <div class="p-8 mb-4">
            <div class="flex items-center gap-4">
                <img src="{{ asset('storage/images/logo.png') }}" alt="Naomi Studio" class="h-12 w-auto">
                <div>
                    <h1 class="font-serif text-2xl font-black tracking-tight leading-none text-charcoal">Naomi</h1>
                    <p class="text-[9px] uppercase tracking-[0.3em] text-primary font-black mt-1">Management</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-6 space-y-2 overflow-y-auto custom-scrollbar">
            <p class="px-4 text-[10px] font-black uppercase tracking-[0.2em] text-primary/50 mb-4">Main Menu</p>
            
            <a href="{{ route('admin.dashboard') }}" 
               class="{{ request()->is('admin/dashboard') ? 'nav-active' : '' }} group flex items-center gap-4 px-5 py-4 rounded-2xl text-charcoal/60 hover:bg-naomi-bg/70 transition-all duration-300">
                <span class="material-symbols-outlined group-hover:scale-110">dashboard</span>
                <span class="text-sm font-bold tracking-wide">Dashboard</span>
            </a>

            <a href="{{ route('admin.studios.index') }}"  
               class="{{ request()->is('admin/studios*') ? 'nav-active' : '' }} group flex items-center gap-4 px-5 py-4 rounded-2xl text-charcoal/60 hover:bg-naomi-bg/70 transition-all duration-300">
                <span class="material-symbols-outlined group-hover:scale-110">photo_camera</span>
                <span class="text-sm font-bold tracking-wide">Kelola Studio</span>
            </a>

            <a href="{{ route('admin.bookings.index') }}" 
               class="{{ (request()->is('admin/bookings*') || request()->is('admin/orders*')) ? 'nav-active' : '' }} group flex items-center gap-4 px-5 py-4 rounded-2xl text-charcoal/60 hover:bg-naomi-bg/70 transition-all duration-300">
                <span class="material-symbols-outlined group-hover:scale-110">calendar_month</span>
                <span class="text-sm font-bold tracking-wide">Kelola Pesanan</span>
            </a>

            <a href="{{ route('admin.classes.index') }}" 
               class="{{ request()->is('admin/kelas') ? 'nav-active' : '' }} group flex items-center gap-4 px-5 py-4 rounded-2xl text-charcoal/60 hover:bg-naomi-bg/70 transition-all duration-300">
                <span class="material-symbols-outlined group-hover:scale-110">event_seat</span>
                <span class="text-sm font-bold tracking-wide">Kelola Kelas</span>
            </a>

            <a href="{{ route('admin.maintenance.index') }}" 
               class="{{ request()->is('admin/maintenance') ? 'nav-active' : '' }} group flex items-center gap-4 px-5 py-4 rounded-2xl text-charcoal/60 hover:bg-naomi-bg/70 transition-all duration-300">
                <span class="material-symbols-outlined group-hover:scale-110">engineering</span>
                <span class="text-sm font-bold tracking-wide">Maintenance</span>
            </a>


            <a href="{{ route('admin.laporan.index') }}"
             class="{{ request()->is('admin/laporan') ? 'nav-active' : '' }} group flex items-center gap-4 px-5 py-4 rounded-2xl text-charcoal/60 hover:bg-naomi-bg/70 transition-all duration-300">
                <span class="material-symbols-outlined group-hover:scale-110">payments</span>
                <span class="text-sm font-bold tracking-wide">Laporan Keuangan</span>
            </a>

            <a href="{{ route('admin.customers.index') }}" 
            class="{{ request()->is('admin/customers') ? 'nav-active' : '' }} group flex items-center gap-4 px-5 py-4 rounded-2xl text-charcoal/60 hover:bg-naomi-bg/70 transition-all duration-300">
                <span class="material-symbols-outlined group-hover:scale-110">group</span>
                <span class="text-sm font-bold tracking-wide">Database Pelanggan</span>
            </a>

        </nav>

        <div class="p-6 border-t border-naomi-muted/20 space-y-2">
            <!-- <a href="#" class="group flex items-center gap-4 px-5 py-4 rounded-2xl text-charcoal/60 hover:bg-naomi-bg/70 transition-all duration-300">
                <span class="material-symbols-outlined group-hover:rotate-45">settings</span>
                <span class="text-sm font-bold tracking-wide">Pengaturan</span>
            </a> -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full group flex items-center gap-4 px-5 py-4 rounded-2xl text-red-600 hover:bg-red-50 transition-all duration-300">
                    <span class="material-symbols-outlined group-hover:translate-x-1">logout</span>
                    <span class="text-sm font-bold tracking-wide">Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col overflow-hidden bg-naomi-bg">
        <header class="h-24 bg-naomi-white/70 backdrop-blur-xl sticky top-0 z-10 border-b border-naomi-muted/20 px-12 flex items-center justify-between">
            <div>
                 <p class="text-[10px] text-primary font-black uppercase tracking-widest bg-primary/10 px-3 py-1 rounded-full border border-primary/20">System Online</p>
            </div>

            <div class="flex items-center gap-6">
                @php
                    $unreadCount = \Illuminate\Support\Facades\DB::table('notifications')
                        ->whereNull('read_at')
                        ->where('notifiable_type', 'App\Models\Admin')
                        ->count();
                    $latestNotifications = \Illuminate\Support\Facades\DB::table('notifications')
                        ->where('notifiable_type', 'App\Models\Admin')
                        ->orderByDesc('created_at')
                        ->limit(5)
                        ->get()
                        ->map(function ($n) {
                            $n->data = json_decode($n->data, true);
                            return $n;
                        });
                @endphp

                {{-- Notification Bell --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="relative p-2 rounded-xl text-charcoal/60 hover:bg-naomi-surface transition-colors duration-200">
                        <span class="material-symbols-outlined text-2xl">notifications</span>
                        @if($unreadCount > 0)
                            <span class="absolute top-1 right-1 min-w-[18px] h-[18px] bg-red-500 text-white text-[10px] font-black rounded-full flex items-center justify-center px-1 leading-none">
                                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                            </span>
                        @endif
                    </button>

                    {{-- Dropdown --}}
                    <div x-show="open"
                         @click.outside="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-80 bg-naomi-white rounded-2xl shadow-xl border border-naomi-muted/20 z-50 overflow-hidden"
                         style="display: none;">

                        {{-- Header --}}
                        <div class="flex items-center justify-between px-5 py-4 border-b border-naomi-muted/20">
                            <h3 class="text-sm font-black text-charcoal">Notifikasi</h3>
                            @if($unreadCount > 0)
                                <form method="POST" action="{{ route('admin.notifications.read-all') }}">
                                    @csrf
                                    <button type="submit" class="text-[11px] font-bold text-primary hover:underline">
                                        Tandai Semua Dibaca
                                    </button>
                                </form>
                            @endif
                        </div>

                        {{-- List --}}
                        <div class="divide-y divide-naomi-muted/10 max-h-72 overflow-y-auto custom-scrollbar">
                            @forelse($latestNotifications as $notif)
                                <a href="{{ route('admin.notifications.read', $notif->id) }}"
                                   class="flex items-start gap-3 px-5 py-4 hover:bg-naomi-bg transition-colors duration-150 {{ is_null($notif->read_at) ? 'bg-primary/5' : '' }}">
                                    <div class="mt-0.5 size-8 rounded-xl bg-primary/10 flex items-center justify-center flex-shrink-0">
                                        <span class="material-symbols-outlined text-base text-primary">calendar_month</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-bold text-charcoal truncate">
                                            {{ $notif->data['customer_name'] ?? 'Customer' }}
                                        </p>
                                        <p class="text-[11px] text-charcoal/60 truncate">
                                            Booking #{{ $notif->data['booking_code'] ?? '-' }}
                                        </p>
                                        <p class="text-[10px] text-naomi-muted mt-0.5">
                                            {{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}
                                        </p>
                                    </div>
                                    @if(is_null($notif->read_at))
                                        <div class="size-2 rounded-full bg-red-500 mt-1.5 flex-shrink-0"></div>
                                    @endif
                                </a>
                            @empty
                                <div class="px-5 py-8 text-center">
                                    <span class="material-symbols-outlined text-3xl text-naomi-muted">notifications_off</span>
                                    <p class="text-xs text-naomi-muted mt-2">Tidak ada notifikasi</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4 pl-6 border-l border-naomi-muted/30">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-black text-charcoal leading-none">Admin Naomi</p>
                        <p class="text-[10px] text-primary uppercase tracking-[0.2em] font-bold mt-1">Superuser</p>
                    </div>
                    <div class="size-12 rounded-2xl bg-primary border-2 border-primary/10 overflow-hidden shadow-lg shadow-primary/20 group cursor-pointer">
                        <img src="https://ui-avatars.com/api/?name=Admin+Naomi&background=2D2A28&color=fff&bold=true" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="Admin">
                    </div>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-10 lg:p-14 custom-scrollbar">
            <div class="max-w-6xl mx-auto w-full">
                @yield('content')
            </div>
        </div>
    </main>
</div>

@include('components.toast')
@stack('scripts')
</body>
</html>