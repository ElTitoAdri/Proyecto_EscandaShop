<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PageController;

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
});

// Admin Routes Example
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard'); // Podemos cambiarlo por "admin.dashboard" cuando creemos la vista
    })->name('dashboard');
});

require __DIR__ . '/auth.php';
