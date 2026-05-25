<x-layouts.layout :categories="$categories" :title="$product->name . ' | EscandaShop'">
    <div class="py-12 bg-white dark:bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <nav class="flex mb-8 text-xs uppercase tracking-widest font-bold text-gray-400" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li><a href="{{ route('home') }}" class="hover:text-brand-charcoal transition">Inicio</a></li>
                    <li><svg class="w-3 h-3 mx-2" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 11 7.293 7.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"></path></svg></li>
                    <li><a href="{{ route('home', ['category' => $product->category->slug]) }}" class="hover:text-brand-charcoal transition">{{ $product->category->name }}</a></li>
                    <li><svg class="w-3 h-3 mx-2" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 11 7.293 7.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"></path></svg></li>
                    <li class="text-brand-charcoal">{{ $product->name }}</li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
                <!-- Image Gallery -->
                <div class="space-y-4" x-data="{ activeImage: '{{ $product->images->where('is_primary', true)->first()->url ?? ($product->images->first()->url ?? 'https://placehold.co/800x800?text=' . urlencode($product->name)) }}' }">
                    <div class="aspect-square bg-brand-gray overflow-hidden">
                        <img :src="activeImage" alt="{{ $product->name }}" class="w-full h-full object-cover object-center transition duration-500">
                    </div>
                    
                    @if($product->images->count() > 1)
                        <div class="grid grid-cols-4 gap-4">
                            @foreach($product->images as $image)
                                <button @click="activeImage = '{{ $image->url }}'" 
                                        class="aspect-square bg-brand-gray overflow-hidden border-2 transition"
                                        :class="activeImage === '{{ $image->url }}' ? 'border-brand-charcoal' : 'border-transparent hover:border-gray-200'">
                                    <img src="{{ $image->url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Product Content -->
                <div class="flex flex-col h-full">
                    <div class="mb-8">
                        <span class="text-xs uppercase tracking-[0.3em] font-bold text-gray-400 mb-2 block">{{ $product->category->name }}</span>
                        <h1 class="text-4xl md:text-5xl font-serif text-brand-dark mb-2 tracking-tight">{{ $product->name }}</h1>
                        
                        <!-- Media de Valoración -->
                        @php
                            $averageRating = $product->reviews->avg('rating') ?? 0;
                            $reviewsCount = $product->reviews->count();
                        @endphp
                        <div class="flex items-center gap-2 mb-4 text-sm font-sans">
                            <div class="text-amber-500 flex items-center">
                                @if($reviewsCount > 0)
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= round($averageRating))
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                @else
                                    ☆☆☆☆☆
                                @endif
                            </div>
                            <span class="text-xs font-light text-gray-500 dark:text-gray-400">
                                @if($reviewsCount > 0)
                                    {{ number_format($averageRating, 1) }} ({{ $reviewsCount }} {{ $reviewsCount == 1 ? 'opinión' : 'opiniones' }})
                                @else
                                    Aún sin opiniones
                                @endif
                            </span>
                        </div>

                        <p class="text-2xl font-serif text-brand-charcoal">{{ number_format($product->price, 2) }} €</p>
                    </div>

                    <div class="prose prose-sm dark:prose-invert text-gray-600 dark:text-gray-400 mb-10 font-light leading-relaxed">
                        {!! nl2br(e($product->description)) !!}
                    </div>

                    <div class="mb-10 space-y-6">
                        <div class="flex items-center space-x-4">
                            <div class="flex border border-gray-200 dark:border-white/10" x-data="{ qty: 1 }">
                                <button @click="if(qty > 1) qty--" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-white/5 transition">-</button>
                                <input type="number" x-model="qty" class="w-12 text-center border-none bg-transparent focus:ring-0 text-sm font-bold" readonly>
                                <button @click="qty++" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-white/5 transition">+</button>
                            </div>
                            <span class="text-xs text-gray-400 font-bold uppercase tracking-widest">Stock: {{ $product->stock }} unidades</span>
                        </div>

                        <button onclick="addToCart('{{ $product->id }}', '{{ $product->name }}')" 
                                class="w-full py-5 bg-brand-charcoal text-white text-sm font-semibold tracking-widest uppercase hover:bg-black transition-colors duration-300 flex items-center justify-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span>Añadir al Carrito</span>
                        </button>
                    </div>

                    <!-- Additional Details -->
                    <div class="border-t border-gray-100 dark:border-white/5 pt-8 space-y-4">
                        <details class="group">
                            <summary class="flex justify-between items-center cursor-pointer list-none py-2">
                                <span class="text-xs uppercase tracking-widest font-bold">Detalles del Envío</span>
                                <span class="text-gray-400 group-open:rotate-180 transition-transform">+</span>
                            </summary>
                            <p class="text-xs text-gray-500 py-4 font-light leading-relaxed">Envío gratuito en pedidos superiores a 150€. Tiempo estimado de entrega: 2-3 días laborales.</p>
                        </details>
                        <details class="group">
                            <summary class="flex justify-between items-center cursor-pointer list-none py-2">
                                <span class="text-xs uppercase tracking-widest font-bold">Cuidado de la Joya</span>
                                <span class="text-gray-400 group-open:rotate-180 transition-transform">+</span>
                            </summary>
                            <p class="text-xs text-gray-500 py-4 font-light leading-relaxed">Para mantener el brillo original, evite el contacto con perfumes y productos químicos fuertes. Limpie suavemente con el paño incluido.</p>
                        </details>
                    </div>
                </div>
            </div>

            <!-- Sección de Opiniones y Reseñas -->
            <div class="mt-24 border-t border-gray-100 dark:border-white/5 pt-16">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-16">
                    
                    <!-- Lista de Opiniones (2/3 de pantalla) -->
                    <div class="lg:col-span-2 space-y-8">
                        <h2 class="text-2xl font-serif font-bold text-brand-dark uppercase tracking-wider mb-6">Opiniones de los Clientes</h2>
                        
                        @if($product->reviews->isEmpty())
                            <div class="bg-gray-50 dark:bg-zinc-900/40 border border-gray-100 dark:border-zinc-800/80 rounded-2xl p-8 text-center text-gray-500 dark:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto mb-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <p class="font-sans text-sm font-light">Este producto aún no tiene opiniones. ¡Sé el primero en compartir tu experiencia!</p>
                            </div>
                        @else
                            <div class="space-y-6">
                                @foreach($product->reviews as $review)
                                    <div class="border-b border-gray-100 dark:border-zinc-900 pb-6 last:border-none last:pb-0">
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold text-xs uppercase font-sans">
                                                    {{ substr($review->user->name ?? 'C', 0, 1) }}
                                                </div>
                                                <div>
                                                    <h4 class="text-sm font-bold text-gray-800 dark:text-white">{{ $review->user->name ?? 'Cliente Anónimo' }}</h4>
                                                    <div class="text-amber-500 flex items-center text-xs mt-0.5">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= $review->rating)
                                                                ★
                                                            @else
                                                                ☆
                                                            @endif
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="text-xs text-gray-400 font-sans font-light">{{ $review->created_at->format('d/m/Y') }}</span>
                                        </div>
                                        <p class="text-sm font-light text-gray-600 dark:text-gray-400 leading-relaxed pl-11">
                                            {{ $review->comment }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Formulario de Dejar Opinión (1/3 de pantalla) -->
                    <div class="col-span-1">
                        <div class="bg-gray-50 dark:bg-zinc-900/40 border border-gray-100 dark:border-zinc-800/80 rounded-2xl p-6 md:p-8 transition-colors duration-400">
                            <h3 class="text-lg font-serif font-bold text-brand-dark uppercase tracking-wider mb-6 border-b border-gray-200 dark:border-zinc-800 pb-2">Dejar tu Opinión</h3>

                            @if(session('success'))
                                <div class="p-4 mb-6 text-sm text-green-700 bg-green-50 dark:bg-green-950/20 dark:text-green-400 rounded-xl border border-green-200 dark:border-green-800/30">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="p-4 mb-6 text-sm text-red-700 bg-red-50 dark:bg-red-950/20 dark:text-red-400 rounded-xl border border-red-200 dark:border-red-800/30">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @auth
                                <form action="{{ route('reviews.store', $product->id) }}" method="POST" class="space-y-6" x-data="{ rating: 5, hoverRating: 0 }">
                                    @csrf
                                    <div>
                                        <label class="block text-xs uppercase tracking-widest font-bold text-gray-400 mb-2">Tu Puntuación</label>
                                        <input type="hidden" name="rating" :value="rating">
                                        <div class="flex items-center gap-2 text-2xl">
                                            <template x-for="i in 5">
                                                <button type="button" 
                                                        @click="rating = i" 
                                                        @mouseenter="hoverRating = i" 
                                                        @mouseleave="hoverRating = 0"
                                                        class="transition duration-150 transform hover:scale-110 focus:outline-none">
                                                    <span :class="(hoverRating || rating) >= i ? 'text-amber-500' : 'text-gray-300 dark:text-zinc-700'">★</span>
                                                </button>
                                            </template>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-xs uppercase tracking-widest font-bold text-gray-400 mb-2">Tu Comentario</label>
                                        <textarea name="comment" rows="4" required 
                                                  class="w-full text-sm p-4 border border-gray-200 dark:border-zinc-800 rounded-xl bg-white dark:bg-zinc-950 focus:ring-1 focus:ring-amber-500 focus:outline-none dark:text-white" 
                                                  placeholder="Escribe tu opinión sobre esta joya..."></textarea>
                                    </div>

                                    <button type="submit" class="w-full py-4 bg-brand-charcoal hover:bg-black text-white text-xs font-bold uppercase tracking-widest transition-colors duration-300 rounded-xl flex items-center justify-center">
                                        Publicar Reseña
                                    </button>
                                </form>
                            @else
                                <div class="text-center py-6">
                                    <p class="text-sm font-light text-gray-500 dark:text-gray-400 mb-6">Debes iniciar sesión para poder dejar tu valoración sobre este producto.</p>
                                    <a href="{{ route('login') }}" class="inline-block w-full py-4 bg-brand-charcoal hover:bg-black text-white text-xs font-bold uppercase tracking-widest transition rounded-xl">
                                        Iniciar Sesión
                                    </a>
                                </div>
                            @endauth
                        </div>
                    </div>

                </div>
            </div>

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <div class="mt-32">
                    <div class="text-center mb-16">
                        <h2 class="text-2xl font-serif text-brand-dark mb-4 uppercase tracking-wider">También te puede gustar</h2>
                        <div class="w-12 h-0.5 bg-brand-charcoal mx-auto"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        @foreach($relatedProducts as $related)
                            <div class="product-card group text-center">
                                <a href="{{ route('products.show', $related->slug) }}" class="block aspect-square bg-brand-gray overflow-hidden mb-4">
                                    @php
                                        $relImage = $related->images->where('is_primary', true)->first() ?? $related->images->first();
                                    @endphp
                                    <img src="{{ $relImage ? $relImage->url : 'https://placehold.co/600x600?text=' . urlencode($related->name) }}" 
                                         alt="{{ $related->name }}" 
                                         class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                                </a>
                                <h3 class="text-xs font-bold uppercase tracking-widest mb-1 text-gray-400">{{ $related->name }}</h3>
                                <p class="text-sm font-serif text-brand-charcoal">{{ number_format($related->price, 2) }} €</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.layout>
