<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('code') — Naomi Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: { extend: { colors: { primary: '#2D2A28', charcoal: '#1A1918', 'naomi-bg': '#F5F3F0' } } }
        }
    </script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .serif { font-family: 'Playfair Display', serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>
<body class="bg-naomi-bg min-h-screen flex items-center justify-center px-6">
    <div class="text-center max-w-lg">
        <div class="text-[120px] font-black text-primary/10 leading-none serif select-none">
            @yield('code')
        </div>
        <div class="size-20 bg-primary/10 rounded-3xl flex items-center justify-center mx-auto -mt-6 mb-8">
            <span class="material-symbols-outlined text-4xl text-primary">@yield('icon')</span>
        </div>
        <h1 class="serif text-4xl font-bold text-charcoal mb-4">@yield('title')</h1>
        <p class="text-charcoal/60 leading-relaxed mb-10">@yield('message')</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ url('/') }}"
               class="px-8 py-4 bg-primary text-white rounded-2xl font-bold text-sm uppercase tracking-widest hover:bg-charcoal transition-all shadow-lg">
                Kembali ke Beranda
            </a>
            <button onclick="history.back()"
                    class="px-8 py-4 border-2 border-primary/20 text-primary rounded-2xl font-bold text-sm uppercase tracking-widest hover:bg-primary/5 transition-all">
                Halaman Sebelumnya
            </button>
        </div>
    </div>
</body>
</html>
