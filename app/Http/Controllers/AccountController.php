<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Muestra la pantalla principal del panel de cliente.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Obtenemos las categorías para el menú de navegación
        $categories = Category::orderBy('name')->get();
        
        // Obtenemos los pedidos del usuario
        $orders = $user->orders()
            ->with(['items.product.images'])
            ->latest()
            ->get();

        return view('account.index', compact('user', 'orders', 'categories'));
    }

    /**
     * Muestra el detalle específico de un pedido del usuario.
     */
    public function showOrder(Order $order)
    {
        // Validamos de forma segura que el pedido pertenezca al usuario logueado
        if ($order->user_id !== Auth::id()) {
            abort(403, 'No tienes permisos para ver este pedido.');
        }

        // Obtenemos las categorías para el menú de navegación
        $categories = Category::orderBy('name')->get();

        // Cargamos los artículos del pedido y sus respectivos productos con imágenes
        $order->load(['items.product.images']);

        return view('account.order_show', compact('order', 'categories'));
    }
}
