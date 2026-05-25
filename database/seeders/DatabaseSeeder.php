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

        // 2. Create 3 Real Categories en español representing Escanda Shop
        $categories = collect();
        $catData = [
            [
                'name' => 'Joyería',
                'slug' => 'joyeria',
                'description' => 'Piezas exclusivas elaboradas en oro de 18k, plata de ley 925 y detalles de alta joyería.'
            ],
            [
                'name' => 'Bisutería',
                'slug' => 'bisuteria',
                'description' => 'Diseños artesanales, coloridos y con un toque único y bohemio para el día a día.'
            ],
            [
                'name' => 'Papelería',
                'slug' => 'papeleria',
                'description' => 'Libretas de cuero artesanal, agendas organizadoras, bolígrafos finos y washi tapes de diseño.'
            ]
        ];
        foreach ($catData as $data) {
            $categories->push(\App\Models\Category::create($data));
        }

        // 3. Define 12 Realistic products with high quality Unsplash images
        $productData = [
            // Joyería
            [
                'category_slug' => 'joyeria',
                'name' => 'Anillo de Oro Eternity',
                'description' => 'Un espectacular anillo de pavé bañado en oro de 18 quilates con circonitas brillantes de talla brillante. Diseñado y pulido a mano para aportar un toque de luz eterno en ocasiones especiales.',
                'price' => 149.99,
                'stock' => 15,
                'image_url' => 'https://images.unsplash.com/photo-1605100804763-247f67b3557e?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'joyeria',
                'name' => 'Collar de Plata Luna Nueva',
                'description' => 'Gargantilla minimalista de plata de ley 925 con un colgante redondo de luna creciente calada. Un diseño fino, elegante e ideal para lucir a diario o regalar.',
                'price' => 45.00,
                'stock' => 30,
                'image_url' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'joyeria',
                'name' => 'Pendientes Aro Clásicos',
                'description' => 'Pendientes de aro medianos chapados en oro amarillo de 14 quilates de alta resistencia. Un básico imprescindible de joyería, ligero y atemporal que combina con todo.',
                'price' => 79.99,
                'stock' => 20,
                'image_url' => 'https://images.unsplash.com/photo-1635767798638-3e25273a8236?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'joyeria',
                'name' => 'Pulsera de Plata Cadena',
                'description' => 'Pulsera fina de eslabones de plata de ley con cierre ajustable mosquetón y un pequeño charm central en forma de estrella de ocho puntas con micro-circonitas engastadas.',
                'price' => 39.99,
                'stock' => 25,
                'image_url' => 'https://images.unsplash.com/photo-1611591437281-460bfbe1220a?auto=format&fit=crop&w=800&q=80'
            ],
            // Bisutería
            [
                'category_slug' => 'bisuteria',
                'name' => 'Pendientes Arcilla Flora',
                'description' => 'Pendientes artesanales moldeados a mano en arcilla polimérica. Un diseño floral alegre, con detalles texturizados y hermosos tonos pastel que te harán destacar.',
                'price' => 18.50,
                'stock' => 10,
                'image_url' => 'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'bisuteria',
                'name' => 'Collar Boho Cuentas',
                'description' => 'Gargantilla hecha a mano con cuentas de resina orgánica en tonalidades tierra y detalles dorados intercalados. Cuenta con un cierre ajustable para adaptar su largo.',
                'price' => 12.00,
                'stock' => 45,
                'image_url' => 'https://images.unsplash.com/photo-1599643477877-530eb83abc8e?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'bisuteria',
                'name' => 'Pulsera Hilo Trenzado',
                'description' => 'Pulsera artesanal trenzada con hilo encerado altamente duradero y resistente al agua. Adornada con pequeñas cuentas de latón y un colgante circular.',
                'price' => 8.99,
                'stock' => 50,
                'image_url' => 'https://images.unsplash.com/photo-1573408301185-9146fe634ad0?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'bisuteria',
                'name' => 'Anillo Esmalte Solar',
                'description' => 'Anillo ajustable chapado en oro con un diseño geométrico de esmalte de alta resistencia en colores vibrantes y vivos. El toque alegre perfecto.',
                'price' => 14.50,
                'stock' => 35,
                'image_url' => 'https://images.unsplash.com/photo-1603561591411-07134e71a2a9?auto=format&fit=crop&w=800&q=80'
            ],
            // Papelería
            [
                'category_slug' => 'papeleria',
                'name' => 'Cuaderno Cuero Aventura',
                'description' => 'Libreta A5 con cubiertas de cuero sintético grabado de tacto suave y cierre de cordón encerado. Cuenta con 160 páginas de papel Kraft de alto gramaje, ideal para bocetos y notas de viaje.',
                'price' => 24.99,
                'stock' => 12,
                'image_url' => 'https://images.unsplash.com/photo-1531346878377-a5be20888e57?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'papeleria',
                'name' => 'Set Bolígrafos Gel Pastel',
                'description' => 'Pack de 6 bolígrafos de gel recargables en tonos pastel. Tinta de gel ultra fluida y de secado rápido, ideales para bullet journaling y apuntes súper limpios con punta de 0.5mm.',
                'price' => 7.99,
                'stock' => 40,
                'image_url' => 'https://images.unsplash.com/photo-1583485088034-697b5bc54ccd?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'papeleria',
                'name' => 'Agenda Anual Escanda',
                'description' => 'Agenda escolar y de oficina a semana vista, con tapas duras resistentes, anillas doradas y banda elástica de cierre. Incluye stickers organizadores, marcapáginas e ilustraciones interiores.',
                'price' => 19.99,
                'stock' => 15,
                'image_url' => 'https://images.unsplash.com/photo-1506784983877-45594efa4cbe?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'papeleria',
                'name' => 'Set Washi Tapes Botánico',
                'description' => 'Pack de 10 cintas adhesivas decorativas japonesas (Washi Tapes) con preciosos motivos botánicos, flores silvestres y acuarelas para manualidades y papelería creativa.',
                'price' => 9.50,
                'stock' => 60,
                'image_url' => 'https://images.unsplash.com/photo-1586075010923-2dd4570fb338?auto=format&fit=crop&w=800&q=80'
            ]
        ];

        // 4. Create products and link to their primary images
        $products = collect();
        foreach ($productData as $p) {
            $category = $categories->firstWhere('slug', $p['category_slug']);
            $product = \App\Models\Product::create([
                'category_id' => $category->id,
                'name' => $p['name'],
                'slug' => \Illuminate\Support\Str::slug($p['name']),
                'description' => $p['description'],
                'price' => $p['price'],
                'stock' => $p['stock'],
                'is_visible' => true,
            ]);

            \App\Models\ProductImage::create([
                'product_id' => $product->id,
                'url' => $p['image_url'],
                'is_primary' => true,
            ]);
            $products->push($product);
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

        // 9. Special test user
        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@escandashop.com',
            'role' => 'admin',
        ]);
    }
}
