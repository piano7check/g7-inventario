<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'System Stock')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 230px;
            height: 100vh;
            background-color: #e6f0ff;
            padding-top: 2rem;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

        .sidebar h4 {
            text-align: center;
            color: #004080;
            margin-bottom: 2rem;
        }

        .sidebar a {
            display: block;
            padding: 15px 20px;
            color: #004080;
            text-decoration: none;
            transition: background 0.2s;
        }

        .sidebar a:hover {
            background-color: #cce0ff;
            font-weight: bold;
        }

        .content {
            margin-left: 230px;
            padding: 2rem;
            background-color: #f7fbff;
            min-height: 100vh;
        }

        .logout {
            position: absolute;
            top: 10px;
            right: 20px;
        }
    </style>
    @yield('styles')
</head>
<body>

    <div class="sidebar">
        <h4>System Stock</h4>
        <a href="{{ url('/dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
        <a href="{{ url('/productos') }}"><i class="bi bi-box-seam me-2"></i>Productos</a>
        <a href="{{ url('/usuarios') }}"><i class="bi bi-people-fill me-2"></i>Usuarios</a>
        <a href="{{ url('/movimientos') }}"><i class="bi bi-arrow-left-right me-2"></i>Movimientos</a>
        <a href="{{ url('/reportes') }}"><i class="bi bi-file-earmark-bar-graph-fill me-2"></i>Reportes</a>
    </div>

    <div class="content">
        <form action="{{ route('logout') }}" method="POST" class="logout">
            @csrf
            <button class="btn btn-sm btn-danger">Cerrar sesión</button>
        </form>

        @yield('content')
    </div>

</body>
</html>
