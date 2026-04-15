<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $categories = Category::all();
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        
        return view('cart.index', compact('cart', 'total', 'categories'));
    }

    public function add(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);
        $quantity = $request->input('quantity', 1);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $primaryImage = $product->images->where('is_primary', true)->first() ?? $product->images->first();
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->price,
                "image" => $primaryImage ? $primaryImage->url : 'https://placehold.co/600x600?text=' . urlencode($product->name),
                "slug" => $product->slug
            ];
        }

        session()->put('cart', $cart);

        // Persistencia en DB si está logueado
        if (auth()->check()) {
            $cartItem = auth()->user()->cartItems()->where('product_id', $product->id)->first();
            if ($cartItem) {
                $cartItem->increment('quantity', $quantity);
            } else {
                auth()->user()->cartItems()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity
                ]);
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Producto añadido al carrito',
                'cart_count' => count($cart)
            ]);
        }

        return redirect()->back()->with('success', 'Producto añadido al carrito');
    }

    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);

                // Eliminar de DB si está logueado
                if (auth()->check()) {
                    auth()->user()->cartItems()->where('product_id', $request->id)->delete();
                }
            }
            session()->flash('success', 'Producto eliminado');
        }
        
        return redirect()->route('cart.index');
    }

    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);

            // Actualizar en DB si está logueado
            if (auth()->check()) {
                auth()->user()->cartItems()->where('product_id', $request->id)->update([
                    'quantity' => $request->quantity
                ]);
            }

            session()->flash('success', 'Carrito actualizado');
        }
        
        return redirect()->route('cart.index');
    }
}
