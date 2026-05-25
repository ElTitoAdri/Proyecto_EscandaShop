<x-layouts.layout :categories="$categories" title="Editar Perfil | EscandaShop">
    <div class="py-12 bg-gray-50 dark:bg-zinc-950 min-h-screen text-gray-800 dark:text-gray-100 transition-colors duration-400">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            
            <!-- Breadcrumbs -->
            <div class="flex items-center gap-2 text-xs uppercase tracking-widest font-bold text-gray-400 mb-6">
                <a href="{{ route('account.index') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition">Mi Cuenta</a>
                <span>/</span>
                <span class="text-gray-600 dark:text-zinc-400">Editar Perfil</span>
            </div>

            <!-- Header Card -->
            <div class="bg-white dark:bg-zinc-900 shadow-sm border border-gray-100 dark:border-zinc-800/80 rounded-2xl p-6 md:p-8 mb-8 transition-colors duration-400">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-serif font-bold text-gray-900 dark:text-white mb-2">Editar Perfil</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-light font-sans">Actualiza tu información personal y de seguridad.</p>
                    </div>
                    <a href="{{ route('account.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-zinc-800 hover:bg-gray-200 dark:hover:bg-zinc-700 text-gray-700 dark:text-gray-200 text-xs font-bold uppercase tracking-wider rounded-xl transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                        </svg>
                        <span>Volver</span>
                    </a>
                </div>
            </div>

            <!-- Forms Container -->
            <div class="space-y-8">
                <!-- Update Profile Info -->
                <div class="bg-white dark:bg-zinc-900 shadow-sm border border-gray-100 dark:border-zinc-800/80 rounded-2xl p-6 md:p-8 transition-colors duration-400">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Update Password -->
                <div class="bg-white dark:bg-zinc-900 shadow-sm border border-gray-100 dark:border-zinc-800/80 rounded-2xl p-6 md:p-8 transition-colors duration-400">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Delete User Account -->
                <div class="bg-white dark:bg-zinc-900 shadow-sm border border-gray-100 dark:border-zinc-800/80 rounded-2xl p-6 md:p-8 transition-colors duration-400">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-layouts.layout>
