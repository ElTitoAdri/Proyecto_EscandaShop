<x-layouts.admin title="Productos">

    <div x-data="{
        showCreateModal: {{ (request('action') === 'create' || $errors->any()) ? 'true' : 'false' }},
        showEditModal: false,
        editProduct: {
            id: '',
            name: '',
            category_id: '',
            description: '',
            price: '',
            stock: '',
            is_visible: true,
            image_url: ''
        },
        openEditModal(product) {
            this.editProduct = {
                id: product.id,
                name: product.name,
                category_id: product.category_id,
                description: product.description || '',
                price: product.price,
                stock: product.stock,
                is_visible: !!product.is_visible,
                image_url: product.images && product.images[0] ? product.images[0].url : ''
            };
            this.showEditModal = true;
        }
    }">

        <div class="admin-page-header">
            <div>
                <h1 class="admin-page-title">Productos</h1>
                <p class="admin-page-subtitle">Gestiona el catálogo de tu tienda.</p>
            </div>
            <button type="button" @click="showCreateModal = true" class="admin-btn-primary">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nuevo Producto
            </button>
        </div>

        @if(session('success'))
            <div style="background: #D1FAE5; border: 1px solid #A7F3D0; color: #065F46; padding: 12px 20px; border-radius: 8px; margin-bottom: 24px; font-size: 13px; font-weight: 500;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background: #FEE2E2; border: 1px solid #FCA5A5; color: #991B1B; padding: 12px 20px; border-radius: 8px; margin-bottom: 24px; font-size: 13px; font-weight: 500;">
                <strong>Error al procesar el producto:</strong>
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
                        <th style="width: 30%;">Producto</th>
                        <th>SKU</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th style="text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    @if($product->images->first())
                                        @php
                                            $imgUrl = $product->images->first()->url;
                                        @endphp
                                        <img src="{{ Str::startsWith($imgUrl, ['http://', 'https://']) ? $imgUrl : asset('storage/' . $imgUrl) }}" 
                                             alt="{{ $product->name }}"
                                             style="width: 40px; height: 40px; object-fit: cover; border-radius: 6px; border: 1px solid var(--admin-border);">
                                    @else
                                        <div style="width: 40px; height: 40px; border-radius: 6px; background: #F0EDE8; border: 1px solid var(--admin-border);"></div>
                                    @endif
                                    <span class="admin-product-name">{{ $product->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="admin-product-sku">ESC-{{ strtoupper($product->category->slug ?? 'GEN') }}-{{ str_pad($product->id, 3, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td>{{ $product->category->name ?? '—' }}</td>
                            <td style="font-weight: 600;">{{ number_format($product->price, 2, ',', '.') }} €</td>
                            <td>
                                <span class="admin-stock-badge 
                                    @if($product->stock <= 0) admin-stock-out
                                    @elseif($product->stock < 5) admin-stock-low
                                    @else admin-stock-ok
                                    @endif">
                                    {{ $product->stock }} un.
                                </span>
                            </td>
                            <td>
                                <div class="admin-table-actions" style="justify-content: flex-end;">
                                    <form action="{{ route('admin.products.toggle-visibility', $product) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" title="{{ $product->is_visible ? 'Ocultar producto' : 'Mostrar producto' }}" class="{{ $product->is_visible ? 'star-active' : '' }}">
                                            <svg fill="{{ $product->is_visible ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                        </button>
                                    </form>
                                    <button type="button" @click="openEditModal({{ json_encode($product->load('images')) }})" title="Editar">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto?')">
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
                            <td colspan="6" style="text-align: center; padding: 40px; color: var(--admin-text-muted);">
                                No hay productos en el catálogo.
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
                    <h2 class="modal-title">Nuevo Producto</h2>
                    <button class="modal-close" @click="showCreateModal = false">
                        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">Nombre del Producto</label>
                            <input type="text" name="name" required class="form-control" placeholder="Ej: Anillo de Oro con Diamante">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Categoría</label>
                                <select name="category_id" required class="form-control">
                                    <option value="" disabled selected>Selecciona categoría...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Visibilidad / Destacado</label>
                                <div style="margin-top: 10px;">
                                    <label class="switch-container">
                                        <input type="checkbox" name="is_visible" checked class="switch-input">
                                        <span class="switch-slider"></span>
                                        <span style="font-size: 13px; color: var(--admin-text); font-weight: 500;">Visible en la tienda</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Precio (€)</label>
                                <input type="number" name="price" step="0.01" min="0" required class="form-control" placeholder="Ej: 250.00">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Stock inicial</label>
                                <input type="number" name="stock" min="0" required class="form-control" placeholder="Ej: 10">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Descripción</label>
                            <textarea name="description" rows="4" required class="form-control" placeholder="Describe los materiales, dimensiones, peso..."></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Subir Imagen del Producto</label>
                            <input type="file" name="image" accept="image/*" class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="form-label">O ingresar URL de la imagen (Alternativa)</label>
                            <input type="url" name="image_url" class="form-control" placeholder="https://example.com/imagen.jpg">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="showCreateModal = false" class="admin-btn-secondary">Cancelar</button>
                        <button type="submit" class="admin-btn-primary">Crear Producto</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- EDIT MODAL -->
        <div class="modal-overlay" x-show="showEditModal" style="display: none;" x-transition>
            <div class="modal-container" @click.away="showEditModal = false">
                <div class="modal-header">
                    <h2 class="modal-title">Editar Producto</h2>
                    <button class="modal-close" @click="showEditModal = false">
                        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>
                <form :action="`{{ url('/admin/productos') }}/${editProduct.id}`" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">Nombre del Producto</label>
                            <input type="text" name="name" x-model="editProduct.name" required class="form-control">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Categoría</label>
                                <select name="category_id" x-model="editProduct.category_id" required class="form-control">
                                    <option value="" disabled>Selecciona categoría...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Visibilidad / Destacado</label>
                                <div style="margin-top: 10px;">
                                    <label class="switch-container">
                                        <input type="checkbox" name="is_visible" x-model="editProduct.is_visible" class="switch-input">
                                        <span class="switch-slider"></span>
                                        <span style="font-size: 13px; color: var(--admin-text); font-weight: 500;">Visible en la tienda</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Precio (€)</label>
                                <input type="number" name="price" step="0.01" min="0" x-model="editProduct.price" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Stock disponible</label>
                                <input type="number" name="stock" min="0" x-model="editProduct.stock" required class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Descripción</label>
                            <textarea name="description" rows="4" x-model="editProduct.description" required class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Cambiar Imagen del Producto (Opcional)</label>
                            <input type="file" name="image" accept="image/*" class="form-control">
                            <p style="font-size: 11px; color: var(--admin-text-muted); margin-top: 4px;">Dejar vacío para conservar la imagen actual.</p>
                        </div>

                        <div class="form-group">
                            <label class="form-label">O cambiar URL de la imagen</label>
                            <input type="url" name="image_url" x-model="editProduct.image_url" class="form-control">
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

</x-layouts.admin>
