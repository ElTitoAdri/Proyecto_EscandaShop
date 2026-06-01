<x-layouts.guest>
    <div class="mb-6">
        <h2 class="text-xl font-serif text-gray-900 dark:text-white font-medium text-center">Crear Cuenta</h2>
        <p class="text-xs text-gray-400 dark:text-gray-500 text-center mt-1">Únete a EscandaShop para disfrutar de una experiencia exclusiva.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2 dark:text-gray-400">Nombre Completo</label>
            <input id="name" type="text" name="name" 
                   value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="w-full text-sm py-3 px-4 border border-gray-200 dark:border-white/10 rounded-xl bg-gray-50 dark:bg-black/20 dark:text-white focus:ring-1 focus:ring-brand-charcoal focus:border-brand-charcoal focus:outline-none transition-all @error('name') border-red-500 @enderror">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2 dark:text-gray-400">Correo Electrónico</label>
            <input id="email" type="email" name="email" 
                   value="{{ old('email') }}" required autocomplete="username"
                   class="w-full text-sm py-3 px-4 border border-gray-200 dark:border-white/10 rounded-xl bg-gray-50 dark:bg-black/20 dark:text-white focus:ring-1 focus:ring-brand-charcoal focus:border-brand-charcoal focus:outline-none transition-all @error('email') border-red-500 @enderror">
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2 dark:text-gray-400">Contraseña</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="w-full text-sm py-3 px-4 border border-gray-200 dark:border-white/10 rounded-xl bg-gray-50 dark:bg-black/20 dark:text-white focus:ring-1 focus:ring-brand-charcoal focus:border-brand-charcoal focus:outline-none transition-all @error('password') border-red-500 @enderror">
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2 dark:text-gray-400">Confirmar Contraseña</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="w-full text-sm py-3 px-4 border border-gray-200 dark:border-white/10 rounded-xl bg-gray-50 dark:bg-black/20 dark:text-white focus:ring-1 focus:ring-brand-charcoal focus:border-brand-charcoal focus:outline-none transition-all @error('password_confirmation') border-red-500 @enderror">
            @error('password_confirmation')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                class="w-full py-3.5 bg-brand-charcoal text-white text-xs font-bold tracking-[0.2em] uppercase hover:bg-black transition-colors rounded-xl shadow-lg border border-brand-charcoal/20 flex items-center justify-center">
            Crear Cuenta
        </button>

        <!-- Divider & Login Link -->
        <div class="border-t border-gray-100 dark:border-white/5 pt-4 text-center">
            <span class="text-xs text-gray-400">¿Ya tienes una cuenta?</span>
            <a href="{{ route('login') }}" class="text-xs font-bold text-amber-600 hover:text-amber-700 dark:text-amber-500 dark:hover:text-amber-400 ms-1 transition">
                Inicia sesión
            </a>
        </div>
    </form>
</x-layouts.guest>
