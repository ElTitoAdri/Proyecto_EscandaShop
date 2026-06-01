@props(['categories', 'title' => 'EscandaShop | Joyería y Complementos Premium'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="antialiased font-sans text-brand-dark bg-brand-white transition-colors duration-400">

    <x-layouts.nav :categories="$categories" />

    <main>
        {{ $slot }}
    </main>

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
                        <li><a href="{{ route('contact.index') }}" class="hover:text-white transition">Contacto</a></li>
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
            const cartCount = document.getElementById('cart-count');
            
            fetch(`/carrito/añadir/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ quantity: 1 })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    message.innerText = `Has añadido ${name} al carrito`;
                    if (cartCount) cartCount.innerText = data.cart_count;
                    
                    toast.classList.remove('translate-y-20', 'opacity-0');
                    setTimeout(() => {
                        toast.classList.add('translate-y-20', 'opacity-0');
                    }, 3000);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>
