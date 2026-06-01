<x-layouts.app :categories="$categories" title="Pedido #{{ $order->id }} | EscandaShop">
    <div class="py-12 bg-gray-50 dark:bg-zinc-950 min-h-screen text-gray-800 dark:text-gray-100 transition-colors duration-400">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            
            <!-- Breadcrumbs -->
            <div class="flex items-center gap-2 text-xs uppercase tracking-widest font-bold text-gray-400 mb-6">
                <a href="{{ route('account.index') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition">Mi Cuenta</a>
                <span>/</span>
                <span class="text-gray-600 dark:text-zinc-400">Detalles de Pedido</span>
            </div>

            <!-- Header Card -->
            <div class="bg-white dark:bg-zinc-900 shadow-sm border border-gray-100 dark:border-zinc-800/80 rounded-2xl p-6 md:p-8 mb-8 transition-colors duration-400">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-serif font-bold text-gray-900 dark:text-white mb-2">Pedido #{{ $order->id }}</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-light font-sans">Realizado el {{ $order->created_at->format('d/m/Y \a \l\a\s H:i') }}</p>
                    </div>
                    <div>
                        @php
                            $statusClasses = match(strtolower($order->status)) {
                                'entregado' => 'bg-green-50 dark:bg-green-500/10 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-800/30',
                                'enviado' => 'bg-blue-50 dark:bg-blue-500/10 text-blue-700 dark:text-blue-400 border border-blue-200 dark:border-blue-800/30',
                                'pagado' => 'bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800/30',
                                default => 'bg-gray-50 dark:bg-zinc-800 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-zinc-700'
                            };
                        @endphp
                        <span class="px-4 py-1.5 text-xs font-bold uppercase tracking-wider rounded-full {{ $statusClasses }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Main Order Breakdown -->
            <div class="bg-white dark:bg-zinc-900 shadow-sm border border-gray-100 dark:border-zinc-800/80 rounded-2xl overflow-hidden mb-8 transition-colors duration-400">
                <div class="p-6 md:p-8 border-b border-gray-100 dark:border-zinc-800/50">
                    <h2 class="text-lg font-serif font-bold text-gray-900 dark:text-white mb-6">Artículos Comprados</h2>
                    
                    <div class="divide-y divide-gray-100 dark:divide-zinc-800/50">
                        @foreach($order->items as $item)
                            <div class="py-6 flex items-center gap-6 first:pt-0 last:pb-0">
                                @if($item->product && $item->product->images->isNotEmpty())
                                    <img class="h-16 w-16 rounded-xl object-cover border border-gray-100 dark:border-zinc-800" 
                                         src="{{ Str::startsWith($item->product->images->first()->url, ['http://', 'https://']) ? $item->product->images->first()->url : asset('storage/' . $item->product->images->first()->url) }}" 
                                         alt="{{ $item->product->name }}">
                                @else
                                    <div class="h-16 w-16 rounded-xl bg-gray-100 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 flex items-center justify-center text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif

                                <div class="flex-1">
                                    <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-1">
                                        @if($item->product)
                                            <a href="{{ route('products.show', $item->product->slug) }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition">
                                                {{ $item->product->name }}
                                            </a>
                                        @else
                                            Producto no disponible
                                        @endif
                                    </h3>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 font-light">
                                        Cantidad: {{ $item->quantity }} &times; {{ number_format($item->price_at_purchase, 2, ',', '.') }} €
                                    </p>
                                </div>

                                <div class="text-right font-bold text-gray-900 dark:text-white text-sm">
                                    {{ number_format($item->price_at_purchase * $item->quantity, 2, ',', '.') }} €
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Summary Details -->
                <div class="bg-gray-50 dark:bg-zinc-900/50 p-6 md:p-8 flex flex-col sm:flex-row justify-between gap-6 border-t border-gray-100 dark:border-zinc-800/50">
                    <div class="space-y-4 max-w-sm">
                        <div>
                            <h3 class="text-xs uppercase tracking-widest font-bold text-gray-400 mb-2">Dirección de Envío</h3>
                            <p class="text-sm font-light leading-relaxed text-gray-600 dark:text-gray-400">
                                {{ $order->shipping_address ?: 'No especificada' }}
                            </p>
                        </div>
                        @if($order->payment_id)
                            <div class="border-t border-gray-100 dark:border-zinc-800/50 pt-4">
                                <h3 class="text-xs uppercase tracking-widest font-bold text-gray-400 mb-1">Referencia de Pago</h3>
                                <p class="text-[11px] font-mono text-gray-500 dark:text-gray-500 break-all select-all">
                                    {{ $order->payment_id }}
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="w-full sm:w-64 space-y-3">
                        <div class="flex justify-between text-sm font-light text-gray-500 dark:text-gray-400">
                            <span>Subtotal</span>
                            <span>{{ number_format($order->total_price, 2, ',', '.') }} €</span>
                        </div>
                        <div class="flex justify-between text-sm font-light text-gray-500 dark:text-gray-400">
                            <span>Envío</span>
                            <span class="text-green-600 dark:text-green-400 font-bold uppercase text-xs tracking-wider">Gratis</span>
                        </div>
                        <div class="border-t border-gray-200 dark:border-zinc-800 pt-3 flex justify-between text-lg font-serif font-bold text-gray-900 dark:text-white">
                            <span>Total</span>
                            <span class="text-amber-600 dark:text-amber-400">{{ number_format($order->total_price, 2, ',', '.') }} €</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Action -->
            <div class="text-center">
                <a href="{{ route('account.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-brand-dark dark:bg-zinc-800 hover:bg-black dark:hover:bg-zinc-700 text-white text-xs font-bold uppercase tracking-widest rounded-xl transition duration-300 shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Volver a mi cuenta</span>
                </a>
            </div>

        </div>
    </div>
</x-layouts.app>
