<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'System Stock')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Bootstrap + Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Estilos generales --}}
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f7fbff;
        }

        .sidebar {
            width: 230px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #004080;
            color: white;
            padding: 1.5rem 1rem;
            transition: all 0.3s ease;
        }

        .sidebar h4 {
            text-align: center;
            margin-bottom: 2rem;
            font-weight: bold;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            padding: 10px 15px;
            margin-bottom: 10px;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.2s ease;
        }

        .sidebar a:hover {
            background-color: #cce0ff;
            color: #004080;
            font-weight: bold;
        }

        .content {
            margin-left: 230px;
            padding: 2rem;
            min-height: 100vh;
            animation: fadeIn 0.4s ease-in-out;
        }

        .logout {
            position: absolute;
            top: 15px;
            right: 30px;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                display: flex;
                flex-direction: row;
                overflow-x: auto;
            }

            .sidebar h4 {
                display: none;
            }

            .sidebar a {
                flex: 1;
                justify-content: center;
                padding: 0.8rem;
                font-size: 0.9rem;
            }

            .content {
                margin-left: 0;
                padding: 1.2rem;
            }

            .logout {
                position: static;
                text-align: right;
                margin-bottom: 1rem;
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    @yield('styles')
</head>
<body>

    {{-- Menú lateral --}}
    <div class="sidebar">
        <h4><i class="bi bi-box-seam"></i> System Stock</h4>
        @if(auth()->user()->rol == 'administrador')
            <a href="{{ url('/inventario/dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
        @endif
        <a href="{{ url('/productos') }}"><i class="bi bi-box"></i> Productos</a>
        <a href="{{ url('/inventario') }}"><i class="bi bi-clipboard-data"></i> Inventario</a>
        
        @if(auth()->user()->rol == 'administrador')
            <a href="{{ url('/inventario/conteo-fisico') }}"><i class="bi bi-list-check"></i> Conteo Físico</a>
            <a href="{{ url('/usuarios') }}"><i class="bi bi-people-fill"></i> Usuarios</a>
            <a href="{{ url('/reportes') }}"><i class="bi bi-bar-chart-fill"></i> Reportes</a>
        @endif
    </div>

    {{-- Contenido principal --}}
    <div class="content">
        <form action="{{ route('logout') }}" method="POST" class="logout">
            @csrf
            <button class="btn btn-sm btn-danger"><i class="bi bi-box-arrow-right me-1"></i> Cerrar sesión</button>
        </form>

        @yield('content')
    </div>
    <h1></h1>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')   

</body>
</html>
