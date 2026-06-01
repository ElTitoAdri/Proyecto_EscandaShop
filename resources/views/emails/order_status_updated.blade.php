@extends('emails.layout')

@section('title', 'Actualización de tu pedido - EscandaShop')

@section('content')
    <h2 style="margin: 0 0 20px 0; font-family: 'Times New Roman', Times, serif; font-size: 24px; color: #1a1a1a; font-weight: 300; border-bottom: 1px solid #f0f0f0; padding-bottom: 10px;">
        Actualización de tu Pedido
    </h2>
    
    <p style="margin: 0 0 20px 0; font-size: 16px; color: #555555; line-height: 1.6;">
        Hola <strong>{{ $order->user->name }}</strong>, el estado de tu pedido **ES-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}** ha cambiado.
    </p>

    <!-- Caja de Estado Actualizado -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #faf8f5; border: 1px solid #d4af37; border-radius: 6px; padding: 25px; margin-bottom: 30px; text-align: center;">
        <tr>
            <td>
                <span style="font-size: 12px; color: #888; text-transform: uppercase; letter-spacing: 2px;">Nuevo Estado del Pedido</span>
                <h1 style="margin: 5px 0 15px 0; font-family: 'Times New Roman', Times, serif; font-size: 28px; color: #d4af37; font-weight: 400; text-transform: uppercase; letter-spacing: 1px;">
                    @if($order->status === 'paid')
                        Confirmado / Pagado
                    @elseif($order->status === 'shipped')
                        En camino / Enviado 🚚
                    @elseif($order->status === 'completed')
                        Completado / Entregado 🎉
                    @elseif($order->status === 'cancelled')
                        Cancelado ❌
                    @else
                        {{ ucfirst($order->status) }}
                    @endif
                </h1>
                
                <p style="margin: 0; font-size: 15px; color: #555; line-height: 1.5; font-style: italic;">
                    @if($order->status === 'paid')
                        "Hemos recibido el pago de tu pedido y ya se está procesando en nuestros talleres artesanales."
                    @elseif($order->status === 'shipped')
                        "¡Grandes noticias! Tu pedido ha sido empaquetado con cuidado y ya ha salido de nuestros talleres. Se encuentra en manos de la mensajería exprés y llegará en 24/48 horas laborables."
                    @elseif($order->status === 'completed')
                        "¡Tu paquete ha sido entregado en la dirección indicada! Esperamos de corazón que disfrutes de tu joya premium de EscandaShop. Gracias por dejarnos ser parte de tus momentos especiales."
                    @elseif($order->status === 'cancelled')
                        "Lamentamos informarte que este pedido ha sido cancelado. Si el pago ya fue cargado, el reembolso completo se procesará automáticamente en tu tarjeta en los próximos días."
                    @else
                        "El estado de tu pedido ha sido actualizado a {{ $order->status }}."
                    @endif
                </p>
            </td>
        </tr>
    </table>

    @if($order->status !== 'cancelled')
        <!-- Timeline Visual Premium -->
        <h3 style="margin: 0 0 20px 0; font-family: 'Times New Roman', Times, serif; font-size: 16px; color: #1a1a1a; text-transform: uppercase; letter-spacing: 1px; text-align: center;">
            Progreso del Envío
        </h3>
        
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 40px; text-align: center;">
            <tr>
                <!-- Paso 1: Pagado -->
                <td style="width: 33%;">
                    <div style="font-size: 12px; font-weight: 600; color: #1a1a1a; margin-bottom: 8px;">1. Confirmado</div>
                    <div style="margin: 0 auto; width: 24px; height: 24px; line-height: 24px; border-radius: 50%; background-color: #d4af37; color: white; font-weight: bold; font-size: 12px;">✓</div>
                </td>
                
                <!-- Conector 1-2 -->
                <td style="width: 1px; vertical-align: middle; padding-top: 20px;">
                    <div style="width: 50px; height: 3px; background-color: {{ in_array($order->status, ['shipped', 'completed']) ? '#d4af37' : '#e9e9e9' }}; margin: 0 -25px;"></div>
                </td>
                
                <!-- Paso 2: Enviado -->
                <td style="width: 33%;">
                    <div style="font-size: 12px; font-weight: 600; color: {{ in_array($order->status, ['shipped', 'completed']) ? '#1a1a1a' : '#999' }}; margin-bottom: 8px;">2. Enviado</div>
                    <div style="margin: 0 auto; width: 24px; height: 24px; line-height: 24px; border-radius: 50%; background-color: {{ in_array($order->status, ['shipped', 'completed']) ? '#d4af37' : '#e9e9e9' }}; color: {{ in_array($order->status, ['shipped', 'completed']) ? '#ffffff' : '#999999' }}; font-weight: bold; font-size: 12px;">
                        @if(in_array($order->status, ['shipped', 'completed'])) ✓ @else 2 @endif
                    </div>
                </td>
                
                <!-- Conector 2-3 -->
                <td style="width: 1px; vertical-align: middle; padding-top: 20px;">
                    <div style="width: 50px; height: 3px; background-color: {{ $order->status === 'completed' ? '#d4af37' : '#e9e9e9' }}; margin: 0 -25px;"></div>
                </td>
                
                <!-- Paso 3: Entregado -->
                <td style="width: 33%;">
                    <div style="font-size: 12px; font-weight: 600; color: {{ $order->status === 'completed' ? '#1a1a1a' : '#999' }}; margin-bottom: 8px;">3. Entregado</div>
                    <div style="margin: 0 auto; width: 24px; height: 24px; line-height: 24px; border-radius: 50%; background-color: {{ $order->status === 'completed' ? '#d4af37' : '#e9e9e9' }}; color: {{ $order->status === 'completed' ? '#ffffff' : '#999999' }}; font-weight: bold; font-size: 12px;">
                        @if($order->status === 'completed') ✓ @else 3 @endif
                    </div>
                </td>
            </tr>
        </table>
    @endif

    <!-- Datos del Pedido -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #fafafa; border: 1px solid #e9e9e9; border-radius: 6px; padding: 20px; margin-bottom: 35px;">
        <tr>
            <td style="font-size: 14px; color: #555; line-height: 1.6;">
                <strong>Referencia del Pedido:</strong> <span style="color: #1a1a1a; font-weight: 600;">ES-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span><br>
                <strong>Total de la Compra:</strong> <span style="color: #1a1a1a; font-weight: 600;">{{ number_format($order->total_price, 2, ',', '.') }} €</span><br>
                <strong>Dirección de Entrega:</strong> <span style="color: #1a1a1a;">{{ $order->shipping_address }}</span>
            </td>
        </tr>
    </table>

    <!-- Botón de Ver Detalles en Mi Cuenta -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 20px;">
        <tr>
            <td align="center">
                <a href="{{ route('account.index') }}" style="background-color: #1a1a1a; color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 500; text-transform: uppercase; letter-spacing: 2px; padding: 16px 35px; border-radius: 4px; border: 1px solid #d4af37; display: inline-block;">
                    Hacer seguimiento de mi pedido
                </a>
            </td>
        </tr>
    </table>

    <p style="margin: 35px 0 0 0; font-size: 14px; color: #777777;">
        Si tienes cualquier duda con respecto a tu envío, ponte en contacto con nosotros escribiendo a <a href="mailto:soporte@escandashop.com" style="color: #d4af37; text-decoration: none;">soporte@escandashop.com</a> facilitando tu referencia de pedido.
    </p>
@endsection
