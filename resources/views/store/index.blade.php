<x-layouts.layout :categories="$categories">
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
            <a href="{{ route('store.index') }}" class="text-xs uppercase tracking-[0.2em] font-semibold transition dark:hover:text-white {{ !request('category') ? 'text-brand-charcoal dark:text-white border-b-2 border-brand-charcoal' : 'text-gray-500 dark:text-gray-400 hover:text-brand-charcoal' }}">Colección Completa</a>
            @foreach($categories as $category)
                <a href="{{ route('store.index', ['category' => $category->slug]) }}" class="text-xs uppercase tracking-[0.2em] font-semibold transition dark:hover:text-white {{ request('category') == $category->slug ? 'text-brand-charcoal dark:text-white border-b-2 border-brand-charcoal' : 'text-gray-500 dark:text-gray-400 hover:text-brand-charcoal' }}">{{ $category->name }}</a>
            @endforeach
        </div>
    </div>

    <!-- Featured Products -->
    <section id="catalog" class="py-24 bg-brand-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-serif text-brand-dark mb-4 uppercase tracking-wider">
                    @if(request('search'))
                        Resultados para: "{{ request('search') }}"
                    @elseif(request('category'))
                        Colección: {{ $categories->firstWhere('slug', request('category'))->name ?? request('category') }}
                    @else
                        Lo más destacado
                    @endif
                </h2>
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
                                <a href="{{ route('products.show', $product->slug) }}" class="p-4 bg-white rounded-full text-brand-charcoal hover:bg-brand-charcoal hover:text-white transition shadow-xl"
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
                                <a href="{{ route('products.show', $product->slug) }}" class="text-[10px] uppercase font-bold tracking-widest text-brand-charcoal hover:underline underline-offset-4">Ver más detalles</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-16">
                {{ $products->links() }}
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

    <!-- Script para scroll automático al filtrar/buscar -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Si la URL contiene parámetros de categoría, búsqueda o precios, desplazamos suavemente
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('category') || urlParams.has('search') || urlParams.has('min_price') || urlParams.has('max_price')) {
                const catalogSection = document.getElementById('catalog');
                if (catalogSection) {
                    // Esperamos una milésima de segundo para que carguen bien los elementos y hacemos scroll suave
                    setTimeout(() => {
                        catalogSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }, 100);
                }
            }
        });
    </script>
</x-layouts.layout>
