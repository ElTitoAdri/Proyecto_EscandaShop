<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin' }} | EscandaShop</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Inter:wght@100..900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --admin-sidebar-width: 220px;
            --admin-gold: #C9A96E;
            --admin-gold-light: #D4B87A;
            --admin-charcoal: #5D574F;
            --admin-bg: #FAFAF8;
            --admin-border: #E8E5E0;
            --admin-text: #333333;
            --admin-text-muted: #8C8680;
            --admin-white: #FFFFFF;
            --admin-sidebar-bg: #FAFAF8;
            --admin-sidebar-hover: #F0EDE8;
            --admin-sidebar-active-bg: var(--admin-charcoal);
            --admin-sidebar-active-text: #FFFFFF;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--admin-bg);
            color: var(--admin-text);
            margin: 0;
        }

        /* ── Sidebar ── */
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--admin-sidebar-width);
            height: 100vh;
            background: var(--admin-sidebar-bg);
            border-right: 1px solid var(--admin-border);
            display: flex;
            flex-direction: column;
            z-index: 40;
        }

        .admin-sidebar-brand {
            padding: 28px 24px 8px;
        }

        .admin-sidebar-brand h1 {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: var(--admin-charcoal);
            margin: 0;
        }

        .admin-sidebar-brand span {
            font-family: 'Inter', sans-serif;
            font-size: 10px;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--admin-text-muted);
            display: block;
            margin-top: 4px;
        }

        .admin-sidebar-nav {
            flex: 1;
            padding: 24px 12px;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .admin-sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            color: var(--admin-text-muted);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .admin-sidebar-link:hover {
            color: var(--admin-text);
            background: var(--admin-sidebar-hover);
        }

        .admin-sidebar-link.active {
            background: var(--admin-sidebar-active-bg);
            color: var(--admin-sidebar-active-text);
        }

        .admin-sidebar-link svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .admin-sidebar-bottom {
            padding: 16px 12px;
            border-top: 1px solid var(--admin-border);
        }

        .admin-sidebar-bottom a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 500;
            color: var(--admin-text-muted);
            text-decoration: none;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            transition: all 0.2s ease;
        }

        .admin-sidebar-bottom a:hover {
            color: var(--admin-text);
            background: var(--admin-sidebar-hover);
        }

        /* ── Main Content ── */
        .admin-main {
            margin-left: var(--admin-sidebar-width);
            min-height: 100vh;
        }

        .admin-topbar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 16px 40px;
            border-bottom: 1px solid var(--admin-border);
            background: var(--admin-white);
        }

        .admin-topbar-user {
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: var(--admin-charcoal);
        }

        .admin-content {
            padding: 40px;
        }

        /* ── Stats Cards ── */
        .admin-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 32px;
        }

        .admin-stat-card {
            background: var(--admin-white);
            border: 1px solid var(--admin-border);
            border-radius: 12px;
            padding: 24px;
            position: relative;
        }

        .admin-stat-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .admin-stat-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--admin-text-muted);
        }

        .admin-stat-icon {
            width: 24px;
            height: 24px;
            color: var(--admin-gold);
        }

        .admin-stat-value {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            font-weight: 400;
            color: var(--admin-text);
            margin: 0;
            line-height: 1;
        }

        .admin-stat-sub {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--admin-gold);
            margin-top: 8px;
        }

        /* ── Cards/Panels ── */
        .admin-panel {
            background: var(--admin-white);
            border: 1px solid var(--admin-border);
            border-radius: 12px;
            padding: 24px;
        }

        .admin-panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .admin-panel-title {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--admin-text-muted);
        }

        .admin-panel-link {
            font-size: 11px;
            font-weight: 600;
            color: var(--admin-text-muted);
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: color 0.2s;
        }

        .admin-panel-link:hover {
            color: var(--admin-gold);
        }

        /* ── Orders List ── */
        .admin-order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 0;
            border-bottom: 1px solid var(--admin-border);
        }

        .admin-order-item:last-child {
            border-bottom: none;
        }

        .admin-order-id {
            font-size: 14px;
            font-weight: 600;
            color: var(--admin-text);
        }

        .admin-order-meta {
            font-size: 12px;
            color: var(--admin-text-muted);
            margin-top: 2px;
        }

        .admin-order-price {
            font-size: 16px;
            font-weight: 600;
            color: var(--admin-text);
            text-align: right;
        }

        .admin-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .admin-badge-pending {
            background: #FEF3C7;
            color: #92400E;
        }

        .admin-badge-completed {
            background: #D1FAE5;
            color: #065F46;
        }

        .admin-badge-cancelled {
            background: #FEE2E2;
            color: #991B1B;
        }

        /* ── Quick Actions ── */
        .admin-action-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 16px;
            border-radius: 10px;
            text-decoration: none;
            color: var(--admin-text);
            transition: background 0.2s;
        }

        .admin-action-item:hover {
            background: var(--admin-sidebar-hover);
        }

        .admin-action-item.highlighted {
            background: #FEF3C7;
        }

        .admin-action-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .admin-action-icon svg {
            width: 18px;
            height: 18px;
        }

        .admin-action-label {
            font-size: 13px;
            font-weight: 600;
        }

        .admin-action-sub {
            font-size: 11px;
            color: var(--admin-text-muted);
        }

        .admin-action-sub.warning {
            color: #DC2626;
        }

        /* ── Products Table ── */
        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }

        .admin-table thead th {
            text-align: left;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--admin-text-muted);
            padding: 14px 16px;
            border-bottom: 1px solid var(--admin-border);
        }

        .admin-table tbody tr {
            border-bottom: 1px solid var(--admin-border);
            transition: background 0.15s;
        }

        .admin-table tbody tr:hover {
            background: #FAF9F7;
        }

        .admin-table tbody tr:last-child {
            border-bottom: none;
        }

        .admin-table tbody td {
            padding: 16px;
            font-size: 14px;
            vertical-align: middle;
        }

        .admin-product-name {
            font-weight: 600;
            color: var(--admin-text);
        }

        .admin-product-sku {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            color: var(--admin-text-muted);
        }

        .admin-stock-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        .admin-stock-ok {
            background: #D1FAE5;
            color: #065F46;
        }

        .admin-stock-low {
            background: #FEF3C7;
            color: #92400E;
        }

        .admin-stock-out {
            background: #FEE2E2;
            color: #991B1B;
        }

        .admin-table-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .admin-table-actions button,
        .admin-table-actions a {
            background: none;
            border: none;
            padding: 6px;
            border-radius: 6px;
            cursor: pointer;
            color: var(--admin-text-muted);
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .admin-table-actions button:hover,
        .admin-table-actions a:hover {
            background: var(--admin-sidebar-hover);
            color: var(--admin-text);
        }

        .admin-table-actions .star-active {
            color: var(--admin-gold);
        }

        .admin-table-actions svg {
            width: 16px;
            height: 16px;
        }

        /* ── Buttons ── */
        .admin-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: var(--admin-charcoal);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .admin-btn-primary:hover {
            background: #4A453E;
        }

        .admin-btn-primary svg {
            width: 16px;
            height: 16px;
        }

        /* ── Page Header ── */
        .admin-page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 32px;
        }

        .admin-page-title {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 400;
            margin: 0 0 4px;
        }

        .admin-page-subtitle {
            font-size: 14px;
            color: var(--admin-text-muted);
        }

        /* ── Bottom Grid ── */
        .admin-bottom-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 20px;
        }

        /* ── Responsive ── */
        @media (max-width: 1024px) {
            .admin-stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .admin-bottom-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="admin-sidebar-brand">
            <h1>Escanda</h1>
            <span>Admin</span>
        </div>

        <nav class="admin-sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="admin-sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                Dashboard
            </a>
            <a href="{{ route('admin.products') }}" class="admin-sidebar-link {{ request()->routeIs('admin.products') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                Productos
            </a>
            <a href="{{ route('admin.categories') }}" class="admin-sidebar-link {{ request()->routeIs('admin.categories') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                Categorías
            </a>
            <a href="{{ route('admin.orders') }}" class="admin-sidebar-link {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Pedidos
            </a>
            <a href="{{ route('admin.users') }}" class="admin-sidebar-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Usuarios
            </a>
            <a href="{{ route('admin.messages') }}" class="admin-sidebar-link {{ request()->routeIs('admin.messages') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Mensajes
            </a>
            <a href="{{ route('admin.settings') }}" class="admin-sidebar-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Ajustes
            </a>
        </nav>

        <div class="admin-sidebar-bottom">
            <a href="{{ route('store.index') }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Volver a la tienda
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="admin-main">
        <header class="admin-topbar">
            <span class="admin-topbar-user">Admin {{ Auth::user()->name ?? 'Escanda' }}</span>
        </header>

        <div class="admin-content">
            {{ $slot }}
        </div>
    </div>

</body>
</html>
