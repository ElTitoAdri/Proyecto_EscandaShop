<x-layouts.app :categories="$categories" title="Finalizar Pedido | EscandaShop">
    <div class="py-24 bg-brand-white dark:bg-black min-h-[85vh] text-brand-dark dark:text-gray-100 transition-colors duration-400">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Breadcrumbs -->
            <div class="flex items-center gap-2 text-xs uppercase tracking-widest font-bold text-gray-400 mb-8">
                <a href="{{ route('cart.index') }}" class="hover:text-brand-charcoal transition">Carrito</a>
                <span>/</span>
                <span class="text-gray-600 dark:text-zinc-400">Dirección y Pago</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                
                <!-- Formulario Dirección (Left 7 cols) -->
                <div class="lg:col-span-7 bg-white dark:bg-zinc-900 shadow-xl border border-gray-100 dark:border-white/5 rounded-2xl p-8 md:p-10 transition-colors duration-400">
                    <h2 class="text-2xl font-serif font-bold mb-2">Dirección de Envío</h2>
                    <p class="text-sm text-gray-400 dark:text-gray-500 font-light mb-8">Confirma o ingresa la dirección donde enviaremos tus joyas. Se guardará en tu perfil.</p>

                    <form action="{{ route('checkout.process') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="address" class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2 dark:text-gray-400">Dirección de Envío</label>
                            <input type="text" id="address" name="address" 
                                   value="{{ old('address', $user->address) }}" required
                                   placeholder="Calle, número, piso, puerta..."
                                   class="w-full text-sm py-3.5 px-4 border border-gray-200 dark:border-zinc-800 rounded-xl bg-gray-50 dark:bg-zinc-950 dark:text-white focus:ring-1 focus:ring-brand-charcoal focus:border-brand-charcoal focus:outline-none transition-all @error('address') border-red-500 @enderror">
                            @error('address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                            <div>
                                <label for="city" class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2 dark:text-gray-400">Ciudad</label>
                                <input type="text" id="city" name="city" 
                                       value="{{ old('city', $user->city) }}" required
                                       class="w-full text-sm py-3.5 px-4 border border-gray-200 dark:border-zinc-800 rounded-xl bg-gray-50 dark:bg-zinc-950 dark:text-white focus:ring-1 focus:ring-brand-charcoal focus:border-brand-charcoal focus:outline-none transition-all @error('city') border-red-500 @enderror">
                                @error('city')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="postal_code" class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2 dark:text-gray-400">Código Postal</label>
                                <input type="text" id="postal_code" name="postal_code" 
                                       value="{{ old('postal_code', $user->postal_code) }}" required
                                       class="w-full text-sm py-3.5 px-4 border border-gray-200 dark:border-zinc-800 rounded-xl bg-gray-50 dark:bg-zinc-950 dark:text-white focus:ring-1 focus:ring-brand-charcoal focus:border-brand-charcoal focus:outline-none transition-all @error('postal_code') border-red-500 @enderror">
                                @error('postal_code')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="province" class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2 dark:text-gray-400">Provincia</label>
                                <input type="text" id="province" name="province" 
                                       value="{{ old('province', $user->province) }}" required
                                       class="w-full text-sm py-3.5 px-4 border border-gray-200 dark:border-zinc-800 rounded-xl bg-gray-50 dark:bg-zinc-950 dark:text-white focus:ring-1 focus:ring-brand-charcoal focus:border-brand-charcoal focus:outline-none transition-all @error('province') border-red-500 @enderror">
                                @error('province')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="pt-4 border-t border-gray-100 dark:border-zinc-800">
                            <button type="submit" 
                                    class="w-full py-4 bg-brand-charcoal dark:bg-white text-white dark:text-black text-xs font-bold tracking-[0.2em] uppercase hover:bg-black dark:hover:bg-gray-200 transition-colors rounded-xl shadow-lg border border-brand-charcoal/20 dark:border-white/10 flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                <span>Proceder al Pago con Stripe</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Resumen Pedido (Right 5 cols) -->
                <div class="lg:col-span-5 space-y-6">
                    <div class="bg-gray-50 dark:bg-zinc-900 shadow-sm border border-gray-100 dark:border-white/5 rounded-2xl p-6 md:p-8 transition-colors duration-400">
                        <h3 class="text-xs uppercase tracking-widest font-bold mb-6 text-brand-charcoal dark:text-amber-400">Resumen del pedido</h3>
                        
                        <div class="divide-y divide-gray-200 dark:divide-zinc-800 max-h-64 overflow-y-auto mb-6 pr-2">
                            @foreach($cart as $id => $details)
                                <div class="flex items-center justify-between py-4 first:pt-0 last:pb-0">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 flex-shrink-0 bg-brand-gray overflow-hidden rounded-lg">
                                            <img src="{{ $details['image'] }}" alt="{{ $details['name'] }}" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 max-w-[150px] truncate">{{ $details['name'] }}</h4>
                                            <p class="text-[10px] text-gray-400 font-light mt-0.5">Cant: {{ $details['quantity'] }} &times; {{ number_format($details['price'], 2) }} €</p>
                                        </div>
                                    </div>
                                    <span class="text-xs font-serif font-bold text-gray-900 dark:text-zinc-200">
                                        {{ number_format($details['price'] * $details['quantity'], 2) }} €
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t border-gray-200 dark:border-zinc-800 pt-4 space-y-4 text-xs font-light">
                            <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                <span>Subtotal</span>
                                <span>{{ number_format($total, 2) }} €</span>
                            </div>
                            <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                <span>Envío</span>
                                <span class="text-green-600 font-medium">Gratis</span>
                            </div>
                            <div class="border-t border-gray-200 dark:border-zinc-800 pt-4 flex justify-between text-base font-serif text-gray-900 dark:text-white">
                                <span>Total</span>
                                <span class="font-bold">{{ number_format($total, 2) }} €</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-layouts.app>
