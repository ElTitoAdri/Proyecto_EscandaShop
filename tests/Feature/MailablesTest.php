<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Category;
use App\Mail\WelcomeNewUser;
use App\Mail\OrderConfirmed;
use App\Mail\OrderStatusUpdated;
use App\Mail\ContactSupportAutoReply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Tests\TestCase;

class MailablesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that registering a user dispatches the WelcomeNewUser email.
     */
    public function test_welcome_email_is_sent_on_registration(): void
    {
        Mail::fake();

        // Registrar un usuario a través del endpoint oficial
        $response = $this->post('/register', [
            'name' => 'Adrián Escanda',
            'email' => 'adrian@escandashop.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect();
        
        // Verificar que el email de bienvenida fue encolado
        Mail::assertQueued(WelcomeNewUser::class, function ($mail) {
            return $mail->hasTo('adrian@escandashop.com') && 
                   $mail->user->name === 'Adrián Escanda';
        });
    }

    /**
     * Test that updating an order's status dispatches OrderStatusUpdated email.
     */
    public function test_order_status_updated_email_is_sent_on_status_change(): void
    {
        Mail::fake();

        // Crear usuario
        $user = User::factory()->create(['email' => 'cliente@escandashop.com']);

        // Crear pedido
        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => 150.00,
            'status' => 'paid',
            'shipping_address' => 'Calle Gran Vía 12, Madrid',
            'payment_id' => 'ch_test_12345'
        ]);

        // Cambiar el estado a "shipped" (Enviado)
        $order->update(['status' => 'shipped']);

        // Verificar que se encoló el correo de seguimiento
        Mail::assertQueued(OrderStatusUpdated::class, function ($mail) use ($order) {
            return $mail->hasTo('cliente@escandashop.com') &&
                   $mail->order->id === $order->id &&
                   $mail->order->status === 'shipped';
        });
    }

    /**
     * Test that compiling the OrderConfirmed mailable works perfectly.
     */
    public function test_order_confirmed_mailable_compiles_correctly(): void
    {
        // Crear datos
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Anillos', 'slug' => 'anillos']);
        $product = Product::create([
            'name' => 'Anillo de Oro Imperial',
            'slug' => 'anillo-oro-imperial',
            'description' => 'Un anillo majestuoso.',
            'price' => 299.99,
            'stock' => 10,
            'category_id' => $category->id
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => 299.99,
            'status' => 'paid',
            'shipping_address' => 'Avenida Diagonal 45, Barcelona',
            'payment_id' => 'cs_test_98765'
        ]);

        $orderItem = OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price_at_purchase' => 299.99
        ]);

        // Instanciar el mailable
        $mailable = new OrderConfirmed($order);

        // Renderizar el contenido HTML del correo para asegurar que no da fallos de Blade
        $html = $mailable->render();

        $this->assertStringContainsString('Anillo de Oro Imperial', $html);
        $this->assertStringContainsString('Avenida Diagonal 45, Barcelona', $html);
        $this->assertStringContainsString('299,99', $html);
    }

    /**
     * Test that submitting the contact form persists message and dispatches auto-reply.
     */
    public function test_contact_form_saves_message_and_sends_auto_reply(): void
    {
        Mail::fake();

        $response = $this->post('/contacto', [
            'name' => 'Sofía Joyas',
            'email' => 'sofia@gmail.com',
            'subject' => 'Consulta sobre stock de pendientes',
            'message' => 'Hola, me gustaría saber si volverán a tener en stock el modelo de pendientes dorados.',
        ]);

        $response->assertRedirect();
        
        // Verificar que el mensaje se guardó en BD
        $this->assertDatabaseHas('messages', [
            'name' => 'Sofía Joyas',
            'email' => 'sofia@gmail.com',
            'subject' => 'Consulta sobre stock de pendientes',
        ]);

        // Verificar que se encoló el email de respuesta automática
        Mail::assertQueued(ContactSupportAutoReply::class, function ($mail) {
            return $mail->hasTo('sofia@gmail.com') &&
                   $mail->name === 'Sofía Joyas' &&
                   $mail->subjectLine === 'Consulta sobre stock de pendientes';
        });
    }
}
