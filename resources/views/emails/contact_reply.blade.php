@extends('emails.layout')

@section('title', 'Hemos recibido tu consulta - EscandaShop')

@section('content')
    <h2 style="margin: 0 0 20px 0; font-family: 'Times New Roman', Times, serif; font-size: 24px; color: #1a1a1a; font-weight: 300; border-bottom: 1px solid #f0f0f0; padding-bottom: 10px;">
        ¡Hola, <span style="font-weight: 600; color: #d4af37;">{{ $name }}</span>!
    </h2>
    
    <p style="margin: 0 0 20px 0; font-size: 16px; color: #555555; line-height: 1.6;">
        Queríamos confirmarte que hemos recibido tu mensaje en nuestro departamento de atención al cliente de **EscandaShop**. 
    </p>
    
    <p style="margin: 0 0 30px 0; font-size: 15px; color: #555555; line-height: 1.6;">
        Nuestro equipo de soporte ya está revisando tu consulta y te responderemos en un plazo máximo de **24 horas laborables**. 
    </p>

    <!-- Resumen del Mensaje Recibido -->
    <h3 style="margin: 0 0 15px 0; font-family: 'Times New Roman', Times, serif; font-size: 16px; color: #1a1a1a; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #1a1a1a; padding-bottom: 5px;">
        Copia de tu consulta
    </h3>
    
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #fafafa; border: 1px solid #e9e9e9; border-radius: 6px; padding: 20px; margin-bottom: 30px;">
        <tr>
            <td style="font-size: 14px; color: #555; line-height: 1.6;">
                <strong>Asunto:</strong> <span style="color: #1a1a1a;">{{ $subject }}</span><br>
                <strong>Mensaje enviado:</strong><br>
                <div style="margin-top: 10px; padding: 12px; background-color: #ffffff; border-left: 3px solid #d4af37; border-radius: 2px; font-style: italic; color: #666666; font-size: 13.5px; line-height: 1.5;">
                    {!! nl2br(e($bodyMessage)) !!}
                </div>
            </td>
        </tr>
    </table>

    <p style="margin: 0 0 20px 0; font-size: 14px; color: #777777;">
        Si tienes algún detalle adicional que quieras aportar, puedes responder directamente a este correo manteniendo el asunto original.
    </p>

    <p style="margin: 30px 0 0 0; font-size: 14px; color: #777777;">
        Gracias por ponerte en contacto con nosotros.<br>
        El equipo de **EscandaShop**.
    </p>
@endsection
