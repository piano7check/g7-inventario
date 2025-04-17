<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Listado de Usuarios</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      font-size: 12px;
      margin: 20px;
      background-color: #ffffff;
      color: #333;
    }

    h2 {
      text-align: center;
      color: #004080;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 10px;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 8px 10px;
      text-align: center;
      vertical-align: middle;
    }

    th {
      background-color: #cce5ff;
      color: #003366;
    }

    tr:nth-child(even) {
      background-color: #f2f7fb;
    }

    .footer {
      font-size: 10px;
      text-align: center;
      color: #777;
      margin-top: 30px;
    }
  </style>
</head>
<body>

  <h2>Listado de Usuarios</h2>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>C.I.</th>
        <th>Correo</th>
        <th>Rol</th>
      </tr>
    </thead>
    <tbody>
      @foreach($usuarios as $usuario)
        <tr>
          <td>{{ $usuario->id_usuario }}</td>
          <td>{{ $usuario->nombre }}</td>
          <td>{{ $usuario->documento_identidad }}</td>
          <td>{{ $usuario->correo }}</td>
          <td>{{ ucfirst($usuario->rol) }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <div class="footer">
    Generado automáticamente por System Stock UAB - {{ now()->format('d/m/Y H:i') }}
  </div>

</body>
</html>
