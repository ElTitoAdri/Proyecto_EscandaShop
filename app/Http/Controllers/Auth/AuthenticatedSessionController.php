<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Persist Cart
        $this->mergeCart($request);

        return redirect()->intended('/');
    }

    protected function mergeCart(Request $request)
    {
        $user = Auth::user();
        $sessionCart = $request->session()->get('cart', []);

        if (!empty($sessionCart)) {
            foreach ($sessionCart as $productId => $details) {
                // Si el producto NO existe en la base de datos del usuario, lo añadimos
                if (!$user->cartItems()->where('product_id', $productId)->exists()) {
                    $user->cartItems()->create([
                        'product_id' => $productId,
                        'quantity' => $details['quantity']
                    ]);
                }
            }
            // Limpiamos la sesión después de la fusión para evitar duplicidad visual
            $request->session()->forget('cart');
        }

        // Cargamos el carrito de la DB a la sesión para que la UI lo vea
        $this->syncSessionWithDb($request, $user);
    }

    protected function syncSessionWithDb(Request $request, $user)
    {
        $dbCart = [];
        $cartItems = $user->cartItems()->with('product.images')->get();

        foreach ($cartItems as $item) {
            $product = $item->product;
            $primaryImage = $product->images->where('is_primary', true)->first() ?? $product->images->first();
            
            $dbCart[$product->id] = [
                "name" => $product->name,
                "quantity" => $item->quantity,
                "price" => $product->price,
                "image" => $primaryImage ? $primaryImage->url : 'https://placehold.co/600x600?text=' . urlencode($product->name),
                "slug" => $product->slug
            ];
        }

        $request->session()->put('cart', $dbCart);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
