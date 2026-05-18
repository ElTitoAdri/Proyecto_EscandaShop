<x-admin-layout title="Dashboard">

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Vista General</h1>
            <p class="admin-page-subtitle">Bienvenido al panel de control de EscandaShop.</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="admin-stats-grid">
        <!-- Clientes -->
        <div class="admin-stat-card">
            <div class="admin-stat-card-header">
                <span class="admin-stat-label">Clientes</span>
                <svg class="admin-stat-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <p class="admin-stat-value">{{ $totalClients }}</p>
        </div>

        <!-- Productos -->
        <div class="admin-stat-card">
            <div class="admin-stat-card-header">
                <span class="admin-stat-label">Productos</span>
                <svg class="admin-stat-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
            <p class="admin-stat-value">{{ $totalProducts }}</p>
        </div>

        <!-- Ingresos -->
        <div class="admin-stat-card">
            <div class="admin-stat-card-header">
                <span class="admin-stat-label">Ingresos</span>
                <svg class="admin-stat-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="admin-stat-value">{{ number_format($totalRevenue, 2, ',', '.') }} €</p>
            <p class="admin-stat-sub">{{ $totalOrders }} pedidos totales</p>
        </div>

        <!-- Alerta de Stock -->
        <div class="admin-stat-card">
            <div class="admin-stat-card-header">
                <span class="admin-stat-label">Alerta de Stock</span>
                <svg class="admin-stat-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
            <p class="admin-stat-value">{{ $lowStockCount }}</p>
            <p class="admin-stat-sub">Productos con menos de 5 u.</p>
        </div>
    </div>

    <!-- Bottom Grid: Orders + Actions -->
    <div class="admin-bottom-grid">
        <!-- Últimos Pedidos -->
        <div class="admin-panel">
            <div class="admin-panel-header">
                <span class="admin-panel-title">Últimos Pedidos</span>
                <a href="#" class="admin-panel-link">Ver todos →</a>
            </div>

            @forelse($latestOrders as $order)
                <div class="admin-order-item">
                    <div>
                        <p class="admin-order-id">ES-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                        <p class="admin-order-meta">{{ $order->user->name ?? 'Cliente' }} · {{ $order->created_at->diffForHumans() }}</p>
                    </div>
                    <div>
                        <p class="admin-order-price">{{ number_format($order->total_price, 2, ',', '.') }} €</p>
                        <span class="admin-badge 
                            @if($order->status === 'pending') admin-badge-pending
                            @elseif($order->status === 'completed') admin-badge-completed
                            @else admin-badge-cancelled
                            @endif">
                            {{ $order->status === 'pending' ? 'Pendiente' : ($order->status === 'completed' ? 'Completado' : ucfirst($order->status)) }}
                        </span>
                    </div>
                </div>
            @empty
                <p style="color: var(--admin-text-muted); font-size: 14px; padding: 20px 0;">No hay pedidos registrados aún.</p>
            @endforelse
        </div>

        <!-- Acciones Rápidas -->
        <div class="admin-panel">
            <div class="admin-panel-header">
                <span class="admin-panel-title">Acciones Rápidas</span>
            </div>

            <a href="{{ route('admin.products', ['action' => 'create']) }}" class="admin-action-item">
                <div class="admin-action-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/></svg>
                </div>
                <div>
                    <p class="admin-action-label">Nuevo Producto</p>
                    <p class="admin-action-sub">Añadir joya al catálogo</p>
                </div>
            </a>

            <a href="{{ route('admin.orders', ['status' => 'pending']) }}" class="admin-action-item {{ $pendingOrders > 0 ? 'highlighted' : '' }}">
                <div class="admin-action-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                </div>
                <div>
                    <p class="admin-action-label">Pedidos Pendientes</p>
                    <p class="admin-action-sub {{ $pendingOrders > 0 ? 'warning' : '' }}">
                        {{ $pendingOrders }} esperando envío
                    </p>
                </div>
            </a>

            <a href="{{ route('admin.settings') }}" class="admin-action-item">
                <div class="admin-action-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <p class="admin-action-label">Ajustes Tienda</p>
                    <p class="admin-action-sub">Textos y productos destacados</p>
                </div>
            </a>
        </div>
    </div>

</x-admin-layout>
