<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Bienvenido a {{ config('app.name') }}!</title>
    <style>
        /* Estilos generales */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .email-wrapper {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin: 20px 0;
        }

        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }

        .logo {
            max-width: 150px;
            height: auto;
            margin-bottom: 20px;
        }

        .welcome-message {
            color: #333333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .content {
            color: #666666;
            font-size: 16px;
            margin: 20px 0;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4CAF50;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #45a049;
        }

        .footer {
            text-align: center;
            color: #999999;
            font-size: 14px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #f0f0f0;
        }

        .social-links {
            margin: 20px 0;
        }

        .social-links a {
            margin: 0 10px;
            color: #666666;
            text-decoration: none;
        }

        .highlight {
            color: #4CAF50;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="email-wrapper">
            <div class="header">
                @if (config('app.logo'))
                    <img src="{{ config('app.logo') }}" alt="Logo" class="logo">
                @endif
                <h1 class="welcome-message">¡Bienvenido {{ $user->name }}!</h1>
            </div>

            <div class="content">
                <p>Nos alegra mucho tenerte con nosotros. Tu cuenta ha sido creada exitosamente con el email <span
                        class="highlight">{{ $user->email }}</span>.</p>

                <p>Para comenzar a disfrutar de todos nuestros servicios, por favor verifica tu dirección de correo
                    electrónico haciendo clic en el botón de abajo:</p>

                <div style="text-align: center;">
                    <a href="{{ route('verify.email.token', ['token' => $user->verification_token]) }}" class="button">
                        Verificar mi correo electrónico
                    </a>
                </div>

                <p>Si el botón no funciona, puedes copiar y pegar el siguiente enlace en tu navegador:</p>
                <p style="word-break: break-all; font-size: 14px; color: #888888;">
                    {{ route('verify.email.token', ['token' => $user->verification_token]) }}
                </p>

                <p>Algunos beneficios de verificar tu cuenta:</p>
                <ul>
                    <li>Acceso completo a todas las funcionalidades</li>
                    <li>Notificaciones importantes sobre tu cuenta</li>
                    <li>Mayor seguridad en tus operaciones</li>
                </ul>
            </div>

            <div class="footer">
                <p>Este enlace de verificación expirará en 24 horas.</p>
                <p>Si no creaste esta cuenta, puedes ignorar este mensaje.</p>

                {{-- <div class="social-links">
                    @if (config('social.facebook'))
                        <a href="{{ config('social.facebook') }}">Facebook</a>
                    @endif
                    @if (config('social.twitter'))
                        <a href="{{ config('social.twitter') }}">Twitter</a>
                    @endif
                    @if (config('social.instagram'))
                        <a href="{{ config('social.instagram') }}">Instagram</a>
                    @endif
                </div> --}}

                <p>© {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
                <p style="font-size: 12px;">
                    {{ config('app.address', 'Dirección de la empresa') }}<br>
                    No responder a este correo electrónico
                </p>
            </div>
        </div>
    </div>
</body>

</html>
