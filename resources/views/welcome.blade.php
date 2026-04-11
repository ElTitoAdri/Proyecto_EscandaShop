<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EscandaShop | Joyería y Complementos Premium</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        :root {
            --brand-charcoal: #5D574F;
            --brand-gray: #F2F2F2;
            --brand-dark: #333333;
            --brand-white: #FFFFFF;
        }

        .dark {
            --brand-charcoal: #A19B94;
            --brand-gray: #161615;
            --brand-dark: #EDEDEC;
            --brand-white: #0A0A0A;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--brand-dark);
            background-color: var(--brand-white);
            transition: background-color 0.4s cubic-bezier(0.4, 0, 0.2, 1), color 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .bg-brand-white { background-color: var(--brand-white); }
        .bg-brand-gray { background-color: var(--brand-gray); }
        .text-brand-charcoal { color: var(--brand-charcoal); }
        .border-brand-charcoal { border-color: var(--brand-charcoal); }

        .hero-gradient {
            background: linear-gradient(rgba(255,255,255,0.8), rgba(255,255,255,0.4)), url('https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
        }

        .dark .hero-gradient {
            background: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?q=80&w=2070&auto=format&fit=crop');
        }

        .product-card:hover .product-actions {
            opacity: 1;
            transform: translateY(0);
        }

        .product-actions {
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s ease;
        }

        .sticky-nav {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.9);
            transition: background-color 0.4s ease;
        }

        .dark .sticky-nav {
            background-color: rgba(10, 10, 10, 0.9);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="antialiased">

    <!-- Navigation -->
    <nav class="sticky top-0 z-50 sticky-nav border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="text-2xl font-serif tracking-widest text-brand-charcoal uppercase">EscandaShop</a>
                </div>
                
                <div class="hidden md:flex space-x-8 items-center">
                    @foreach($categories as $category)
                        <a href="#" class="text-sm font-medium hover:text-brand-charcoal transition dark:text-gray-400 dark:hover:text-white">{{ $category->name }}</a>
                    @endforeach
                </div>

                <div class="flex items-center space-x-4 md:space-x-6">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-medium hover:text-brand-charcoal dark:text-gray-300">Mi Cuenta</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium hover:text-brand-charcoal dark:text-gray-300">Acceder</a>
                        @endauth
                    @endif
                    
                    <button class="relative p-2 text-brand-charcoal dark:text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-brand-charcoal rounded-full transform translate-x-1/2 -translate-y-1/2">0</span>
                    </button>

                    <!-- Theme Toggle -->
                    <button @click="darkMode = !darkMode; localStorage.setItem('theme', darkMode ? 'dark' : 'light')" 
                            class="p-2 text-brand-charcoal dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/10 rounded-full transition-colors duration-300"
                            title="Cambiar modo">
                        <template x-if="!darkMode">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </template>
                        <template x-if="darkMode">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 7a5 5 0 100 10 5 5 0 000-10z" />
                            </svg>
                        </template>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative h-[70vh] flex items-center justify-center hero-gradient">
        <div class="text-center px-4 max-w-4xl mx-auto">
            <h1 class="text-5xl md:text-7xl font-serif mb-6 text-brand-dark tracking-tight">Elegancia Atemporal</h1>
            <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 mb-10 max-w-2xl mx-auto font-light leading-relaxed">
                Descubre nuestra colección exclusiva de joyería artesanal diseñada para resaltar tu brillo natural en cada momento especial.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#catalog" class="px-10 py-4 bg-brand-charcoal text-white text-sm font-semibold tracking-widest uppercase hover:bg-black transition-colors duration-300">Explorar Colección</a>
                <a href="#" class="px-10 py-4 border border-brand-charcoal text-brand-charcoal dark:border-white/20 dark:text-white text-sm font-semibold tracking-widest uppercase hover:bg-brand-gray dark:hover:bg-white/10 transition-colors duration-300">Nueva Temporada</a>
            </div>
        </div>
    </section>

    <!-- Categories Bar -->
    <div class="bg-brand-gray py-4 border-b border-gray-200 dark:border-white/10">
        <div class="max-w-7xl mx-auto px-4 flex justify-center space-x-12 overflow-x-auto whitespace-nowrap scrollbar-hide py-2">
            @foreach($categories as $category)
                <a href="#" class="text-xs uppercase tracking-[0.2em] text-gray-500 hover:text-brand-charcoal font-semibold transition dark:text-gray-400 dark:hover:text-white">{{ $category->name }}</a>
            @endforeach
        </div>
    </div>

    <!-- Featured Products -->
    <section id="catalog" class="py-24 bg-brand-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-serif text-brand-dark mb-4 uppercase tracking-wider">Lo más destacado</h2>
                <div class="w-16 h-1 bg-brand-charcoal mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-12">
                @foreach($products as $product)
                    <div class="product-card group relative">
                        <!-- Image Container -->
                        <div class="aspect-square bg-brand-gray overflow-hidden relative mb-4">
                            @php
                                $primaryImage = $product->images->where('is_primary', true)->first() ?? $product->images->first();
                            @endphp
                            <img src="{{ $primaryImage ? $primaryImage->url : 'https://placehold.co/600x600?text=' . urlencode($product->name) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover object-center group-hover:scale-110 transition duration-700">
                            
                            <!-- Overlay Actions -->
                            <div class="product-actions absolute inset-0 bg-black/10 flex items-center justify-center space-x-4">
                                <button onclick="addToCart('{{ $product->id }}', '{{ $product->name }}')" 
                                        class="p-4 bg-white rounded-full text-brand-charcoal hover:bg-brand-charcoal hover:text-white transition shadow-xl"
                                        title="Añadir al carrito">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </button>
                                <a href="#" class="p-4 bg-white rounded-full text-brand-charcoal hover:bg-brand-charcoal hover:text-white transition shadow-xl"
                                   title="Ver detalles">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="text-center">
                            <h3 class="text-sm font-medium text-gray-800 dark:text-[#A1A09A] uppercase tracking-widest mb-2">{{ $product->name }}</h3>
                            <p class="text-lg font-serif text-brand-charcoal">{{ number_format($product->price, 2) }} €</p>
                            
                            <div class="mt-4 flex justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                                <a href="#" class="text-[10px] uppercase font-bold tracking-widest text-brand-charcoal hover:underline underline-offset-4">Ver más detalles</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-20 text-center">
                <a href="#" class="inline-block border-b-2 border-brand-charcoal pb-1 text-sm font-semibold tracking-widest uppercase hover:text-brand-charcoal hover:border-black transition dark:text-gray-400 dark:hover:text-white">Ver todo el catálogo</a>
            </div>
        </div>
    </section>

    <!-- Brand Commitment -->
    <section class="py-24 bg-brand-gray border-t border-gray-100 dark:border-white/5">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-12 text-center text-brand-charcoal">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto mb-6 opacity-60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                </svg>
                <h4 class="font-serif text-xl mb-4 text-brand-dark">Artesanía Pura</h4>
                <p class="text-sm font-light leading-relaxed dark:text-gray-400">Cada pieza es cuidadosamente fabricada por maestros artesanos garantizando calidad y exclusividad.</p>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto mb-6 opacity-60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h4 class="font-serif text-xl mb-4 text-brand-dark">Envío Urgente</h4>
                <p class="text-sm font-light leading-relaxed dark:text-gray-400">Recibe tus joyas en un periodo de 24 a 48 horas en cualquier parte de la península.</p>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto mb-6 opacity-60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <h4 class="font-serif text-xl mb-4 text-brand-dark">Garantía Escanda</h4>
                <p class="text-sm font-light leading-relaxed dark:text-gray-400">Nuestras piezas cuentan con certificado de autenticidad y 2 años de garantía total.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-brand-dark text-white py-20 px-4 dark:bg-black border-t border-white/5">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-16 mb-20">
                <div class="col-span-1 md:col-span-2 text-center md:text-left">
                    <h5 class="text-2xl font-serif tracking-widest uppercase mb-8">EscandaShop</h5>
                    <p class="text-gray-400 font-light max-w-sm mb-8 leading-loose mx-auto md:mx-0">
                        Uniendo la tradición joyera con el diseño contemporáneo para crear piezas que cuentan historias.
                    </p>
                    <div class="flex space-x-6 justify-center md:justify-start">
                        <a href="#" class="text-gray-400 hover:text-white transition uppercase text-xs tracking-widest font-bold">Instagram</a>
                        <a href="#" class="text-gray-400 hover:text-white transition uppercase text-xs tracking-widest font-bold">Facebook</a>
                        <a href="#" class="text-gray-400 hover:text-white transition uppercase text-xs tracking-widest font-bold">Pinterest</a>
                    </div>
                </div>
                <div class="text-center md:text-left">
                    <h6 class="text-xs uppercase tracking-widest font-bold mb-8">Atención al Cliente</h6>
                    <ul class="space-y-4 text-sm text-gray-400 font-light">
                        <li><a href="#" class="hover:text-white transition">Envíos y Devoluciones</a></li>
                        <li><a href="#" class="hover:text-white transition">Guía de Tallas</a></li>
                        <li><a href="#" class="hover:text-white transition">Contacto</a></li>
                        <li><a href="#" class="hover:text-white transition">Preguntas Frecuentes</a></li>
                    </ul>
                </div>
                <div class="text-center md:text-left">
                    <h6 class="text-xs uppercase tracking-widest font-bold mb-8">Newsletter</h6>
                    <p class="text-xs text-gray-400 mb-6 leading-relaxed">Suscríbete para recibir noticias sobre lanzamientos exclusivos y ofertas especiales.</p>
                    <form class="flex border-b border-gray-600 pb-2">
                        <input type="email" placeholder="Email" class="bg-transparent border-none focus:outline-none focus:ring-0 text-sm w-full placeholder-gray-600">
                        <button class="bg-transparent text-gray-400 hover:text-white transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="pt-10 border-t border-gray-800 flex flex-col md:flex-row justify-between items-center text-[10px] text-gray-500 uppercase tracking-widest font-bold gap-4 text-center">
                <p>&copy; 2026 EscandaShop. Todos los derechos reservados.</p>
                <div class="flex space-x-8">
                    <a href="#" class="hover:text-white transition">Aviso Legal</a>
                    <a href="#" class="hover:text-white transition">Privacidad</a>
                    <a href="#" class="hover:text-white transition">Cookies</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Simple Toast for Mockup -->
    <div id="toast" class="fixed bottom-10 right-10 bg-brand-charcoal text-white px-6 py-4 rounded shadow-2xl transition translate-y-20 opacity-0 z-[100]">
        <span id="toast-message"></span>
    </div>

    <script>
        function addToCart(id, name) {
            const toast = document.getElementById('toast');
            const message = document.getElementById('toast-message');
            message.innerText = `Has añadido ${name} al carrito`;
            
            toast.classList.remove('translate-y-20', 'opacity-0');
            setTimeout(() => {
                toast.classList.add('translate-y-20', 'opacity-0');
            }, 3000);
        }
    </script>
</body>
</html>
