<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Clase Mailable ContactSupportAutoReply
 * 
 * Gestiona y despacha el correo electrónico automático de acuse de recibo 
 * enviado a los usuarios cuando envían un mensaje a través del formulario de soporte técnico.
 * Implementa ShouldQueue para delegar el envío en colas asíncronas de Laravel.
 */
class ContactSupportAutoReply extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Nombre del remitente que realiza la consulta.
     *
     * @var string
     */
    public $name;

    /**
     * Línea de asunto original de la consulta.
     *
     * @var string
     */
    public $subjectLine;

    /**
     * Cuerpo del mensaje original redactado por el usuario.
     *
     * @var string
     */
    public $bodyMessage;

    /**
     * Crea una nueva instancia del correo de auto-respuesta.
     *
     * @param string $name
     * @param string $subjectLine
     * @param string $bodyMessage
     * @return void
     */
    public function __construct($name, $subjectLine, $bodyMessage)
    {
        $this->name = $name;
        $this->subjectLine = $subjectLine;
        $this->bodyMessage = $bodyMessage;
    }

    /**
     * Obtiene el sobre (envelope) con el asunto personalizado del correo.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Hemos recibido tu consulta en EscandaShop ✉️',
        );
    }

    /**
     * Obtiene la definición de contenido y la vista de renderizado Blade.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact_reply',
            with: [
                'name' => $this->name,
                'subject' => $this->subjectLine,
                'bodyMessage' => $this->bodyMessage,
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

