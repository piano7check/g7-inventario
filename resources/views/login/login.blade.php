<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - System Stock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Quicksand', sans-serif;
        }

        body {
            background: url('images/comedor_uab_login.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 3rem;
            border-radius: 16px;
            box-shadow: 0 0 30px rgba(0, 128, 255, 0.2);
            width: 100%;
            max-width: 420px;
            animation: fadeIn 0.8s ease-in-out;
        }

        .login-card h3 {
            text-align: center;
            margin-bottom: 2rem;
            color: #006bb3;
        }

        .form-label {
            font-weight: bold;
            color: #004080;
        }

        .form-control {
            border: 1px solid #cce6ff;
            border-radius: 8px;
        }

        .form-control:focus {
            border-color: #3399ff;
            box-shadow: 0 0 5px rgba(0, 102, 255, 0.3);
        }

        .btn-login {
            background: linear-gradient(to right, #66ccff, #3399ff);
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: linear-gradient(to right, #3399ff, #006bb3);
            box-shadow: 0 0 10px rgba(0, 102, 255, 0.5);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .text-danger {
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
<div class="login-card">
    <h3>System Stock</h3>
    <form method="POST" action="{{ route('login.submit') }}">
        @csrf
        <div class="mb-3">
            <label for="correo" class="form-label">Correo electrónico</label>
            <input type="email" name="correo" class="form-control" placeholder="ejemplo@uab.com" required>
        </div>
        <div class="mb-4">
            <label for="contrasena" class="form-label">Contraseña</label>
            <input type="password" name="contrasena" class="form-control" placeholder="••••••••" required>
        </div>
        <button type="submit" class="btn btn-login w-100 py-2">Ingresar</button>
        @error('correo')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </form>
</div>
</body>
</html>
