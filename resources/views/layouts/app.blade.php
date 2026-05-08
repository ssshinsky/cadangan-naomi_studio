<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Naomi Studio')</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

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
                        "display": ["Playfair Display", "serif"],
                        "body": ["Poppins", "sans-serif"]
                    }
                }
            }
        }
    </script>

    <style>
        body { 
            font-family: 'Poppins', sans-serif;
            background-color: #F5F3F0; /* Matching naomi-bg */
            color: #1A1918;
            transition: all 0.3s ease;
        }

        .serif-title { font-family: 'Playfair Display', serif; }

        /* KONSISTENSI GLOBAL */
        
        /* 1. Button Utama (Deep Charcoal BG + White Text) */
        .btn-main {
            background-color: #2D2A28;
            color: #FFFFFF;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            font-size: 0.75rem;
        }
        
        .btn-main:hover {
            background-color: #1A1918;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(45, 42, 40, 0.2);
        }

        /* 2. Card Konsisten (Muted Greige BG) */
        .card-naomi {
            background-color: #E6E2DB;
            border: 1px solid rgba(168, 162, 158, 0.3);
            border-radius: 1rem;
            transition: all 300ms ease;
        }
        
        .card-naomi:hover {
            border-color: #2D2A28;
            background-color: #FFFFFF; /* Shift ke putih pas hover biar clean */
            box-shadow: 0 4px 25px rgba(0,0,0,0.03);
        }

        /* 3. Global Hover Link */
        .hover-link {
            transition: color 300ms ease;
        }
        .hover-link:hover {
            color: #2D2A28;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-naomi-bg text-charcoal antialiased">

    @if(!Route::is('login') && !Route::is('register'))
        @include('layouts.partials.navbar')
    @endif

    <main class="min-h-screen">
        @yield('content')
    </main>

    @if(!Route::is('login') && !Route::is('register'))
        @include('layouts.partials.footer')
    @endif

    @include('components.toast')
</body>
</html>