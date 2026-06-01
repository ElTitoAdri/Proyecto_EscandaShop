<?php

use Xammie\Mailbook\Facades\Mailbook;

// 1. Correo de Bienvenida
Mailbook::add(function () {
    $user = \App\Models\User::firstOrCreate(
        ['email' => 'adrian@escandashop.com'],
        [
            'name' => 'Adrián Escanda',
            'password' => bcrypt('password'),
        ]
    );
    return new \App\Mail\WelcomeNewUser($user);
});

// 2. Correo de Confirmación de Compra (Factura)
Mailbook::add(function () {
    $user = \App\Models\User::factory()->create(['name' => 'Adrián Escanda']);
    $category = \App\Models\Category::firstOrCreate(
        ['slug' => 'anillos'],
        ['name' => 'Anillos']
    );
    $product = \App\Models\Product::firstOrCreate(
        ['slug' => 'anillo-oro-imperial'],
        [
            'name' => 'Anillo de Oro Imperial',
            'description' => 'Un anillo majestuoso.',
            'price' => 299.99,
            'stock' => 10,
            'category_id' => $category->id,
        ]
    );
    $order = \App\Models\Order::create([
        'user_id' => $user->id,
        'total_price' => 299.99,
        'status' => 'paid',
        'shipping_address' => 'Avenida Diagonal 45, Barcelona',
        'payment_id' => 'cs_test_' . uniqid(),
    ]);
    \App\Models\OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'quantity' => 1,
        'price_at_purchase' => 299.99
    ]);
    
    return new \App\Mail\OrderConfirmed($order->load('items.product', 'user'));
});

// 3. Correo de Cambio de Estado / Seguimiento (Con Variantes)
Mailbook::add(function () {
    $user = \App\Models\User::factory()->create(['name' => 'Adrián Escanda']);
    $order = \App\Models\Order::create([
        'user_id' => $user->id,
        'total_price' => 150.00,
        'status' => 'shipped',
        'shipping_address' => 'Calle Gran Vía 12, Madrid',
        'payment_id' => 'ch_test_' . uniqid(),
    ]);
    return new \App\Mail\OrderStatusUpdated($order->load('user'));
})
->variant('En camino 🚚', function () {
    $user = \App\Models\User::factory()->create(['name' => 'Adrián Escanda']);
    $order = \App\Models\Order::create([
        'user_id' => $user->id,
        'total_price' => 150.00,
        'status' => 'shipped',
        'shipping_address' => 'Calle Gran Vía 12, Madrid',
        'payment_id' => 'ch_test_' . uniqid(),
    ]);
    return new \App\Mail\OrderStatusUpdated($order->load('user'));
})
->variant('Entregado 🎉', function () {
    $user = \App\Models\User::factory()->create(['name' => 'Adrián Escanda']);
    $order = \App\Models\Order::create([
        'user_id' => $user->id,
        'total_price' => 150.00,
        'status' => 'completed',
        'shipping_address' => 'Calle Gran Vía 12, Madrid',
        'payment_id' => 'ch_test_' . uniqid(),
    ]);
    return new \App\Mail\OrderStatusUpdated($order->load('user'));
})
->variant('Cancelado ❌', function () {
    $user = \App\Models\User::factory()->create(['name' => 'Adrián Escanda']);
    $order = \App\Models\Order::create([
        'user_id' => $user->id,
        'total_price' => 150.00,
        'status' => 'cancelled',
        'shipping_address' => 'Calle Gran Vía 12, Madrid',
        'payment_id' => 'ch_test_' . uniqid(),
    ]);
    return new \App\Mail\OrderStatusUpdated($order->load('user'));
});

// 4. Correo de Auto-respuesta de Soporte
Mailbook::add(function () {
    return new \App\Mail\ContactSupportAutoReply(
        'Sofía Joyas',
        'Consulta sobre stock de pendientes',
        "Hola, me gustaría saber si volverán a tener en stock el modelo de pendientes dorados.\nMuchas gracias."
    );
});
