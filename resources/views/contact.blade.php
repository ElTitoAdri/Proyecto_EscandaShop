<x-layouts.app :categories="$categories" title="Contacto | EscandaShop">
    <div class="py-20 bg-brand-white dark:bg-black min-h-[80vh] flex items-center justify-center">
        <div class="max-w-4xl w-full mx-auto px-4 grid grid-cols-1 md:grid-cols-5 gap-12 items-stretch">
            
            <!-- Información de Contacto / Detalles de Lujo -->
            <div class="md:col-span-2 bg-brand-charcoal text-white p-10 rounded-2xl flex flex-col justify-between shadow-2xl relative overflow-hidden border border-brand-charcoal/20">
                <!-- Decoración -->
                <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full bg-brand-white/5 blur-2xl"></div>
                
                <div>
                    <span class="text-xs uppercase tracking-[0.4em] font-bold text-brand-gray mb-4 block">Atención Premium</span>
                    <h2 class="text-3xl font-serif mb-8 text-white tracking-wide leading-tight italic">Escríbenos tu consulta</h2>
                    <p class="text-sm text-gray-400 font-light leading-relaxed mb-8">
                        Nuestro equipo de atención al cliente está a tu entera disposición para resolver cualquier duda sobre colecciones, tallas o pedidos especiales.
                    </p>
                </div>
                
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <svg class="w-5 h-5 text-brand-gray mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <div>
                            <h4 class="text-xs uppercase tracking-widest font-bold text-white mb-1">Email</h4>
                            <p class="text-xs text-gray-400 font-light">soporte@escandashop.com</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4">
                        <svg class="w-5 h-5 text-brand-gray mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>
                            <h4 class="text-xs uppercase tracking-widest font-bold text-white mb-1">Horario de Taller</h4>
                            <p class="text-xs text-gray-400 font-light">Lunes a Viernes: 9:00 - 18:00</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Formulario Premium -->
            <div class="md:col-span-3 bg-white dark:bg-brand-gray p-10 rounded-2xl shadow-xl border border-gray-100 dark:border-white/5 flex flex-col justify-center">
                
                @if(session('success'))
                    <div class="mb-8 p-6 bg-green-50 dark:bg-green-900/10 border border-green-200 dark:border-green-800/30 text-green-800 dark:text-green-300 rounded-xl text-sm font-light leading-relaxed flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>
                            <strong class="font-semibold block mb-1">¡Mensaje Enviado!</strong>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-8 p-6 bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-800/30 text-red-800 dark:text-red-300 rounded-xl text-sm font-light leading-relaxed flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <div>
                            <strong class="font-semibold block mb-1">Error</strong>
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2 dark:text-gray-400">Nombre Completo</label>
                            <input type="text" id="name" name="name" 
                                   value="{{ old('name', auth()->user()->name ?? '') }}" required
                                   class="w-full text-sm py-3 px-4 border border-gray-200 dark:border-white/10 rounded-xl bg-gray-50 dark:bg-black/20 dark:text-white focus:ring-1 focus:ring-brand-charcoal focus:border-brand-charcoal focus:outline-none transition-all @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="email" class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2 dark:text-gray-400">Correo Electrónico</label>
                            <input type="email" id="email" name="email" 
                                   value="{{ old('email', auth()->user()->email ?? '') }}" required
                                   class="w-full text-sm py-3 px-4 border border-gray-200 dark:border-white/10 rounded-xl bg-gray-50 dark:bg-black/20 dark:text-white focus:ring-1 focus:ring-brand-charcoal focus:border-brand-charcoal focus:outline-none transition-all @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="subject" class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2 dark:text-gray-400">Asunto</label>
                        <input type="text" id="subject" name="subject" 
                               value="{{ old('subject') }}" required
                               class="w-full text-sm py-3 px-4 border border-gray-200 dark:border-white/10 rounded-xl bg-gray-50 dark:bg-black/20 dark:text-white focus:ring-1 focus:ring-brand-charcoal focus:border-brand-charcoal focus:outline-none transition-all @error('subject') border-red-500 @enderror">
                        @error('subject')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="message" class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2 dark:text-gray-400">Tu Consulta</label>
                        <textarea id="message" name="message" rows="5" required
                                  class="w-full text-sm py-3 px-4 border border-gray-200 dark:border-white/10 rounded-xl bg-gray-50 dark:bg-black/20 dark:text-white focus:ring-1 focus:ring-brand-charcoal focus:border-brand-charcoal focus:outline-none transition-all @error('message') border-red-500 @enderror" 
                                  placeholder="Escribe aquí tu mensaje detallado...">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" 
                            class="w-full py-4 bg-brand-charcoal text-white text-xs font-bold tracking-[0.2em] uppercase hover:bg-black transition-colors rounded-xl shadow-lg border border-brand-charcoal/20">
                        Enviar Mensaje
                    </button>
                </form>
            </div>
            
        </div>
    </div>
</x-layouts.app>
