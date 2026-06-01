<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Mail\ContactSupportAutoReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

/**
 * Clase Controlador ContactController
 * 
 * Gestiona el formulario de soporte técnico y contacto de la tienda, 
 * procesando el almacenamiento de consultas de usuarios e invitados, y despachando 
 * correos electrónicos automatizados de acuse de recibo.
 */
class ContactController extends Controller
{
    /**
     * Muestra la vista con el formulario de contacto.
     * Carga todas las categorías disponibles para el menú de navegación de la tienda.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categories = \App\Models\Category::all();
        return view('contact', compact('categories'));
    }

    /**
     * Valida y almacena un nuevo mensaje de contacto en la base de datos,
     * y posteriormente despacha un correo de auto-respuesta al solicitante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validar minuciosamente los parámetros de entrada del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        try {
            // Persistir el mensaje de soporte en la base de datos
            $messageObj = Message::create([
                'user_id' => auth()->id(), // Almacena el ID del usuario autenticado o null para visitantes
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'status' => 'unread', // Por defecto el mensaje entra en estado 'no leído'
            ]);

            // Despachar el correo electrónico asíncrono de acuse de recibo
            try {
                Mail::to($request->email)->send(new ContactSupportAutoReply(
                    $request->name,
                    $request->subject,
                    $request->message
                ));
            } catch (\Exception $mailEx) {
                // Registrar cualquier excepción del servicio de correo para auditorías de soporte
                Log::error("Error al enviar email de respuesta automática de contacto: " . $mailEx->getMessage());
            }

            return redirect()->back()->with('success', '¡Gracias por ponerte en contacto! Hemos recibido tu mensaje y te responderemos pronto.');

        } catch (\Exception $e) {
            // Capturar y registrar fallos graves de base de datos o lógica general
            Log::error("Error al guardar mensaje de contacto: " . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un error al procesar tu solicitud. Por favor, inténtalo de nuevo.');
        }
    }
}

