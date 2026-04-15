<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create 4 Users
        $users = \App\Models\User::factory(4)->create();

        // 2. Create 4 Categories en español
        $categories = collect();
        $catData = [
            ['name' => 'Pendientes', 'slug' => 'pendientes', 'description' => 'Pendientes exclusivos de oro y plata.'],
            ['name' => 'Anillos', 'slug' => 'anillos', 'description' => 'Anillos de compromiso y diseño propio.'],
            ['name' => 'Pulseras', 'slug' => 'pulseras', 'description' => 'Pulseras artesanales y brazaletes.'],
            ['name' => 'Collares', 'slug' => 'collares', 'description' => 'Gargantillas y collares con diamantes.']
        ];
        foreach ($catData as $data) {
            $categories->push(\App\Models\Category::create($data));
        }

        // 3. Create 4 Products (one for each category)
        $products = collect();
        $prodNames = ['Pendientes Lágrima', 'Anillo Solitario', 'Pulsera Eslabones', 'Collar Perla Nacarada'];
        foreach ($categories as $i => $category) {
            $products->push(\App\Models\Product::factory()->create([
                'category_id' => $category->id,
                'name' => $prodNames[$i],
                'description' => 'Un espectacular diseño de ' . strtolower($prodNames[$i]) . ' fabricado y pulido a mano. Accesorio indispensable para ocasiones especiales.',
            ]));
        }

        // 4. Create 4 Product Images (one per product)
        foreach ($products as $product) {
            \App\Models\ProductImage::factory()->create(['product_id' => $product->id, 'is_primary' => true]);
        }

        // 5. Create 4 Orders (one per user)
        $orders = collect();
        foreach ($users as $user) {
            $orders->push(\App\Models\Order::factory()->create(['user_id' => $user->id]));
        }

        // 6. Create 4 Order Items (linked to orders and products)
        for ($i = 0; $i < 4; $i++) {
            \App\Models\OrderItem::factory()->create([
                'order_id' => $orders[$i]->id,
                'product_id' => $products[$i]->id,
            ]);
        }

        // 7. Create 4 Reviews
        for ($i = 0; $i < 4; $i++) {
            \App\Models\Review::factory()->create([
                'user_id' => $users[$i]->id,
                'product_id' => $products[$i]->id,
            ]);
        }

        // 8. Create 4 Messages
        \App\Models\Message::factory(4)->create();

        // Special test user
        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@escandashop.com',
            'role' => 'admin',
        ]);
    }
}
