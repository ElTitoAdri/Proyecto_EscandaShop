<x-admin-layout title="Mensajes">

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Mensajes de Contacto</h1>
            <p class="admin-page-subtitle">Formularios recibidos desde la página de contacto.</p>
        </div>
    </div>

    <div class="admin-panel" style="padding: 0;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Remitente</th>
                    <th>Teléfono</th>
                    <th>Asunto</th>
                    <th>Mensaje</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $message)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                {{-- Avatar con inicial --}}
                                <div style="width: 36px; height: 36px; border-radius: 50%; background: {{ $message->user_id ? '#D1FAE5' : '#F0EDE8' }}; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <span style="font-size: 13px; font-weight: 700; color: {{ $message->user_id ? '#065F46' : 'var(--admin-charcoal)' }};">
                                        {{ strtoupper(substr($message->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <p style="font-weight: 600; font-size: 13px; margin: 0;">{{ Str::limit($message->name, 22) }}</p>
                                    <p style="font-size: 11px; color: var(--admin-text-muted); margin: 0;">{{ Str::limit($message->email, 25) }}</p>
                                    @if($message->user_id)
                                        <span style="background: #D1FAE5; color: #065F46; font-size: 9px; font-weight: 700; padding: 1px 6px; border-radius: 4px; text-transform: uppercase; letter-spacing: 0.03em;">Registrado</span>
                                    @else
                                        <span style="background: #F0EDE8; color: var(--admin-charcoal); font-size: 9px; font-weight: 700; padding: 1px 6px; border-radius: 4px; text-transform: uppercase; letter-spacing: 0.03em;">Visitante</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td style="color: var(--admin-text-muted);">—</td>
                        <td>
                            <span style="font-weight: 600; color: var(--admin-gold);">{{ ucfirst($message->subject ?? 'General') }}</span>
                        </td>
                        <td style="color: var(--admin-text-muted); font-size: 13px;">{{ Str::limit($message->message, 30) }}</td>
                        <td>
                            <div style="color: var(--admin-text-muted); font-size: 12px;">
                                {{ $message->created_at->format('d/m/Y') }}<br>
                                <span style="font-size: 11px; opacity: 0.7;">{{ $message->created_at->format('H:i') }}</span>
                            </div>
                        </td>
                        <td>
                            @if($message->status === 'read')
                                <span class="admin-badge admin-badge-completed">Leído</span>
                            @else
                                <span class="admin-badge admin-badge-pending">Nuevo</span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" style="display: inline;" onsubmit="return confirm('¿Eliminar este mensaje?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #DC2626; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; cursor: pointer; padding: 6px 10px; border-radius: 6px; transition: background 0.2s;"
                                        onmouseover="this.style.background='#FEE2E2'" onmouseout="this.style.background='none'">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: var(--admin-text-muted);">
                            No hay mensajes recibidos.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-admin-layout>
