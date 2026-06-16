<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda JCTE Ocosingo 2026</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, Helvetica, sans-serif;
            background: #ffffff;
            color: #593F26;
            padding: 24px;
        }
        .welcome {
            width: 100%;
            max-width: 760px;
            border: 3px solid #C79A59;
            padding: 42px;
            text-align: center;
            background: #ffffff;
        }
        .welcome img {
            width: 180px;
            max-width: 70%;
            margin-bottom: 22px;
        }
        h1 {
            color: #6B0F15;
            font-size: 2.4rem;
            margin-bottom: 12px;
        }
        p {
            color: #593F26;
            font-size: 1.05rem;
            margin-bottom: 24px;
        }
        a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 10px 18px;
            background: #C79A59;
            color: #6B0F15;
            font-weight: 800;
            text-decoration: none;
        }
        a:hover {
            background: #BF845B;
            color: #ffffff;
        }
    </style>
</head>
<body>
    <main class="welcome">
        <img src="{{ asset('img/logo2.png') }}" alt="Agenda JCTE">
        <h1>Agenda JCTE Ocosingo 2026</h1>
        <p>Sistema de gestion de audiencias.</p>
        <a href="{{ route('auth.login') }}">Iniciar sesion</a>
    </main>
</body>
</html>
