<x-admin-layout title="Usuarios">

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Usuarios</h1>
            <p class="admin-page-subtitle">Gestiona los permisos y clientes de la tienda.</p>
        </div>
    </div>

    <div class="admin-panel" style="padding: 0;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Nº Pedidos</th>
                    <th>Alta</th>
                    <th style="text-align: right;">Rol</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span class="admin-product-name">{{ $user->name }}</span>
                                @if($user->id === Auth::id())
                                    <span style="background: var(--admin-charcoal); color: white; font-size: 9px; font-weight: 700; padding: 2px 6px; border-radius: 4px; text-transform: uppercase; letter-spacing: 0.05em;">Tú</span>
                                @endif
                            </div>
                        </td>
                        <td style="color: var(--admin-text-muted);">{{ $user->email }}</td>
                        <td style="color: var(--admin-text-muted);">—</td>
                        <td>
                            <span style="color: var(--admin-gold); font-weight: 600;">{{ $user->orders_count }}</span>
                        </td>
                        <td style="color: var(--admin-text-muted);">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td style="text-align: right;">
                            @if($user->role === 'admin')
                                <span style="font-size: 11px; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; color: var(--admin-charcoal);">Administrador</span>
                            @else
                                <span class="admin-badge" style="background: var(--admin-bg); border: 1px solid var(--admin-border); color: var(--admin-text); font-size: 11px;">Usuario</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: var(--admin-text-muted);">
                            No hay usuarios registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-admin-layout>
