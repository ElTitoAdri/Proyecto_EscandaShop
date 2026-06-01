@extends('emails.layout')

@section('title', 'Confirmación de Pedido - EscandaShop')

@section('content')
    <h2 style="margin: 0 0 20px 0; font-family: 'Times New Roman', Times, serif; font-size: 24px; color: #1a1a1a; font-weight: 300; border-bottom: 1px solid #f0f0f0; padding-bottom: 10px;">
        ¡Gracias por tu compra!
    </h2>
    
    <p style="margin: 0 0 20px 0; font-size: 16px; color: #555555; line-height: 1.6;">
        Hola <strong>{{ $order->user->name }}</strong>, hemos recibido tu pedido con éxito y ya lo estamos preparando con todo el mimo y cuidado que se merece.
    </p>

    <!-- Información de Resumen de Pedido -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #fafafa; border: 1px solid #e9e9e9; border-radius: 6px; padding: 20px; margin-bottom: 30px;">
        <tr>
            <td style="font-size: 14px; color: #666;">
                <strong>Referencia del Pedido:</strong> <span style="color: #1a1a1a; font-weight: 600;">ES-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span><br>
                <strong>Fecha del Pedido:</strong> <span style="color: #1a1a1a;">{{ $order->created_at->format('d/m/Y H:i') }}</span><br>
                <strong>Método de Pago:</strong> <span style="color: #1a1a1a;">Stripe (Tarjeta de crédito)</span>
            </td>
        </tr>
    </table>

    <!-- Tabla Detalle del Pedido -->
    <h3 style="margin: 0 0 15px 0; font-family: 'Times New Roman', Times, serif; font-size: 18px; color: #1a1a1a; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #1a1a1a; padding-bottom: 5px;">
        Detalles del Pedido
    </h3>
    
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 30px; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 1px solid #e9e9e9;">
                <th align="left" style="padding: 10px 0; font-size: 12px; color: #999; text-transform: uppercase; letter-spacing: 1px;">Producto</th>
                <th align="center" style="padding: 10px 0; font-size: 12px; color: #999; text-transform: uppercase; letter-spacing: 1px; width: 60px;">Cant.</th>
                <th align="right" style="padding: 10px 0; font-size: 12px; color: #999; text-transform: uppercase; letter-spacing: 1px; width: 100px;">Precio</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr style="border-bottom: 1px solid #f6f6f6;">
                    <td style="padding: 15px 0; font-size: 14px; color: #333; font-weight: 500;">
                        {{ $item->product->name ?? 'Producto no disponible' }}
                    </td>
                    <td align="center" style="padding: 15px 0; font-size: 14px; color: #555;">
                        {{ $item->quantity }}
                    </td>
                    <td align="right" style="padding: 15px 0; font-size: 14px; color: #333; font-weight: 600;">
                        {{ number_format($item->price_at_purchase * $item->quantity, 2, ',', '.') }} €
                    </td>
                </tr>
            @endforeach
            
            <!-- Totales -->
            <tr>
                <td colspan="2" align="right" style="padding: 15px 0 5px 0; font-size: 14px; color: #666;">
                    Subtotal:
                </td>
                <td align="right" style="padding: 15px 0 5px 0; font-size: 14px; color: #333; font-weight: 500;">
                    {{ number_format($order->total_price, 2, ',', '.') }} €
                </td>
            </tr>
            <tr>
                <td colspan="2" align="right" style="padding: 5px 0; font-size: 14px; color: #666;">
                    Envío:
                </td>
                <td align="right" style="padding: 5px 0; font-size: 14px; color: #27ae60; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
                    Gratis
                </td>
            </tr>
            <tr style="border-top: 1px solid #1a1a1a; font-weight: bold;">
                <td colspan="2" align="right" style="padding: 15px 0; font-size: 16px; color: #1a1a1a; text-transform: uppercase; letter-spacing: 1px;">
                    Total:
                </td>
                <td align="right" style="padding: 15px 0; font-size: 18px; color: #d4af37; font-weight: 700;">
                    {{ number_format($order->total_price, 2, ',', '.') }} €
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Dirección de Envío -->
    <h3 style="margin: 0 0 15px 0; font-family: 'Times New Roman', Times, serif; font-size: 18px; color: #1a1a1a; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #1a1a1a; padding-bottom: 5px;">
        Dirección de Envío
    </h3>
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #fafafa; border: 1px solid #e9e9e9; border-radius: 6px; padding: 20px; margin-bottom: 35px;">
        <tr>
            <td style="font-size: 14px; color: #555; line-height: 1.5;">
                <strong>Destinatario:</strong> {{ $order->user->name }}<br>
                <strong>Dirección:</strong> {{ $order->shipping_address }}
            </td>
        </tr>
    </table>

    <!-- Botón de Ver Cuenta / Pedidos -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 20px;">
        <tr>
            <td align="center">
                <a href="{{ route('account.index') }}" style="background-color: #1a1a1a; color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 500; text-transform: uppercase; letter-spacing: 2px; padding: 16px 35px; border-radius: 4px; border: 1px solid #d4af37; display: inline-block;">
                    Ver mis pedidos en Mi Cuenta
                </a>
            </td>
        </tr>
    </table>

    <p style="margin: 30px 0 0 0; font-size: 14px; color: #777777;">
        Te enviaremos otro correo tan pronto como tu pedido salga de nuestros talleres con los datos de seguimiento.
    </p>
@endsection
