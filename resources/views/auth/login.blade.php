<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda JCTE Ocosingo 2026</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .wrapper {
            width: 95%;
            max-width: 1750px;
        }

        /* CONTENEDOR PRINCIPAL */
        .contenedor {
            position: relative;
            background: #fff;
            border: 3px solid #d8d8d8;
            border-radius: 10px;
            min-height: 750px;
            display: flex;
            overflow: hidden;
        }

        /* MARCA DE AGUA */
        .marca-agua {
            position: absolute;
            width: 520px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: .9;
            z-index: 1;
            pointer-events: none;
        }

        /* COLUMNA IZQUIERDA */
        .izquierda {
            width: 60%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 2;
            padding: 50px;
        }

        .logo {
            width: 400px;
            margin-bottom: 25px;
        }

        .titulo {
            text-align: center;
        }

        .titulo h1 {
            font-size: 4rem;
            color: #780c16;
            line-height: 1.1;
            font-weight: bold;
        }

        .titulo h2 {
            font-size: 4rem;
            color: #780c16;
            line-height: 1.1;
            font-weight: bold;
        }

        /* DIVISOR */
        .divisor {
            width: 2px;
            background: #d8d8d8;
            height: 75%;
            align-self: center;
            z-index: 2;
        }

        /* COLUMNA DERECHA */
        .derecha {
            width: 60%;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 2;
            padding: 40px;
        }

        .login-box {
            width: 630px;
            background: #fafafa00;
            border: 3px solid #cfcfcf;
            border-radius: 35px;
            padding: 40px;
        }

        .form-group {
            margin-bottom: 35px;
        }

        .form-group label {
            display: block;
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
            color: #654726;
            margin-bottom: 12px;
        }

        .form-group input {
            width: 100%;
            height: 55px;
            border: 4px solid #654726;
            border-radius: 40px;
            padding: 0 20px;
            font-size: 16px;
        }

        .form-group input:focus {
            outline: none;
        }

        .btn-login {
            display: block;
            margin: auto;
            background: #a35a31;
            color: white;
            border: none;
            border-radius: 40px;
            padding: 14px 40px;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            transition: .3s;
        }

        .btn-login:hover {
            background: #874725;
        }

        /* MENSAJES */
        .alert {
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .alert-danger {
            background: #ffe6e6;
            color: #b30000;
            border: 1px solid #ffbcbc;
        }

        .register-link {
            margin-top: 25px;
            text-align: center;
            font-size: .95rem;
        }

        .register-link a {
            color: #780c16;
            font-weight: bold;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        /* FRANJA INFERIOR */
        .franja {
            width: 100%;
            height: 50px;
            object-fit: cover;
            display: block;
            margin-top: 2px;
            border-radius: 10px;
        }

        /* RESPONSIVE */
        @media (max-width: 900px) {

            .contenedor {
                flex-direction: column;
            }

            .izquierda,
            .derecha {
                width: 100%;
            }

            .divisor {
                display: none;
            }

            .logo {
                width: 160px;
            }

            .titulo h1,
            .titulo h2 {
                font-size: 2.5rem;
            }

            .login-box {
                width: 100%;
                max-width: 450px;
            }

            .marca-agua {
                width: 250px;
            }
        }
    </style>
</head>

<body>

    <div class="wrapper">

        <div class="contenedor">

            <!-- Marca de agua -->
            <img src="{{ asset('img/fondo.png') }}" alt="Marca de agua" class="marca-agua">

            <!-- IZQUIERDA -->
            <div class="izquierda">

                <img src="{{ asset('img/logo2.png') }}" alt="Logo Poder Judicial" class="logo">

                <div class="titulo">
                    <h1>Agenda JCTE</h1>
                    <h2>Ocosingo 2026</h2>
                </div>

            </div>

            <!-- Línea divisoria -->
            <div class="divisor"></div>

            <!-- DERECHA -->
            <div class="derecha">

                <div class="login-box">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('auth.authenticate') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="username">Usuario</label>
                            <input type="text" id="username" name="username" value="{{ old('username') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" id="password" name="password" required>
                        </div>

                        <button type="submit" class="btn-login">
                            Iniciar sesión
                        </button>

                    </form>

                    <div class="register-link">
                        ¿No tienes cuenta?
                        <a href="{{ route('auth.showRegister') }}">
                            Regístrate aquí
                        </a>
                    </div>

                </div>

            </div>

        </div>

        <!-- Franja decorativa -->
        <img src="{{ asset('img/franja.png') }}" alt="Franja decorativa" class="franja">

    </div>

</body>

</html>
