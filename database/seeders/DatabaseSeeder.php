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

        // 2. Create 4 Categories
        $categories = \App\Models\Category::factory(4)->create();

        // 3. Create 4 Products (one for each category)
        $products = collect();
        foreach ($categories as $category) {
            $products->push(\App\Models\Product::factory()->create(['category_id' => $category->id]));
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
