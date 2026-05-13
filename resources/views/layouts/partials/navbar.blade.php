<header class="sticky top-0 z-50 w-full bg-white/90 backdrop-blur-md border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('storage/images/logo.png') }}" alt="Naomi Studio" class="h-10 w-auto">
                <h1 class="serif-title text-xl font-bold tracking-widest text-primary hidden md:block">NAOMI'S STUDIO</h1>
            </a>
        </div>

        <nav class="hidden lg:flex items-center gap-10">
            <a class="text-sm font-medium transition-colors relative group {{ request()->routeIs('home') ? 'text-primary' : 'hover:text-primary' }}" href="{{ route('home') }}">
                Beranda
                <span class="absolute -bottom-1 left-0 h-0.5 bg-primary transition-all duration-300 {{ request()->routeIs('home') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
            </a>
            <a class="text-sm font-medium transition-colors relative group {{ request()->routeIs('studios.*') ? 'text-primary' : 'hover:text-primary' }}" href="{{ route('studios.index') }}">
                Studio
                <span class="absolute -bottom-1 left-0 h-0.5 bg-primary transition-all duration-300 {{ request()->routeIs('studios.*') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
            </a>
            <a class="text-sm font-medium transition-colors relative group {{ request()->routeIs('open-class.*') ? 'text-primary' : 'hover:text-primary' }}" href="{{ route('open-class.index') }}">
                Kelas
                <span class="absolute -bottom-1 left-0 h-0.5 bg-primary transition-all duration-300 {{ request()->routeIs('open-class.*') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
            </a>
            <a class="text-sm font-medium transition-colors relative group {{ request()->routeIs('about') ? 'text-primary' : 'hover:text-primary' }}" href="{{ route('about') }}">
                Tentang
                <span class="absolute -bottom-1 left-0 h-0.5 bg-primary transition-all duration-300 {{ request()->routeIs('about') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
            </a>
            <a class="text-sm font-medium transition-colors relative group {{ request()->routeIs('alur') ? 'text-primary' : 'hover:text-primary' }}" href="{{ route('alur') }}">
                Alur
                <span class="absolute -bottom-1 left-0 h-0.5 bg-primary transition-all duration-300 {{ request()->routeIs('alur') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
            </a>
        </nav>

        <div class="flex items-center gap-4">
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                       class="px-6 py-2 text-sm font-semibold border border-primary text-primary hover:bg-primary hover:text-white transition-all rounded-lg">
                        Admin Panel
                    </a>
                @else
                    <a href="{{ route('profil') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-primary shadow-md group-hover:scale-105 transition-transform">
                            @if(auth()->user()->customer?->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->customer->avatar) }}"
                                     class="w-full h-full object-cover" alt="Profil">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->customer?->name ?? 'U') }}&background=2D2A28&color=fff&bold=true"
                                     class="w-full h-full object-cover" alt="Profil">
                            @endif
                        </div>
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}"
                   class="hidden sm:inline-flex px-6 py-2 text-sm font-semibold border border-primary text-primary hover:bg-primary hover:text-white transition-all rounded-lg">
                    Masuk
                </a>
            @endauth
            <button id="mobileMenuBtn" class="lg:hidden p-2 rounded-xl hover:bg-gray-100 transition-colors" onclick="toggleMobileMenu()">
                <span class="material-symbols-outlined text-charcoal" id="menuIcon">menu</span>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobileMenu" class="hidden lg:hidden border-t border-gray-100 bg-white/95 backdrop-blur-md">
        <nav class="max-w-7xl mx-auto px-6 py-4 flex flex-col gap-1">
            <a class="px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('home') ? 'bg-primary/10 text-primary font-semibold' : 'text-charcoal hover:bg-primary/5 hover:text-primary' }}" href="{{ route('home') }}">Beranda</a>
            <a class="px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('studios.*') ? 'bg-primary/10 text-primary font-semibold' : 'text-charcoal hover:bg-primary/5 hover:text-primary' }}" href="{{ route('studios.index') }}">Studio</a>
            <a class="px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('open-class.*') ? 'bg-primary/10 text-primary font-semibold' : 'text-charcoal hover:bg-primary/5 hover:text-primary' }}" href="{{ route('open-class.index') }}">Kelas</a>
            <a class="px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('about') ? 'bg-primary/10 text-primary font-semibold' : 'text-charcoal hover:bg-primary/5 hover:text-primary' }}" href="{{ route('about') }}">Tentang</a>
            <a class="px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('alur') ? 'bg-primary/10 text-primary font-semibold' : 'text-charcoal hover:bg-primary/5 hover:text-primary' }}" href="{{ route('alur') }}">Alur</a>
            @guest
            <div class="pt-3 border-t border-gray-100 mt-2">
                <a href="{{ route('login') }}"
                   class="block w-full text-center px-6 py-3 text-sm font-semibold bg-primary text-white rounded-xl hover:bg-charcoal transition-all">
                    Masuk
                </a>
            </div>
            @endguest
        </nav>
    </div>
</header>

<script>
function toggleMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    const icon = document.getElementById('menuIcon');
    const isHidden = menu.classList.contains('hidden');
    menu.classList.toggle('hidden', !isHidden);
    icon.textContent = isHidden ? 'close' : 'menu';
}
</script>