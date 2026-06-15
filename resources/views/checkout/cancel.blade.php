<x-layouts.app :categories="$categories" title="Pago Cancelado | EscandaShop">
    <div class="py-32 bg-brand-white flex items-center justify-center min-h-[70vh]">
        <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-8">
                <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </div>
            
            <h1 class="text-4xl font-serif text-brand-dark mb-4 tracking-wider">Pago Cancelado</h1>
            <p class="text-gray-500 font-light mb-8">
                El proceso de pago ha sido cancelado o ha ocurrido un error. No se te ha cobrado ningún importe. Tus productos siguen a salvo en el carrito.
            </p>

            <a href="{{ route('cart.index') }}" class="inline-block px-10 py-4 border border-brand-charcoal dark:border-white/20 text-brand-charcoal dark:text-white text-xs font-bold tracking-widest uppercase hover:bg-brand-charcoal dark:hover:bg-white hover:text-white dark:hover:text-black transition">
                Volver al Carrito
            </a>
        </div>
    </div>
</x-layouts.app>
