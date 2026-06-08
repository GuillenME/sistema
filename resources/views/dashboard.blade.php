<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
        }
        .navbar {
            background: linear-gradient(135deg, #ffffff 0%, #ffffff 100%);
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar h2 {
            font-size: 24px;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid white;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
            text-decoration: none;
            font-size: 14px;
        }
        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .welcome-card {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
        }
        .welcome-card h1 {
            color: #333;
            margin-bottom: 20px;
        }
        .welcome-card p {
            color: #666;
            line-height: 1.6;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .info-card {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        .info-card h3 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 14px;
            text-transform: uppercase;
        }
        .info-card p {
            color: #333;
            font-size: 18px;
            font-weight: 600;
        }
        .alert {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>Sistema</h2>
        <div class="user-info">
            <span>Hola, <strong>{{ Auth::user()->name }}</strong></span>
            <form action="{{ route('auth.logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">Cerrar Sesión</button>
            </form>
        </div>
    </div>

    <div class="container">
        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <div class="welcome-card">
            <h1>¡Bienvenido, {{ Auth::user()->name }}!</h1>
            <p>Has iniciado sesión correctamente en el sistema. Desde aquí puedes acceder a todas las funcionalidades disponibles según tu rol.</p>

            <div class="info-grid">
                <div class="info-card">
                    <h3>Usuario</h3>
                    <p>{{ Auth::user()->username }}</p>
                </div>
                <div class="info-card">
                    <h3>Puesto</h3>
                    <p>{{ Auth::user()->puesto }}</p>
                </div>
                <div class="info-card">
                    <h3>Rol</h3>
                    <p>{{ Auth::user()->role->tipo ?? 'N/A' }}</p>
                </div>
                <div class="info-card">
                    <h3>Email</h3>
                    <p>{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
