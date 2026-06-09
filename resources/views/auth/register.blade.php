<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Agenda JCTE Ocosingo 2026</title>

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

        .container {
            width: 100%;
            max-width: 1500px;
            background: #fff;
            border: 3px solid #d8d8d8;
            border-radius: 30px;
            padding: 45px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
            position: relative;
            overflow: hidden;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 620px;
            transform: translate(-50%, -50%);
            opacity: 0.08;
            pointer-events: none;
        }

        .heading {
            text-align: center;
            margin-bottom: 35px;
        }

        .heading img {
            width: 200px;
            margin-bottom: 3px;
        }

        .heading h1 {
            color: #780c16;
            font-size: 1.8rem;
            line-height: 1.05;
            margin-bottom: 1px;
        }

        .heading h2 {
            color: #780c16;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            align-items: flex-start;
        }

        .form-full {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            text-align: left;
            font-size: 1.05rem;
            font-weight: bold;
            color: #654726;
            margin-bottom: 8px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            height: 48px;
            border: 4px solid #654726;
            border-radius: 40px;
            padding: 0 15px;
            font-size: 14px;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #a35a31;
        }

        .btn-submit {
            display: block;
            width: 100%;
            background: #a35a31;
            color: white;
            border: none;
            border-radius: 40px;
            padding: 16px 0;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s, transform 0.3s;
        }

        .btn-submit:hover {
            background: #874725;
            transform: translateY(-2px);
        }

        .alert {
            padding: 14px;
            border-radius: 14px;
            margin-bottom: 24px;
            background: #ffe6e6;
            color: #b30000;
            border: 1px solid #ffbcbc;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 1rem;
        }

        .login-link a {
            color: #780c16;
            font-weight: bold;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 760px) {
            .container {
                padding: 30px 20px;
            }

            .heading h1 {
                font-size: 2.4rem;
            }

            .heading h2 {
                font-size: 1.7rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .form-group label {
                font-size: 1.25rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="{{ asset('img/fondo.png') }}" alt="Marca de agua" class="watermark">

        <div class="heading">
            <img src="{{ asset('img/logo2.png') }}" alt="Logo Agenda JCTE">
            <h1>Agenda JCTE</h1>
            <h2>Ocosingo 2026</h2>
        </div>

        @if ($errors->any())
            <div class="alert">
                <strong>Errores:</strong>
                <ul style="margin-top: 12px; margin-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('auth.store') }}" method="POST" class="form-row">
            @csrf

            <div class="form-group">
                <label for="name">Nombre Completo</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="username">Usuario</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" required>
            </div>

            <div class="form-group">
                <label for="puesto">Puesto</label>
                <input type="text" id="puesto" name="puesto" value="{{ old('puesto') }}" required>
            </div>

            <div class="form-group">
                <label for="roles_id">Rol</label>
                <select id="roles_id" name="roles_id" required>
                    <option value="">Selecciona un rol</option>
                    @foreach (\App\Models\Role::all() as $role)
                        <option value="{{ $role->id }}" {{ old('roles_id') == $role->id ? 'selected' : '' }}>
                            {{ $role->tipo }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmar Contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <div class="form-full">
                <button type="submit" class="btn-submit">Crear Cuenta</button>
            </div>
        </form>

        <div class="login-link">
            ¿Ya tienes cuenta? <a href="{{ route('auth.showLogin') }}">Inicia sesión aquí</a>
        </div>
    </div>
</body>

</html>
