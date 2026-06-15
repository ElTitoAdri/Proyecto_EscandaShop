<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }" :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>EscandaShop | Joyería Premium</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Inter:wght@100..900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-brand-dark bg-brand-white transition-colors duration-300 dark:bg-black antialiased flex items-center justify-center min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-md w-full space-y-8">
            <!-- Luxury Branding Header -->
            <div class="text-center">
                <a href="/" class="inline-block transition-transform hover:scale-105 duration-300">
                    <h1 class="text-4xl font-serif tracking-[0.2em] uppercase text-gray-900 dark:text-white" style="font-family: 'Playfair Display', Georgia, serif;">
                        ESCANDA<span class="text-amber-500 font-light" style="color: #d4af37;">SHOP</span>
                    </h1>
                </a>
                <p class="text-[9px] uppercase tracking-[0.4em] text-gray-400 font-bold mt-2 dark:text-gray-500">Joyería & Complementos Premium</p>
            </div>

            <!-- Card Container with Elegant Top Gold Border -->
            <div class="bg-white dark:bg-brand-gray py-10 px-8 sm:px-10 rounded-2xl shadow-xl border border-gray-100 dark:border-white/5 relative overflow-hidden">
                <!-- Gold Accent Line -->
                <div class="absolute top-0 left-0 right-0 h-1.5" style="background-color: #d4af37;"></div>
                
                {{ $slot }}
            </div>
            
            <!-- Bottom Link Back Home -->
            <div class="text-center">
                <a href="/" class="text-xs uppercase tracking-widest font-bold text-gray-400 hover:text-brand-charcoal dark:hover:text-white transition-colors duration-300">
                    ← Volver a la página principal
                </a>
            </div>
        </div>

    </body>
</html>
