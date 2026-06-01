<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $user = auth()->user();
        
        $lineItems = [];
        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if (!$product || $product->stock < $details['quantity']) {
                return redirect()->route('cart.index')->with('error', 'El producto ' . $details['name'] . ' ya no tiene stock suficiente.');
            }
            
            $lineItems[] = [
                'price_data' => [
                    'currency' => config('cashier.currency', 'eur'),
                    'product_data' => [
                        'name' => $details['name'],
                    ],
                    'unit_amount' => intval($details['price'] * 100),
                ],
                'quantity' => $details['quantity'],
            ];
        }

        // Generar la sesión de Stripe Checkout a través de Cashier
        return $user->checkout($lineItems, [
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel'),
        ]);
    }

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        if (!$sessionId) {
            return redirect()->route('store.index');
        }

        $user = auth()->user();
        $cart = session()->get('cart', []);
        $categories = \App\Models\Category::all();

        // Si recarga la página pero ya vació el carrito, simplemente muestra la vista de éxito
        if (empty($cart)) {
            return view('checkout.success', compact('categories')); 
        }

        try {
            DB::beginTransaction();

            $total = 0;
            foreach ($cart as $id => $details) {
                $total += $details['price'] * $details['quantity'];
            }

            // Crear el Pedido
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $total,
                'status' => 'paid',
                'shipping_address' => 'Dirección no especificada', // En un flujo real se pasaría desde un form
                'payment_id' => $sessionId,
            ]);

            // Crear las líneas de pedido y descontar stock
            foreach ($cart as $id => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $details['quantity'],
                    'price_at_purchase' => $details['price']
                ]);

                // Descontar stock
                $product = Product::find($id);
                if ($product) {
                    $product->decrement('stock', $details['quantity']);
                }
            }

            // Vaciar carrito (sesión y BD)
            session()->forget('cart');
            $user->cartItems()->delete();

            DB::commit();

            // Enviar email de confirmación
            try {
                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\OrderConfirmed($order));
            } catch (\Exception $mailEx) {
                \Illuminate\Support\Facades\Log::error("Error al enviar email de confirmación: " . $mailEx->getMessage());
            }

            return view('checkout.success', compact('order', 'categories'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'Error al procesar el pedido interno. Inténtalo de nuevo.');
        }
    }

    public function cancel()
    {
        $categories = \App\Models\Category::all();
        return view('checkout.cancel', compact('categories'));
    }
}
