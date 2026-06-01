<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Clase Mailable OrderConfirmed
 * 
 * Se encarga de procesar y enviar el correo de confirmación de compra y factura
 * digital a los clientes de EscandaShop una vez que su pago se liquida con éxito.
 * Implementa ShouldQueue para optimizar los tiempos de respuesta del Checkout.
 */
class OrderConfirmed extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * El pedido que ha sido confirmado.
     *
     * @var \App\Models\Order
     */
    public $order;

    /**
     * Crea una nueva instancia del correo de confirmación de pedido.
     *
     * @param \App\Models\Order $order
     * @return void
     */
    public function __construct(Order $order)
    {
        // Garantizamos que las relaciones del pedido (artículos, productos y cliente) estén cargadas para la vista
        $this->order = $order->relationLoaded('items.product') ? $order : $order->load('items.product', 'user');
    }

    /**
     * Obtiene el sobre (envelope) con el asunto personalizado del correo.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        $orderRef = str_pad($this->order->id, 6, '0', STR_PAD_LEFT);
        return new Envelope(
            subject: "Confirmación de tu pedido ES-{$orderRef} 🛍️ - EscandaShop",
        );
    }

    /**
     * Obtiene la definición de contenido y la plantilla Blade de factura.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order_confirmed',
            with: [
                'order' => $this->order,
            ],
        );
    }

    /**
     * Obtiene los archivos adjuntos del correo electrónico.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
