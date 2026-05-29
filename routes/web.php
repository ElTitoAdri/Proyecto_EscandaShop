<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AccountController;

Route::get('/', [PageController::class, 'about'])->name('home');
Route::get('/tienda', [CatalogController::class, 'index'])->name('store.index');

Route::get('/productos/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// Cart Routes
Route::get('/carrito', [CartController::class, 'index'])->name('cart.index');
Route::post('/carrito/añadir/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/carrito/actualizar', [CartController::class, 'update'])->name('cart.update');
Route::delete('/carrito/eliminar', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Checkout Routes
    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'checkout'])->name('checkout.index');
    Route::get('/checkout/success', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/cancel', [App\Http\Controllers\CheckoutController::class, 'cancel'])->name('checkout.cancel');

    // Rutas del Área "Mi Cuenta"
    Route::get('/mi-cuenta', [AccountController::class, 'index'])->name('account.index');
    Route::get('/mi-cuenta/pedidos/{order}', [AccountController::class, 'showOrder'])->name('account.orders.show');

    // Rutas de Reseñas de Productos
    Route::post('/productos/{product}/reseñas', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/productos', [AdminController::class, 'products'])->name('products');
    Route::post('/productos', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::put('/productos/{product}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/productos/{product}', [AdminController::class, 'destroyProduct'])->name('products.destroy');
    Route::post('/productos/{product}/toggle-visibility', [AdminController::class, 'toggleProductVisibility'])->name('products.toggle-visibility');
    Route::get('/categorias', [AdminController::class, 'categories'])->name('categories');
    Route::post('/categorias', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categorias/{category}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categorias/{category}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');
    Route::get('/pedidos', [AdminController::class, 'orders'])->name('orders');
    Route::get('/usuarios', [AdminController::class, 'users'])->name('users');
    Route::get('/mensajes', [AdminController::class, 'messages'])->name('messages');
    Route::delete('/mensajes/{message}', [AdminController::class, 'destroyMessage'])->name('messages.destroy');
    Route::get('/reseñas', [AdminController::class, 'reviews'])->name('reviews');
    Route::post('/reseñas/{review}/toggle-approval', [AdminController::class, 'toggleReviewApproval'])->name('reviews.toggle-approval');
    Route::delete('/reseñas/{review}', [AdminController::class, 'destroyReview'])->name('reviews.destroy');
    Route::get('/ajustes', [AdminController::class, 'settings'])->name('settings');
    Route::post('/ajustes', [AdminController::class, 'updateSettings'])->name('settings.update');
});

require __DIR__ . '/auth.php';
