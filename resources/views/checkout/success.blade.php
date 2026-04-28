<x-layouts.layout :categories="$categories" title="Pago Completado | EscandaShop">
    <div class="py-32 bg-brand-white flex items-center justify-center min-h-[70vh]">
        <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-8">
                <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            
            <h1 class="text-4xl font-serif text-brand-dark mb-4 tracking-wider">¡Gracias por tu compra!</h1>
            <p class="text-gray-500 font-light mb-8">
                Tu pedido se ha procesado correctamente. Recibirás un correo de confirmación con los detalles del envío en breve.
            </p>

            @if(isset($order))
                <div class="bg-brand-gray p-6 mb-8 text-sm">
                    <p class="font-bold text-brand-charcoal uppercase tracking-widest mb-2">Detalles del Pedido</p>
                    <p class="text-gray-600">Nº Pedido: #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                    <p class="text-gray-600">Total: {{ number_format($order->total_price, 2) }} €</p>
                </div>
            @endif

            <a href="{{ route('store.index') }}" class="inline-block px-10 py-4 bg-brand-charcoal text-white text-xs font-bold tracking-[0.2em] uppercase hover:bg-black transition-colors duration-300 shadow-xl">
                Volver a la Tienda
            </a>
        </div>
    </div>
</x-layouts.layout>
