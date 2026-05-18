<x-admin-layout title="Categorías">

    <style>
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(93, 87, 79, 0.4);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 100;
        }
        .modal-container {
            background: var(--admin-white);
            border: 1px solid var(--admin-border);
            border-radius: 16px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
            overflow: hidden;
            animation: modalFadeIn 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--admin-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #FAF9F7;
        }
        .modal-title {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 500;
            color: var(--admin-charcoal);
            margin: 0;
        }
        .modal-close {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--admin-text-muted);
            padding: 4px;
            border-radius: 6px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-close:hover {
            background: var(--admin-sidebar-hover);
            color: var(--admin-text);
        }
        .modal-body {
            padding: 24px;
            max-height: calc(100vh - 200px);
            overflow-y: auto;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            display: block;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--admin-text-muted);
            margin-bottom: 8px;
        }
        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--admin-border);
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            color: var(--admin-text);
            background: var(--admin-white);
            outline: none;
            transition: border-color 0.2s;
            box-sizing: border-box;
        }
        .form-control:focus {
            border-color: var(--admin-charcoal);
        }
        .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--admin-border);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            background: #FAF9F7;
        }
        .admin-btn-secondary {
            display: inline-flex;
            align-items: center;
            padding: 12px 24px;
            background: transparent;
            color: var(--admin-charcoal);
            border: 1px solid var(--admin-border);
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }
        .admin-btn-secondary:hover {
            background: var(--admin-sidebar-hover);
        }
    </style>

    <div x-data="{
        showCreateModal: {{ $errors->any() ? 'true' : 'false' }},
        showEditModal: false,
        editCategory: {
            id: '',
            name: '',
            description: ''
        },
        openEditModal(category) {
            this.editCategory = {
                id: category.id,
                name: category.name,
                description: category.description || ''
            };
            this.showEditModal = true;
        }
    }">

        <div class="admin-page-header">
            <div>
                <h1 class="admin-page-title">Categorías</h1>
                <p class="admin-page-subtitle">Organiza y agrupa tus productos.</p>
            </div>
            <button type="button" @click="showCreateModal = true" class="admin-btn-primary">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nueva Categoría
            </button>
        </div>

        @if(session('success'))
            <div style="background: #D1FAE5; border: 1px solid #A7F3D0; color: #065F46; padding: 12px 20px; border-radius: 8px; margin-bottom: 24px; font-size: 13px; font-weight: 500;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background: #FEE2E2; border: 1px solid #FCA5A5; color: #991B1B; padding: 12px 20px; border-radius: 8px; margin-bottom: 24px; font-size: 13px; font-weight: 500;">
                <strong>Error al guardar la categoría:</strong>
                <ul style="margin: 8px 0 0 16px; padding: 0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="admin-panel" style="padding: 0;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 25%;">Nombre</th>
                        <th>URL (Slug)</th>
                        <th>Productos Asociados</th>
                        <th style="text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>
                                <span class="admin-product-name">{{ $category->name }}</span>
                            </td>
                            <td>
                                <span class="admin-product-sku">/categoria/{{ $category->slug }}</span>
                            </td>
                            <td>
                                <span class="admin-stock-badge admin-stock-ok">
                                    {{ $category->products_count }} un.
                                </span>
                            </td>
                            <td>
                                <div class="admin-table-actions" style="justify-content: flex-end;">
                                    <button type="button" @click="openEditModal({{ json_encode($category) }})" title="Editar">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display: inline;" 
                                          onsubmit="return confirm('¿Estás seguro de que deseas eliminar la categoría &quot;{{ $category->name }}&quot;? Tienes {{ $category->products_count }} producto(s) asociado(s) en catálogo que se ELIMINARÁN permanentemente debido a la restricción en cascada.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Eliminar" style="color: #EF4444;">
                                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 40px; color: var(--admin-text-muted);">
                                No hay categorías registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- CREATE MODAL -->
        <div class="modal-overlay" x-show="showCreateModal" style="display: none;" x-transition>
            <div class="modal-container" @click.away="showCreateModal = false">
                <div class="modal-header">
                    <h2 class="modal-title">Nueva Categoría</h2>
                    <button class="modal-close" @click="showCreateModal = false">
                        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">Nombre de la Categoría</label>
                            <input type="text" name="name" required class="form-control" placeholder="Ej: Gargantillas, Relojes, Diademas...">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Descripción</label>
                            <textarea name="description" rows="4" class="form-control" placeholder="Describe los productos de esta categoría..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="showCreateModal = false" class="admin-btn-secondary">Cancelar</button>
                        <button type="submit" class="admin-btn-primary">Crear Categoría</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- EDIT MODAL -->
        <div class="modal-overlay" x-show="showEditModal" style="display: none;" x-transition>
            <div class="modal-container" @click.away="showEditModal = false">
                <div class="modal-header">
                    <h2 class="modal-title">Editar Categoría</h2>
                    <button class="modal-close" @click="showEditModal = false">
                        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>
                <form :action="`{{ url('/admin/categorias') }}/${editCategory.id}`" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">Nombre de la Categoría</label>
                            <input type="text" name="name" x-model="editCategory.name" required class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Descripción</label>
                            <textarea name="description" rows="4" x-model="editCategory.description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="showEditModal = false" class="admin-btn-secondary">Cancelar</button>
                        <button type="submit" class="admin-btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</x-admin-layout>
