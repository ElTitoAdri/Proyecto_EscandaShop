<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\RedirectResponse;
use Tests\TestCase;

class CheckoutShippingAddressTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_checkout_to_login(): void
    {
        $response = $this->get('/checkout');
        $response->assertRedirect('/login');

        $responsePost = $this->post('/checkout', [
            'address' => 'Test Address',
            'city' => 'Test City',
            'postal_code' => '12345',
            'province' => 'Test Province',
        ]);
        $responsePost->assertRedirect('/login');
    }

    public function test_checkout_redirects_to_cart_if_cart_is_empty(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/checkout');
        $response->assertRedirect('/carrito');
        $response->assertSessionHas('error', 'Tu carrito está vacío.');
    }

    public function test_checkout_page_renders_with_items_in_cart(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Joyas', 'slug' => 'joyas']);
        $product = Product::create([
            'name' => 'Anillo Oro',
            'slug' => 'anillo-oro',
            'description' => 'Un anillo hermoso',
            'price' => 150.00,
            'stock' => 10,
            'category_id' => $category->id,
            'is_visible' => true,
        ]);

        $cart = [
            $product->id => [
                'name' => $product->name,
                'slug' => $product->slug,
                'quantity' => 1,
                'price' => $product->price,
                'image' => 'https://placehold.co/100',
            ]
        ];

        $response = $this->actingAs($user)
            ->withSession(['cart' => $cart])
            ->get('/checkout');

        $response->assertStatus(200);
        $response->assertSee('Dirección de Envío');
        $response->assertSee('Anillo Oro');
    }

    public function test_checkout_post_validates_address_fields(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->withSession(['cart' => ['1' => []]])
            ->post('/checkout', [
                'address' => '',
                'city' => '',
                'postal_code' => '',
                'province' => '',
            ]);

        $response->assertSessionHasErrors(['address', 'city', 'postal_code', 'province']);
    }

    public function test_checkout_post_saves_address_and_redirects_to_stripe(): void
    {
        // Creamos una mock de Checkout y otra de User para interceptar la llamada Stripe de Cashier
        $checkoutMock = \Mockery::mock(\Laravel\Cashier\Checkout::class);
        $checkoutMock->shouldReceive('toResponse')
            ->andReturn(redirect('https://checkout.stripe.com/pay/test_session'));

        $user = $this->partialMock(User::class, function ($mock) use ($checkoutMock) {
            $mock->shouldReceive('checkout')
                ->once()
                ->andReturn($checkoutMock);
        });

        // Completar atributos requeridos del factory
        $user->name = 'Juan Perez';
        $user->email = 'juan@example.com';
        $user->password = bcrypt('password');
        $user->save();

        $category = Category::create(['name' => 'Joyas', 'slug' => 'joyas']);
        $product = Product::create([
            'name' => 'Collar Plata',
            'slug' => 'collar-plata',
            'description' => 'Un hermoso collar',
            'price' => 80.00,
            'stock' => 5,
            'category_id' => $category->id,
            'is_visible' => true,
        ]);

        $cart = [
            $product->id => [
                'name' => $product->name,
                'slug' => $product->slug,
                'quantity' => 2,
                'price' => $product->price,
                'image' => 'https://placehold.co/100',
            ]
        ];

        $response = $this->actingAs($user)
            ->withSession(['cart' => $cart])
            ->post('/checkout', [
                'address' => 'Calle Mayor 10, 2B',
                'city' => 'Madrid',
                'postal_code' => '28013',
                'province' => 'Madrid',
            ]);

        // Debe redirigir a Stripe
        $response->assertRedirect('https://checkout.stripe.com/pay/test_session');

        // Los campos deben guardarse en el perfil del usuario en la base de datos
        $this->assertDatabaseHas('users', [
            'email' => 'juan@example.com',
            'address' => 'Calle Mayor 10, 2B',
            'city' => 'Madrid',
            'postal_code' => '28013',
            'province' => 'Madrid',
        ]);
    }

    public function test_checkout_success_creates_order_with_shipping_address(): void
    {
        $user = User::factory()->create([
            'address' => 'Calle Mayor 10, 2B',
            'city' => 'Madrid',
            'postal_code' => '28013',
            'province' => 'Madrid',
        ]);

        $category = Category::create(['name' => 'Joyas', 'slug' => 'joyas']);
        $product = Product::create([
            'name' => 'Collar Plata',
            'slug' => 'collar-plata',
            'description' => 'Un hermoso collar',
            'price' => 80.00,
            'stock' => 5,
            'category_id' => $category->id,
            'is_visible' => true,
        ]);

        $cart = [
            $product->id => [
                'name' => $product->name,
                'slug' => $product->slug,
                'quantity' => 1,
                'price' => $product->price,
                'image' => 'https://placehold.co/100',
            ]
        ];

        // Se envía email confirmación, así que silenciamos el Mail para no enviar mails reales
        \Illuminate\Support\Facades\Mail::fake();

        $response = $this->actingAs($user)
            ->withSession(['cart' => $cart])
            ->get('/checkout/success?session_id=cs_test_session_id');

        $response->assertStatus(200);

        // El carrito debe estar vacío
        $this->assertEmpty(session()->get('cart'));

        // El pedido debe existir en la base de datos con la dirección formateada
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'total_price' => 80.00,
            'status' => 'paid',
            'shipping_address' => 'Calle Mayor 10, 2B, Madrid (28013), Madrid',
            'payment_id' => 'cs_test_session_id',
        ]);

        // El stock del producto debe haberse decrementado
        $product->refresh();
        $this->assertEquals(4, $product->stock);
    }
}
