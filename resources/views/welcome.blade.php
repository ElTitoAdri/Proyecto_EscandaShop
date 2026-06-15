<x-layouts.app :categories="$categories">
    <!-- Hero Section -->
    <section class="relative h-[80vh] flex items-center justify-center hero-gradient">
        <div class="text-center px-4 max-w-4xl mx-auto">
            <span class="text-xs uppercase tracking-[0.4em] font-bold text-brand-charcoal mb-4 block">Nuestra Historia</span>
            <h1 class="text-5xl md:text-8xl font-serif mb-8 text-brand-dark tracking-tighter leading-none">La Esencia de EscandaShop</h1>
            <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 mb-12 max-w-2xl mx-auto font-light leading-relaxed italic">
                "Creemos que una joya no es solo un accesorio, sino un fragmento de una historia personal capturado en metal y piedra."
            </p>
            <a href="{{ route('store.index') }}" class="px-12 py-5 bg-brand-charcoal dark:bg-white text-white dark:text-black text-xs font-bold tracking-[0.3em] uppercase hover:bg-black dark:hover:bg-gray-200 transition-all duration-500 shadow-2xl">Explorar la Colección</a>
        </div>
    </section>

    <!-- Our Values / Manifesto -->
    <section class="py-32 bg-white dark:bg-black overflow-hidden">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-24 items-center">
                <div class="relative">
                    <div class="aspect-[4/5] bg-brand-gray overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1573408301185-9146fe634ad0?q=80&w=2069&auto=format&fit=crop" 
                             alt="Artesanía Escanda" 
                             class="w-full h-full object-cover">
                    </div>
                    <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-brand-gray hidden lg:block -z-10"></div>
                </div>
                
                <div class="space-y-12">
                    <h2 class="text-4xl font-serif text-brand-dark leading-tight italic">Artesanía que trasciende el tiempo</h2>
                    
                    <div class="space-y-8">
                        <div>
                            <h3 class="text-xs uppercase tracking-widest font-bold mb-4 text-brand-charcoal">Tradición Orfebre</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 font-light leading-relaxed">
                                En el corazón de nuestro taller, cada pieza es concebida como una obra única. Fusionamos técnicas ancestrales de orfebrería con una visión estética contemporánea, asegurando que cada detalle refleje la maestría de nuestras manos.
                            </p>
                        </div>
                        
                        <div>
                            <h3 class="text-xs uppercase tracking-widest font-bold mb-4 text-brand-charcoal">Compromiso Ético</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 font-light leading-relaxed">
                                Seleccionamos personalmente cada material, desde el oro de ley hasta las piedras preciosas, bajo los más estrictos estándares de sostenibilidad y comercio justo. En EscandaShop, la belleza exterior debe nacer de la integridad interior.
                            </p>
                        </div>

                        <div>
                            <h3 class="text-xs uppercase tracking-widest font-bold mb-4 text-brand-charcoal">Elegancia Atemporal</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 font-light leading-relaxed">
                                No seguimos tendencias efímeras. Diseñamos piezas para que te acompañen toda la vida, convirtiéndose en legados familiares que pasan de generación en generación con el mismo brillo del primer día.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Brand Commitment Strip -->
    <section class="py-24 bg-brand-gray border-t border-gray-100 dark:border-white/5">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-12 text-center text-brand-charcoal">
            <div>
                <h4 class="font-serif text-3xl mb-4 text-brand-dark italic">4.8/5</h4>
                <p class="text-xs uppercase tracking-widest font-bold text-gray-400 mb-2">Puntuación Clientes</p>
                <p class="text-[10px] font-light leading-relaxed">Excelencia respaldada por más de 10,000 reseñas verificadas.</p>
            </div>
            <div>
                <h4 class="font-serif text-3xl mb-4 text-brand-dark italic">Handmade</h4>
                <p class="text-xs uppercase tracking-widest font-bold text-gray-400 mb-2">100% Artesanal</p>
                <p class="text-[10px] font-light leading-relaxed">Fabricado íntegramente en España por maestros joyeros.</p>
            </div>
            <div>
                <h4 class="font-serif text-3xl mb-4 text-brand-dark italic">Eco-Conscious</h4>
                <p class="text-xs uppercase tracking-widest font-bold text-gray-400 mb-2">Packaging Sostenible</p>
                <p class="text-[10px] font-light leading-relaxed">Materiales reciclables y procesos de bajo impacto ambiental.</p>
            </div>
        </div>
    </section>

    <!-- Final Call to Action -->
    <section class="py-32 bg-white dark:bg-black text-center">
        <div class="max-w-3xl mx-auto px-4">
            <h2 class="text-4xl font-serif text-brand-dark mb-8 italic">¿Lista para encontrar tu próximo amuleto?</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-12 font-light leading-relaxed">
                Navega a través de nuestras colecciones exclusivas y descubre la pieza que resuena con tu esencia.
            </p>
            <a href="{{ route('store.index') }}" class="inline-block border-b-2 border-brand-charcoal pb-2 text-xs font-bold tracking-[0.3em] uppercase hover:text-brand-charcoal hover:border-black transition-all">Visitar la tienda</a>
        </div>
    </section>
</x-layouts.app>
