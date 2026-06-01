<x-layouts.admin title="Reseñas">

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Gestión de Reseñas</h1>
            <p class="admin-page-subtitle">Modera y analiza las opiniones y valoraciones de tus clientes.</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="admin-stats-grid">
        <!-- Total Reseñas -->
        <div class="admin-stat-card">
            <div class="admin-stat-card-header">
                <span class="admin-stat-label">Total Reseñas</span>
                <svg class="admin-stat-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                </svg>
            </div>
            <p class="admin-stat-value">{{ $totalReviews }}</p>
            <p class="admin-stat-sub">Opiniones recibidas</p>
        </div>

        <!-- Valoración Media -->
        <div class="admin-stat-card">
            <div class="admin-stat-card-header">
                <span class="admin-stat-label">Valoración Media</span>
                <svg class="admin-stat-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.907c.961 0 1.36 1.242.588 1.81l-3.97 2.883a1 1 0 00-.364 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.97-2.883a1 1 0 00-1.176 0l-3.97 2.883c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.364-1.118l-3.97-2.883c-.773-.568-.375-1.81.588-1.81h4.907a1 1 0 00.95-.69l1.519-4.674z"/>
                </svg>
            </div>
            <p class="admin-stat-value">{{ number_format($averageRating, 1, ',', '.') }} <span style="font-size: 16px; color: var(--admin-text-muted);">/ 5</span></p>
            <div style="display: flex; gap: 4px; align-items: center; margin-top: 8px;">
                @php $avg = round($averageRating); @endphp
                @for($i = 1; $i <= 5; $i++)
                    <svg style="width: 14px; height: 14px; color: {{ $i <= $avg ? 'var(--admin-gold)' : 'var(--admin-border)' }}; fill: currentColor;" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                @endfor
            </div>
        </div>

        <!-- Aprobadas -->
        <div class="admin-stat-card">
            <div class="admin-stat-card-header">
                <span class="admin-stat-label">Aprobadas</span>
                <svg class="admin-stat-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="admin-stat-value">{{ $approvedCount }}</p>
            <p class="admin-stat-sub">Visibles en tienda</p>
        </div>

        <!-- Ocultas -->
        <div class="admin-stat-card">
            <div class="admin-stat-card-header">
                <span class="admin-stat-label">Ocultas / Mod.</span>
                <svg class="admin-stat-icon" style="color: var(--admin-charcoal);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                </svg>
            </div>
            <p class="admin-stat-value">{{ $pendingCount }}</p>
            <p class="admin-stat-sub">Moderadas o pendientes</p>
        </div>
    </div>

    <!-- Panel Table -->
    <div class="admin-panel" style="padding: 0;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Producto</th>
                    <th>Valoración</th>
                    <th>Comentario</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 36px; height: 36px; border-radius: 50%; background: #FAF9F7; border: 1px solid var(--admin-border); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <span style="font-size: 13px; font-weight: 700; color: var(--admin-charcoal);">
                                        {{ strtoupper(substr($review->user->name ?? 'C', 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <p style="font-weight: 600; font-size: 13px; margin: 0;">{{ Str::limit($review->user->name ?? 'Cliente', 22) }}</p>
                                    <p style="font-size: 11px; color: var(--admin-text-muted); margin: 0;">{{ Str::limit($review->user->email ?? 'Sin email', 25) }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span style="font-weight: 600; color: var(--admin-charcoal);">
                                {{ Str::limit($review->product->name ?? 'Producto Eliminado', 30) }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 2px;">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <svg style="width: 14px; height: 14px; color: var(--admin-gold); fill: currentColor;" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @else
                                        <svg style="width: 14px; height: 14px; color: var(--admin-border); fill: currentColor;" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                        </td>
                        <td>
                            <p style="color: var(--admin-text-muted); font-size: 13px; margin: 0; max-width: 320px; word-wrap: break-word;" title="{{ $review->comment }}">
                                {{ Str::limit($review->comment, 80) }}
                            </p>
                        </td>
                        <td>
                            <div style="color: var(--admin-text-muted); font-size: 12px;">
                                {{ $review->created_at->format('d/m/Y') }}<br>
                                <span style="font-size: 11px; opacity: 0.7;">{{ $review->created_at->format('H:i') }}</span>
                            </div>
                        </td>
                        <td>
                            @if($review->is_approved)
                                <span class="admin-badge admin-badge-completed">Aprobada</span>
                            @else
                                <span class="admin-badge admin-badge-pending">Oculta</span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                <form method="POST" action="{{ route('admin.reviews.toggle-approval', $review) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" style="background: none; border: none; color: var(--admin-charcoal); font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; cursor: pointer; padding: 6px 10px; border-radius: 6px; transition: background 0.2s;"
                                            onmouseover="this.style.background='var(--admin-sidebar-hover)'" onmouseout="this.style.background='none'">
                                        {{ $review->is_approved ? 'Ocultar' : 'Aprobar' }}
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" style="display: inline;" onsubmit="return confirm('¿Seguro que deseas eliminar esta reseña permanentemente?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: none; border: none; color: #DC2626; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; cursor: pointer; padding: 6px 10px; border-radius: 6px; transition: background 0.2s;"
                                            onmouseover="this.style.background='#FEE2E2'" onmouseout="this.style.background='none'">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: var(--admin-text-muted);">
                            No hay reseñas registradas aún.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-layouts.admin>
