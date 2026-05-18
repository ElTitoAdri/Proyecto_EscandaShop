<x-admin-layout title="Ajustes">

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Ajustes</h1>
            <p class="admin-page-subtitle">Configura el comportamiento y el aspecto de tu escaparate.</p>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #D1FAE5; border: 1px solid #A7F3D0; color: #065F46; padding: 12px 20px; border-radius: 8px; margin-bottom: 24px; font-size: 13px; font-weight: 500;">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf

        {{-- Textos Principales --}}
        <div class="admin-panel" style="margin-bottom: 24px;">
            <h3 class="admin-panel-title" style="margin-bottom: 24px;">Textos Principales (Portada)</h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <div>
                    <label style="display: block; font-size: 10px; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: var(--admin-text-muted); margin-bottom: 8px;">
                        Título Principal (Hero)
                    </label>
                    <input type="text" name="hero_title" 
                           value="{{ old('hero_title', $settings['hero_title'] ?? 'Lujo y Elegancia Atemporal') }}"
                           style="width: 100%; padding: 12px 16px; border: 1px solid var(--admin-border); border-radius: 8px; font-size: 14px; font-family: 'Inter', sans-serif; color: var(--admin-text); background: var(--admin-white); outline: none; transition: border-color 0.2s;"
                           onfocus="this.style.borderColor='var(--admin-charcoal)'" onblur="this.style.borderColor='var(--admin-border)'">
                    <p style="font-size: 11px; color: var(--admin-gold); margin-top: 6px; font-style: italic;">El título grande que recibe a los clientes.</p>
                </div>

                <div>
                    <label style="display: block; font-size: 10px; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: var(--admin-text-muted); margin-bottom: 8px;">
                        Subtítulo (Hero)
                    </label>
                    <textarea name="hero_subtitle" rows="3"
                              style="width: 100%; padding: 12px 16px; border: 1px solid var(--admin-border); border-radius: 8px; font-size: 14px; font-family: 'Inter', sans-serif; color: var(--admin-text); background: var(--admin-white); outline: none; resize: vertical; transition: border-color 0.2s;"
                              onfocus="this.style.borderColor='var(--admin-charcoal)'" onblur="this.style.borderColor='var(--admin-border)'">{{ old('hero_subtitle', $settings['hero_subtitle'] ?? 'Descubre nuestra nueva colección de joyas exclusivas donde el diseño contemporáneo se une con la artesanía tradicional.') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Información de Contacto --}}
        <div class="admin-panel" style="margin-bottom: 24px;">
            <h3 class="admin-panel-title" style="margin-bottom: 24px;">Información de Contacto</h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <div>
                    <label style="display: block; font-size: 10px; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: var(--admin-text-muted); margin-bottom: 8px;">
                        Email de Soporte/Contacto
                    </label>
                    <input type="email" name="contact_email" 
                           value="{{ old('contact_email', $settings['contact_email'] ?? 'contacto@escandashop.com') }}"
                           style="width: 100%; padding: 12px 16px; border: 1px solid var(--admin-border); border-radius: 8px; font-size: 14px; font-family: 'Inter', sans-serif; color: var(--admin-text); background: var(--admin-white); outline: none; transition: border-color 0.2s;"
                           onfocus="this.style.borderColor='var(--admin-charcoal)'" onblur="this.style.borderColor='var(--admin-border)'">
                </div>

                <div>
                    <label style="display: block; font-size: 10px; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: var(--admin-text-muted); margin-bottom: 8px;">
                        Teléfono Tienda
                    </label>
                    <input type="text" name="contact_phone" 
                           value="{{ old('contact_phone', $settings['contact_phone'] ?? '+34 900 000 000') }}"
                           style="width: 100%; padding: 12px 16px; border: 1px solid var(--admin-border); border-radius: 8px; font-size: 14px; font-family: 'Inter', sans-serif; color: var(--admin-text); background: var(--admin-white); outline: none; transition: border-color 0.2s;"
                           onfocus="this.style.borderColor='var(--admin-charcoal)'" onblur="this.style.borderColor='var(--admin-border)'">
                </div>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end;">
            <button type="submit" class="admin-btn-primary">
                Guardar Configuración
            </button>
        </div>
    </form>

</x-admin-layout>
