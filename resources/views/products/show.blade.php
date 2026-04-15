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
                        <h1 class="text-4xl md:text-5xl font-serif text-brand-dark mb-4 tracking-tight">{{ $product->name }}</h1>
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
