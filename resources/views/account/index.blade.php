<x-layouts.app :categories="$categories" title="Mi Cuenta | EscandaShop">
    <div class="py-12 bg-gray-50 dark:bg-zinc-950 min-h-screen text-gray-800 dark:text-gray-100 transition-colors duration-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Section -->
            <div class="bg-white dark:bg-zinc-900 shadow-sm border border-gray-100 dark:border-zinc-800/80 rounded-2xl p-6 md:p-8 mb-8 transition-colors duration-400">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center font-serif text-2xl font-bold shadow-inner">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <h1 class="text-3xl font-serif font-bold text-gray-900 dark:text-white mb-1">¡Hola, {{ $user->name }}!</h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400 font-light">Cliente premium desde el {{ $user->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('profile.edit') }}" class="px-5 py-2.5 bg-gray-100 dark:bg-zinc-800 hover:bg-gray-200 dark:hover:bg-zinc-700 text-gray-700 dark:text-gray-200 text-xs font-bold uppercase tracking-wider rounded-xl transition duration-300 shadow-sm">
                            Editar Perfil
                        </a>
                        @if($user->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold uppercase tracking-wider rounded-xl transition duration-300 shadow-md">
                                Panel Admin
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-zinc-900 shadow-sm border border-gray-100 dark:border-zinc-800/80 rounded-2xl p-6 transition-colors duration-400">
                    <p class="text-[10px] text-gray-400 dark:text-gray-500 uppercase tracking-widest font-bold mb-2">Total Pedidos</p>
                    <p class="text-3xl font-serif font-bold text-amber-600 dark:text-amber-400">{{ $orders->count() }}</p>
                </div>
                <div class="bg-white dark:bg-zinc-900 shadow-sm border border-gray-100 dark:border-zinc-800/80 rounded-2xl p-6 transition-colors duration-400">
                    <p class="text-[10px] text-gray-400 dark:text-gray-500 uppercase tracking-widest font-bold mb-2">Total Invertido</p>
                    <p class="text-3xl font-serif font-bold text-amber-600 dark:text-amber-400">{{ number_format($orders->sum('total_price'), 2, ',', '.') }} €</p>
                </div>
                <div class="bg-white dark:bg-zinc-900 shadow-sm border border-gray-100 dark:border-zinc-800/80 rounded-2xl p-6 transition-colors duration-400">
                    <p class="text-[10px] text-gray-400 dark:text-gray-500 uppercase tracking-widest font-bold mb-2">Último Pedido</p>
                    <p class="text-3xl font-serif font-bold text-amber-600 dark:text-amber-400">
                        {{ $orders->first() ? $orders->first()->created_at->format('d/m/Y') : 'Ninguno' }}
                    </p>
                </div>
            </div>

            <!-- Content Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Orders History (Left / 2 cols) -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-zinc-900 shadow-sm border border-gray-100 dark:border-zinc-800/80 rounded-2xl p-6 md:p-8 transition-colors duration-400">
                        <h2 class="text-xl font-serif font-bold text-gray-900 dark:text-white mb-6">Tu Historial de Pedidos</h2>
                        
                        @if($orders->isEmpty())
                            <div class="text-center py-12">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400 font-light mb-4">Aún no has realizado ningún pedido.</p>
                                <a href="{{ route('store.index') }}" class="inline-block px-6 py-3 bg-brand-dark dark:bg-amber-600 hover:bg-black dark:hover:bg-amber-700 text-white text-xs font-bold uppercase tracking-widest rounded-xl transition duration-300 shadow">
                                    Ir a la tienda
                                </a>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="border-b border-gray-100 dark:border-zinc-800/60 pb-4 text-xs uppercase tracking-widest font-bold text-gray-400">
                                            <th class="py-3">Pedido</th>
                                            <th class="py-3">Fecha</th>
                                            <th class="py-3">Artículos</th>
                                            <th class="py-3">Total</th>
                                            <th class="py-3 text-center">Estado</th>
                                            <th class="py-3 text-right">Detalles</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800/50">
                                        @foreach($orders as $order)
                                            <tr class="text-sm font-light text-gray-700 dark:text-gray-300">
                                                <td class="py-4 font-bold text-gray-900 dark:text-white">
                                                    #{{ $order->id }}
                                                </td>
                                                <td class="py-4">
                                                    {{ $order->created_at->format('d/m/Y') }}
                                                </td>
                                                <td class="py-4">
                                                    <div class="flex -space-x-2 overflow-hidden">
                                                        @foreach($order->items->take(3) as $item)
                                                            @if($item->product && $item->product->images->isNotEmpty())
                                                                <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white dark:ring-zinc-900 object-cover" 
                                                                     src="{{ Str::startsWith($item->product->images->first()->url, ['http://', 'https://']) ? $item->product->images->first()->url : asset('storage/' . $item->product->images->first()->url) }}" 
                                                                     alt="{{ $item->product->name }}">
                                                            @else
                                                                <div class="inline-block h-8 w-8 rounded-full bg-gray-200 dark:bg-zinc-800 ring-2 ring-white dark:ring-zinc-900 flex items-center justify-center text-[10px] text-gray-500 font-bold">
                                                                    ?
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                        @if($order->items->count() > 3)
                                                            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-100 dark:bg-zinc-800 ring-2 ring-white dark:ring-zinc-900 text-xs font-bold text-gray-500">
                                                                +{{ $order->items->count() - 3 }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="py-4 font-bold text-amber-600 dark:text-amber-400">
                                                    {{ number_format($order->total_price, 2, ',', '.') }} €
                                                </td>
                                                <td class="py-4 text-center">
                                                    @php
                                                        $statusClasses = match(strtolower($order->status)) {
                                                            'entregado' => 'bg-green-50 dark:bg-green-500/10 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-800/30',
                                                            'enviado' => 'bg-blue-50 dark:bg-blue-500/10 text-blue-700 dark:text-blue-400 border border-blue-200 dark:border-blue-800/30',
                                                            'pagado' => 'bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800/30',
                                                            default => 'bg-gray-50 dark:bg-zinc-800 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-zinc-700'
                                                        };
                                                    @endphp
                                                    <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-full {{ $statusClasses }}">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </td>
                                                <td class="py-4 text-right">
                                                    <a href="{{ route('account.orders.show', $order->id) }}" class="inline-flex items-center gap-1 text-amber-600 hover:text-amber-700 dark:text-amber-400 dark:hover:text-amber-300 font-bold text-xs uppercase tracking-wider transition">
                                                        <span>Ver</span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Info Card (Right / 1 col) -->
                <div class="col-span-1">
                    <div class="bg-white dark:bg-zinc-900 shadow-sm border border-gray-100 dark:border-zinc-800/80 rounded-2xl p-6 md:p-8 transition-colors duration-400 mb-8">
                        <h3 class="text-lg font-serif font-bold text-gray-900 dark:text-white mb-6">Tus Datos Personales</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-1">Nombre Completo</p>
                                <p class="text-sm font-light text-gray-800 dark:text-gray-200">{{ $user->name }}</p>
                            </div>
                            <div class="border-t border-gray-100 dark:border-zinc-800/50 pt-4">
                                <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-1">Correo Electrónico</p>
                                <p class="text-sm font-light text-gray-800 dark:text-gray-200">{{ $user->email }}</p>
                            </div>
                            <div class="border-t border-gray-100 dark:border-zinc-800/50 pt-4">
                                <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-1">Rol de Acceso</p>
                                <span class="px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded bg-gray-100 dark:bg-zinc-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-zinc-700">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-tr from-amber-600 to-amber-500 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
                        <!-- Background Pattern -->
                        <div class="absolute -right-10 -bottom-10 opacity-10 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-44 w-44" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h4 class="text-lg font-serif font-bold mb-3">¿Necesitas ayuda?</h4>
                        <p class="text-xs font-light text-amber-50 mb-6 leading-relaxed">
                            Si tienes dudas con el estado de alguno de tus pedidos, devoluciones o necesitas asesoramiento premium, no dudes en contactar con nosotros.
                        </p>
                        <a href="mailto:soporte@escandashop.com" class="inline-block px-5 py-2.5 bg-white text-amber-600 text-xs font-bold uppercase tracking-wider rounded-xl transition duration-300 hover:bg-amber-50 shadow">
                            Soporte Escanda
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-layouts.app>
