<x-layouts.admin title="Pedidos">

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Pedidos</h1>
            <p class="admin-page-subtitle">Gestiona los pedidos de tus clientes.</p>
        </div>
    </div>

    <div class="admin-panel" style="padding: 0;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Ref. Pedido</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Total</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>
                            <span class="admin-product-name">ES-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td>{{ $order->user->name ?? 'Cliente eliminado' }}</td>
                        <td style="color: var(--admin-text-muted);">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div style="display: flex; flex-direction: column; gap: 6px; align-items: flex-start;">
                                <span class="admin-badge 
                                    @if($order->status === 'pending') admin-badge-pending
                                    @elseif($order->status === 'paid') admin-badge-completed
                                    @elseif($order->status === 'shipped') admin-badge-completed
                                    @elseif($order->status === 'completed') admin-badge-completed
                                    @else admin-badge-cancelled
                                    @endif">
                                    @if($order->status === 'pending') Pendiente
                                    @elseif($order->status === 'paid') Pagado
                                    @elseif($order->status === 'shipped') Enviado
                                    @elseif($order->status === 'completed') Completado
                                    @elseif($order->status === 'cancelled') Cancelado
                                    @else {{ ucfirst($order->status) }}
                                    @endif
                                </span>
                                
                                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()" style="padding: 4px 8px; border-radius: 4px; border: 1px solid #e2e8f0; background-color: #f8fafc; font-size: 11px; font-weight: 500; color: #475569; outline: none; cursor: pointer; transition: all 0.2s; border-color: #cbd5e1;">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Cambiar a: Pendiente</option>
                                        <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Cambiar a: Pagado</option>
                                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Cambiar a: Enviado 🚚</option>
                                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Cambiar a: Completado 🎉</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cambiar a: Cancelado ❌</option>
                                    </select>
                                </form>
                            </div>
                        </td>
                        <td style="font-weight: 600; font-size: 16px;">{{ number_format($order->total_price, 2, ',', '.') }} €</td>
                        <td>
                            <div class="admin-table-actions" style="justify-content: flex-end;">
                                <a href="#" title="Ver detalle">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: var(--admin-text-muted);">
                            No hay pedidos registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-layouts.admin>
