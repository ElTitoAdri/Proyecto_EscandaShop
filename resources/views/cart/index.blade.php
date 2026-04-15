<x-layouts.layout :categories="$categories" title="Carrito de Compras | EscandaShop">
    <div class="py-24 bg-brand-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-4xl font-serif text-brand-dark mb-4 uppercase tracking-wider">Tu Carrito</h1>
                <div class="w-16 h-1 bg-brand-charcoal mx-auto"></div>
            </div>

            @if(count($cart) > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    <!-- Items List -->
                    <div class="lg:col-span-2 space-y-8">
                        @foreach($cart as $id => $details)
                            <div class="flex items-center space-x-6 py-6 border-b border-gray-100 dark:border-white/5 last:border-0">
                                <div class="w-24 h-24 flex-shrink-0 bg-brand-gray overflow-hidden">
                                    <img src="{{ $details['image'] }}" alt="{{ $details['name'] }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-grow">
                                    <a href="{{ route('products.show', $details['slug']) }}" class="text-sm font-bold uppercase tracking-widest hover:text-brand-charcoal transition">{{ $details['name'] }}</a>
                                    <p class="text-xs text-gray-400 mt-1">{{ number_format($details['price'], 2) }} €</p>
                                    
                                    <div class="mt-4 flex items-center justify-between">
                                        <form action="{{ route('cart.update') }}" method="POST" class="flex border border-gray-200 dark:border-white/10">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="id" value="{{ $id }}">
                                            <button type="button" @click="$refs.qty{{ $id }}.stepDown(); $refs.form{{ $id }}.submit()" class="px-3 py-1 hover:bg-gray-100 dark:hover:bg-white/5 transition">-</button>
                                            <input type="number" name="quantity" value="{{ $details['quantity'] }}" x-ref="qty{{ $id }}" readonly
                                                   class="w-10 text-center border-none bg-transparent focus:ring-0 text-xs font-bold">
                                            <button type="button" @click="$refs.qty{{ $id }}.stepUp(); $refs.form{{ $id }}.submit()" class="px-3 py-1 hover:bg-gray-100 dark:hover:bg-white/5 transition">+</button>
                                            <form id="form{{ $id }}" action="{{ route('cart.update') }}" method="POST" class="hidden">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="id" value="{{ $id }}">
                                                <input type="hidden" name="quantity" :value="$refs.qty{{ $id }}.value">
                                            </form>
                                        </form>

                                        <form action="{{ route('cart.remove') }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id" value="{{ $id }}">
                                            <button type="submit" class="text-[10px] uppercase font-bold tracking-widest text-red-400 hover:text-red-600 transition">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="text-sm font-serif font-bold">
                                    {{ number_format($details['price'] * $details['quantity'], 2) }} €
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-brand-gray p-8 dark:bg-white/5 sticky top-32">
                            <h2 class="text-xs uppercase tracking-widest font-bold mb-8 text-brand-charcoal">Resumen de compra</h2>
                            
                            <div class="space-y-4 text-sm font-light mb-8">
                                <div class="flex justify-between">
                                    <span>Subtotal</span>
                                    <span>{{ number_format($total, 2) }} €</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Envío</span>
                                    <span class="text-green-600">Gratis</span>
                                </div>
                            </div>

                            <div class="border-t border-gray-300 dark:border-white/10 pt-4 mb-8">
                                <div class="flex justify-between text-lg font-serif">
                                    <span>Total</span>
                                    <span class="font-bold">{{ number_format($total, 2) }} €</span>
                                </div>
                                <p class="text-[10px] text-gray-400 mt-2 uppercase tracking-widest">IVA incluido</p>
                            </div>

                            <button class="w-full py-4 bg-brand-charcoal text-white text-xs font-bold tracking-[0.2em] uppercase hover:bg-black transition-colors duration-300 shadow-xl">
                                Finalizar Pedido
                            </button>
                            
                            <div class="mt-6 flex justify-center space-x-4 opacity-30 grayscale pointer-events-none">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" class="h-4" alt="Visa">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" class="h-4" alt="Mastercard">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" class="h-4" alt="Paypal">
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-20">
                    <p class="text-gray-400 font-light mb-8">Tu carrito está vacío en este momento.</p>
                    <a href="{{ route('home') }}" class="inline-block px-10 py-4 border border-brand-charcoal text-brand-charcoal text-xs font-bold tracking-widest uppercase hover:bg-brand-charcoal hover:text-white transition">Volver a la tienda</a>
                </div>
            @endif
        </div>
    </div>
</x-layouts.layout>
