@extends('emails.layout')

@section('title', 'Bienvenido a EscandaShop')

@section('content')
    <h2 style="margin: 0 0 20px 0; font-family: 'Times New Roman', Times, serif; font-size: 24px; color: #1a1a1a; font-weight: 300; border-bottom: 1px solid #f0f0f0; padding-bottom: 10px;">
        ¡Hola, <span style="font-weight: 600; color: #d4af37;">{{ $user->name }}</span>!
    </h2>
    
    <p style="margin: 0 0 20px 0; font-size: 16px; color: #555555; font-weight: 300; line-height: 1.6;">
        Es un placer darte la bienvenida oficial a **EscandaShop**. Nos apasiona la artesanía, el diseño y la creación de piezas únicas de joyería y complementos que resalten tu personalidad y elegancia natural.
    </p>
    
    <p style="margin: 0 0 30px 0; font-size: 15px; color: #555555; line-height: 1.6;">
        A partir de ahora, tendrás acceso anticipado a nuestras nuevas colecciones, ofertas exclusivas para miembros y un panel personal de cliente donde gestionar tus pedidos y valoraciones.
    </p>

    <!-- Tarjeta de Regalo de Bienvenida -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #faf8f5; border: 1px dashed #d4af37; border-radius: 6px; margin-bottom: 35px;">
        <tr>
            <td style="padding: 25px; text-align: center;">
                <h3 style="margin: 0 0 10px 0; font-family: 'Times New Roman', Times, serif; font-size: 18px; color: #1a1a1a; text-transform: uppercase; letter-spacing: 1px;">
                    Tu Regalo de Bienvenida
                </h3>
                <p style="margin: 0 0 15px 0; font-size: 14px; color: #666666;">
                    Disfruta de un **10% de descuento** en tu primera compra en nuestra tienda online utilizando el siguiente código:
                </p>
                <div style="display: inline-block; background-color: #1a1a1a; color: #d4af37; font-weight: 700; font-size: 20px; letter-spacing: 3px; padding: 12px 30px; border-radius: 4px; border: 1px solid #d4af37;">
                    BIENVENIDA10
                </div>
                <p style="margin: 15px 0 0 0; font-size: 11px; color: #999999; font-style: italic;">
                    *Válido para cualquier artículo del catálogo.
                </p>
            </td>
        </tr>
    </table>

    <!-- Botón Call to Action -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 20px;">
        <tr>
            <td align="center">
                <a href="{{ route('store.index') }}" style="background-color: #1a1a1a; color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 500; text-transform: uppercase; letter-spacing: 2px; padding: 16px 35px; border-radius: 4px; border: 1px solid #d4af37; display: inline-block; transition: background-color 0.3s;">
                    Explorar el Catálogo
                </a>
            </td>
        </tr>
    </table>

    <p style="margin: 30px 0 0 0; font-size: 14px; color: #777777;">
        Gracias por confiar en nosotros.<br>
        El equipo de **EscandaShop**.
    </p>
@endsection
