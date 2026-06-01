<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EscandaShop')</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f6f6f6; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f6f6f6; padding: 20px 0;">
        <tr>
            <td align="center">
                <!-- Contenedor Principal -->
                <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border: 1px solid #e9e9e9;">
                    <!-- Cabecera de Lujo -->
                    <tr>
                        <td align="center" style="background-color: #1a1a1a; padding: 40px 20px; border-bottom: 3px solid #d4af37;">
                            <h1 style="margin: 0; font-family: 'Times New Roman', Times, serif; font-size: 32px; letter-spacing: 4px; color: #ffffff; text-transform: uppercase; font-weight: 300;">
                                ESCANDA<span style="color: #d4af37; font-weight: 400;">SHOP</span>
                            </h1>
                            <p style="margin: 5px 0 0 0; color: #a9a9a9; font-size: 11px; text-transform: uppercase; letter-spacing: 2px;">Joyería & Complementos Premium</p>
                        </td>
                    </tr>
                    
                    <!-- Contenido del Email -->
                    <tr>
                        <td style="padding: 40px 30px; color: #333333; font-size: 15px; line-height: 1.6;">
                            @yield('content')
                        </td>
                    </tr>
                    
                    <!-- Pie de Página -->
                    <tr>
                        <td style="background-color: #1a1a1a; padding: 30px; text-align: center; border-top: 1px solid #2d2d2d; color: #a9a9a9; font-size: 12px; line-height: 1.5;">
                            <p style="margin: 0 0 10px 0; color: #ffffff; font-weight: 500; letter-spacing: 1px;">ESCANDASHOP S.L.</p>
                            <p style="margin: 0 0 20px 0; font-style: italic; color: #888;">"La elegancia es la única belleza que nunca se desvanece."</p>
                            <p style="margin: 0 0 5px 0;">Recibiste este correo porque estás registrado en nuestra tienda online.</p>
                            <p style="margin: 0 0 20px 0;">Si tienes alguna pregunta, contáctanos en <a href="mailto:soporte@escandashop.com" style="color: #d4af37; text-decoration: none;">soporte@escandashop.com</a></p>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center" style="border-top: 1px solid #333; padding-top: 20px;">
                                        <span style="margin: 0 10px; color: #888;">© {{ date('Y') }} EscandaShop. Todos los derechos reservados.</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
