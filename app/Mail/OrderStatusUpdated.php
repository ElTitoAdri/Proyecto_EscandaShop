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
 * Clase Mailable OrderStatusUpdated
 * 
 * Se encarga de enviar notificaciones de seguimiento en tiempo real al cliente 
 * cada vez que el administrador modifica el estado de su pedido (ej. Enviado, Entregado).
 * Implementa ShouldQueue para agilizar la interacción en el Panel de Administración.
 */
class OrderStatusUpdated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * El pedido cuyo estado ha cambiado.
     *
     * @var \App\Models\Order
     */
    public $order;

    /**
     * Crea una nueva instancia del correo de cambio de estado.
     *
     * @param \App\Models\Order $order
     * @return void
     */
    public function __construct(Order $order)
    {
        // Asegurar que la relación del usuario / cliente esté cargada para el renderizado
        $this->order = $order->relationLoaded('user') ? $order : $order->load('user');
    }

    /**
     * Obtiene el sobre (envelope) con el asunto dinámico y adaptado al estado.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        $orderRef = str_pad($this->order->id, 6, '0', STR_PAD_LEFT);
        
        // Traducimos el estado de la base de datos a un formato comprensible y estilizado
        $statusText = 'Actualizado';
        if ($this->order->status === 'shipped') {
            $statusText = 'Enviado 🚚';
        } elseif ($this->order->status === 'completed') {
            $statusText = 'Entregado 🎉';
        } elseif ($this->order->status === 'cancelled') {
            $statusText = 'Cancelado ❌';
        } elseif ($this->order->status === 'paid') {
            $statusText = 'Confirmado 🛍️';
        }

        return new Envelope(
            subject: "Tu pedido ES-{$orderRef} ha sido {$statusText} - EscandaShop",
        );
    }

    /**
     * Obtiene la definición de contenido y la vista de seguimiento (Timeline).
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order_status_updated',
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
