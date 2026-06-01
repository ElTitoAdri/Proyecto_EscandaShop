<x-layouts.guest>
    <div class="mb-6">
        <h2 class="text-xl font-serif text-gray-900 dark:text-white font-medium text-center">Acceso Privado</h2>
        <p class="text-xs text-gray-400 dark:text-gray-500 text-center mt-1">Ingresa tus credenciales para acceder a tu cuenta.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2 dark:text-gray-400">Correo Electrónico</label>
            <input id="email" type="email" name="email" 
                   value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="w-full text-sm py-3 px-4 border border-gray-200 dark:border-white/10 rounded-xl bg-gray-50 dark:bg-black/20 dark:text-white focus:ring-1 focus:ring-brand-charcoal focus:border-brand-charcoal focus:outline-none transition-all @error('email') border-red-500 @enderror">
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-2">
                <label for="password" class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Contraseña</label>
                @if (Route::has('password.request'))
                    <a class="text-xs text-amber-600 hover:text-amber-700 dark:text-amber-500 dark:hover:text-amber-400 transition" href="{{ route('password.request') }}">
                        ¿La olvidaste?
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="w-full text-sm py-3 px-4 border border-gray-200 dark:border-white/10 rounded-xl bg-gray-50 dark:bg-black/20 dark:text-white focus:ring-1 focus:ring-brand-charcoal focus:border-brand-charcoal focus:outline-none transition-all @error('password') border-red-500 @enderror">
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember"
                   class="h-4 w-4 rounded border-gray-300 dark:border-white/10 text-amber-600 focus:ring-amber-500 cursor-pointer">
            <label for="remember_me" class="ms-2 text-xs text-gray-500 dark:text-gray-400 cursor-pointer">Mantener sesión iniciada</label>
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                class="w-full py-3.5 bg-brand-charcoal text-white text-xs font-bold tracking-[0.2em] uppercase hover:bg-black transition-colors rounded-xl shadow-lg border border-brand-charcoal/20 flex items-center justify-center">
            Iniciar Sesión
        </button>

        <!-- Divider & Registration Link -->
        <div class="border-t border-gray-100 dark:border-white/5 pt-4 text-center">
            <span class="text-xs text-gray-400">¿Aún no eres miembro?</span>
            <a href="{{ route('register') }}" class="text-xs font-bold text-amber-600 hover:text-amber-700 dark:text-amber-500 dark:hover:text-amber-400 ms-1 transition">
                Regístrate ahora
            </a>
        </div>
    </form>
</x-layouts.guest>
