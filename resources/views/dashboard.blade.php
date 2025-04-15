<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
    <div class="container mt-5">
        <h1>Bienvenido al sistema System Stock</h1>
        <p>Has iniciado sesión correctamente.</p>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-danger mt-3">Cerrar sesión</button>
        </form>
    </div>
</body>
</html>
