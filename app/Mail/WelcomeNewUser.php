<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Clase Mailable WelcomeNewUser
 * 
 * Se encarga de construir y despachar el correo de bienvenida premium para los
 * nuevos clientes de EscandaShop al completar su registro en la plataforma.
 * Implementa ShouldQueue para procesarse en colas asíncronas en segundo plano.
 */
class WelcomeNewUser extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * El modelo de usuario que se ha registrado.
     *
     * @var \App\Models\User
     */
    public $user;

    /**
     * Crea una nueva instancia del correo de bienvenida.
     *
     * @param \App\Models\User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Obtiene el sobre (envelope) con el asunto del correo.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Te damos la bienvenida a EscandaShop! ✨',
        );
    }

    /**
     * Obtiene la definición de contenido y la vista de renderizado (Blade).
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.welcome',
            with: [
                'user' => $this->user,
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
