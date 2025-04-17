@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

<<<<<<< HEAD
@section('content') 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Stock - Usuarios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            background-color: #f5f5f5;
        }
        
        /* Barra de navegación superior */
        .top-nav {
            background-color: #333;
            color: white;
            padding: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
        
        .top-nav-left {
            display: flex;
            align-items: center;
        }
        
        .top-nav-right {
            display: flex;
            align-items: center;
        }
        
        .nav-icon {
            color: white;
            margin: 0 5px;
            cursor: pointer;
        }
           
        /* Contenido principal */
        .main-content {
            margin-left: 200px;
            padding: 80px 20px 20px;
            width: calc(100% - 200px);
        }
        
        .content-container {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
        }
        
        /* Barra de acción */
        .action-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            align-items: center;
        }
        
        .left-actions {
            display: flex;
        }
        
        .action-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 16px;
            margin-right: 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .action-button:hover {
            background-color: #45a049;
        }
        
        .action-button.export {
            background-color: #2196F3;
        }
        
        .action-button.export:hover {
            background-color: #0b7dda;
        }
        
        .search-input {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 250px;
        }
        
        /* Tabla de usuarios */
        .users-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        .users-table th, .users-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        
        .users-table th {
            background-color: #f2f2f2;
            position: sticky;
            top: 0;
        }
        
        .users-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .users-table tr:hover {
            background-color: #f1f1f1;
        }
        
        .action-cell a {
            text-decoration: none;
            color: #0066cc;
            margin: 0 5px;
        }
        
        .action-cell a:hover {
            text-decoration: underline;
        }
        
        /* Formulario modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 70%;
            max-width: 800px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            animation: modalopen 0.4s;
            margin-left: calc(200px + 15%);
        }
        
        @keyframes modalopen {
            from {opacity: 0; transform: translateY(-50px);}
            to {opacity: 1; transform: translateY(0);}
        }
        
        .close-button {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .close-button:hover {
            color: black;
        }
        
        .form-title {
            margin-top: 0;
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        
        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }
        
        .form-group {
            flex: 1 0 calc(50% - 20px);
            margin: 0 10px 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        .form-buttons {
            text-align: center;
            margin-top: 20px;
        }
        
        .form-buttons button {
            padding: 10px 20px;
            margin: 0 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .save-button {
            background-color: #4CAF50;
            color: white;
        }
        
        .cancel-button {
            background-color: #f44336;
            color: white;
        }
        
        .logout-button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
    </style>
</head>
<body> 
    <!-- Contenido principal -->
    <div class="main-content">
        <div class="content-container">
            <div class="action-bar">
                <div class="left-actions">
                    <button class="action-button" id="crearButton">Crear</button>
                    <button class="action-button export">Exportar</button>
                </div>
                <input type="text" class="search-input" placeholder="Buscar usuario..." id="buscarUsuario">
            </div>
            
            <div class="table-container">
                <table class="users-table" id="tablaUsuarios">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>CI</th>
                            <th>Teléfono</th>
                            <th>Usuario</th>
                            <th>Contraseña</th>
                            <th>Correo Electrónico</th>
                            <th>Rol</th>
                            <th>Fecha</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpoTabla">
                        <!-- Los datos se cargarán dinámicamente -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Modal de formulario -->
    <div id="crearModal" class="modal">
        <div class="modal-content">
            <span class="close-button" id="closeModal">&times;</span>
            <h2 class="form-title">Crear Nuevo Usuario</h2>
            <form id="formUsuario">
                <div class="form-row">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido:</label>
                        <input type="text" id="apellido" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="ci">CI:</label>
                        <input type="text" id="ci" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <input type="tel" id="telefono" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="usuario">Usuario:</label>
                        <input type="text" id="usuario" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="contrasena">Contraseña:</label>
                        <input type="password" id="contrasena" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Correo Electrónico:</label>
                        <input type="email" id="email" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="rol">Rol:</label>
                        <select id="rol" class="form-control" required>
                            <option value="">Seleccione un rol</option>
                            <option value="Administrador">Administrador</option>
                            <option value="Usuario">Usuario</option>
                            <option value="Editor">Editor</option>
                            <option value="Invitado">Invitado</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fecha">Fecha:</label>
                        <input type="date" id="fecha" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-buttons">
                    <button type="submit" class="save-button">Guardar</button>
                    <button type="button" class="cancel-button" id="cancelarForm">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // Datos de ejemplo para la tabla
        const usuarios = [
            {
                id: 1,
                nombre: 'Juan',
                apellido: 'Pérez',
                ci: '1234567',
                telefono: '555-123-4567',
                usuario: 'jperez',
                contrasena: '••••••••',
                email: 'juan.perez@ejemplo.com',
                rol: 'Administrador',
                fecha: '2025-04-10'
            },
            {
                id: 2,
                nombre: 'María',
                apellido: 'López',
                ci: '7654321',
                telefono: '555-765-4321',
                usuario: 'mlopez',
                contrasena: '••••••••',
                email: 'maria.lopez@ejemplo.com',
                rol: 'Almacenero',
                fecha: '2025-04-12'
            }
        ];
=======
>>>>>>> 36dca72 (vista de usuario terminado y funcional)

@section('content')
<style>
  .content-container {
    padding: 2rem;
    background-color: #ffffff;
    font-family: 'Quicksand', sans-serif;
    animation: fadeIn 0.8s ease-in-out;
    border-radius: 16px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
  }

  .form-control, .form-select {
    border-radius: 10px;
    border: 1px solid #cce6ff;
  }

  .form-control:focus, .form-select:focus {
    border-color: #3399ff;
    box-shadow: 0 0 6px rgba(0, 102, 255, 0.25);
  }

  .btn-crear {
    background: linear-gradient(to right, #4facfe, #00f2fe);
    border: none;
    border-radius: 8px;
    color: white;
    font-weight: 600;
    padding: 10px 20px;
    transition: all 0.3s ease;
  }

  .btn-exportar {
    background: linear-gradient(to right, #f7971e, #ffd200);
    border: none;
    border-radius: 8px;
    color: white;
    font-weight: 600;
    padding: 10px 20px;
    transition: all 0.3s ease;
  }

  .btn-crear:hover {
    background: linear-gradient(to right, #00c6ff, #0072ff);
    box-shadow: 0 0 12px rgba(0, 123, 255, 0.4);
  }

  .btn-exportar:hover {
    background: linear-gradient(to right, #ffd200, #f7971e);
    box-shadow: 0 0 12px rgba(255, 193, 7, 0.4);
  }

  .users-table {
    min-width: 100%;
  }

  .table-responsive {
    margin-top: 1rem;
    overflow-x: auto;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
  }
</style>
@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
  </div>
@endif
@if ($errors->any())
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var modalCrear = new bootstrap.Modal(document.getElementById('modalCrearUsuario'));
      modalCrear.show();
    });
  </script>
@endif
@error('correo')
  <small class="text-danger">{{ $message }}</small>
@enderror



<div class="content-container">
  <div class="row align-items-center mb-4 g-2">
    <div class="col-md-auto d-flex flex-wrap gap-2">
      <button class="btn-crear" data-bs-toggle="modal" data-bs-target="#modalCrearUsuario">
        <i class="fas fa-plus"></i> Crear
      </button>
      <button class="btn-exportar" data-bs-toggle="modal" data-bs-target="#modalExportarUsuarios">
        <i class="fas fa-file-export"></i> Exportar
      </button>
    </div>
    <div class="col-md-auto ms-auto">
    <input type="text" class="form-control" placeholder="Buscar usuario..." id="buscarUsuario" style="max-width: 220px;">
    </div>

  </div>

  <div class="table-responsive">
  <table class="users-table table table-bordered table-hover text-center">
    <thead class="table-primary">
      <tr>
        <th>ID</th>
        <th>Nombre y apellido</th>
        <th>Cédula de Identidad</th>
        <th>Correo Electrónico</th>
        <th>Roles</th>
        <th>Acción</th>
      </tr>
    </thead>
    <tbody>
      @forelse($usuarios as $usuario)
        <tr>
          <td>{{ $usuario->id_usuario }}</td>
          <td>{{ $usuario->nombre }}</td>
          <td>{{ $usuario->documento_identidad }}</td>
          <td>{{ $usuario->correo }}</td>
          <td>{{ ucfirst($usuario->rol) }}</td>

          <td>
            <div class="d-flex justify-content-center gap-2">

              <!-- Ver -->
              <button class="btn btn-sm btn-info text-white"
                      data-bs-toggle="modal"
                      data-bs-target="#modalVerUsuario"
                      onclick='verUsuario({!! json_encode($usuario) !!})'
                      title="Ver usuario">
                <i class="fas fa-eye"></i>
              </button>

              <!-- Editar -->
              <button class="btn btn-sm btn-warning"
                      data-bs-toggle="modal"
                      data-bs-target="#modalEditarUsuario"
                      onclick='llenarModal({!! json_encode($usuario) !!})'
                      title="Editar usuario">
                <i class="fas fa-edit"></i>
              </button>

              <!-- Eliminar -->
              <button class="btn btn-sm btn-danger"
                      data-bs-toggle="modal"
                      data-bs-target="#modalEliminarUsuario"
                      data-id="{{ $usuario->id_usuario }}"
                      data-nombre="{{ $usuario->nombre }}"
                      title="Eliminar usuario">
                <i class="bi bi-trash"></i>
              </button>

            </div>
          </td>
        </tr>
      @empty
        <tr><td colspan="6">No hay usuarios registrados.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

</div>

<!-- Modal Crear Usuario -->
<div class="modal fade" id="modalCrearUsuario" tabindex="-1" aria-labelledby="modalCrearUsuarioLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modalCrearUsuarioLabel">Registrar Nuevo Usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Nombre y apellido</label>
              <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
              @error('nombre')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-md-6">
              <label class="form-label">Cédula de Identidad</label>
              <input type="text" name="documento_identidad" class="form-control" value="{{ old('documento_identidad') }}" required>
              @error('documento_identidad')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-md-6">
              <label class="form-label">Correo Electrónico</label>
              <input type="email" name="correo" class="form-control" value="{{ old('correo') }}" required>
              @error('correo')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-md-6">
              <label class="form-label">Contraseña</label>
              <input type="password" name="contrasena" class="form-control" required>
              @error('contrasena')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-md-6">
              <label class="form-label">Rol</label>
              <select name="rol" class="form-select" required>
                <option value="">Seleccione un rol</option>
                <option value="Administrador" {{ old('rol') == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                <option value="Usuario" {{ old('rol') == 'Usuario' ? 'selected' : '' }}>Usuario</option>
                <option value="registrador" {{ old('rol') == 'registrador' ? 'selected' : '' }}>Registrador</option>
              </select>
              @error('rol')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal Editar Usuario -->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" id="formEditar" action="">
        @csrf
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalEditarUsuarioLabel">Editar Usuario</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Nombre y Apellido</label>
              <input type="text" name="nombre" id="edit_nombre" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Cédula de Identidad</label>
              <input type="text" name="documento_identidad" id="edit_ci" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Correo Electrónico</label>
              <input type="email" name="correo" id="edit_correo" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Rol</label>
              <select name="rol" id="edit_rol" class="form-select" required>
                <option value="Administrador">Administrador</option>
                <option value="registrador">Registrador</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Actualizar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal ver Usuario -->
<div class="modal fade" id="modalVerUsuario" tabindex="-1" aria-labelledby="modalVerUsuarioLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="modalVerUsuarioLabel">Detalle del Usuario</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nombre</label>
            <input type="text" id="ver_nombre" class="form-control" readonly>
          </div>
          <div class="col-md-6">
            <label class="form-label">CI</label>
            <input type="text" id="ver_ci" class="form-control" readonly>
          </div>
          <div class="col-md-6">
            <label class="form-label">Correo</label>
            <input type="email" id="ver_correo" class="form-control" readonly>
          </div>
          <div class="col-md-6">
            <label class="form-label">Rol</label>
            <input type="text" id="ver_rol" class="form-control" readonly>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Eliminar Usuario -->
<div class="modal fade" id="modalEliminarUsuario" tabindex="-1" aria-labelledby="modalEliminarUsuarioLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow rounded-4">
      <form id="formEliminarUsuario" method="POST">
        @csrf
        @method('DELETE')
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title"><i class="bi bi-exclamation-triangle me-2"></i> Confirmar Eliminación</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          ¿Seguro que deseas eliminar a <strong id="nombreUsuarioEliminar"></strong>?
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Eliminar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Exportar Usuarios -->
<div class="modal fade" id="modalExportarUsuarios" tabindex="-1" aria-labelledby="modalExportarUsuariosLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content border-0 shadow rounded-4">
      <div class="modal-header bg-primary text-white rounded-top-4">
        <h5 class="modal-title" id="modalExportarUsuariosLabel">
          <i class="fas fa-table me-2"></i>Datos de Usuarios
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body p-4" style="background-color: #f9fbff;">
        <div class="table-responsive">
          <table class="table table-bordered table-striped text-center align-middle">
            <thead class="table-primary">
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
                <td>{{ $usuario->rol }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer bg-light rounded-bottom-4">
        <a href="{{ route('usuarios.export.excel') }}" class="btn btn-success">
          <i class="fas fa-file-excel me-1"></i> Descargar Excel
        </a>
        <a href="{{ route('usuarios.export.pdf') }}" class="btn btn-danger">
          <i class="fas fa-file-pdf me-1"></i> Descargar PDF
        </a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="bi bi-x-circle me-1"></i> Cerrar
        </button>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script>
  // Asignar accion de los botones de editar usuario
  function llenarModal(usuario) {
    document.getElementById('edit_nombre').value = usuario.nombre;
    document.getElementById('edit_ci').value = usuario.documento_identidad;
    document.getElementById('edit_correo').value = usuario.correo;
    document.getElementById('edit_rol').value = usuario.rol;

    // Asignar acción al form con el ID del usuario
    document.getElementById('formEditar').action = `/usuarios/${usuario.id_usuario}/actualizar`;
  }

  function verUsuario(usuario) {
    document.getElementById('ver_nombre').value = usuario.nombre;
    document.getElementById('ver_ci').value = usuario.documento_identidad;
    document.getElementById('ver_correo').value = usuario.correo;
    document.getElementById('ver_rol').value = usuario.rol;
  }
  const eliminarModal = document.getElementById('modalEliminarUsuario');
  eliminarModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const id = button.getAttribute('data-id');
    const nombre = button.getAttribute('data-nombre');

    document.getElementById('nombreUsuarioEliminar').textContent = nombre;

    const form = document.getElementById('formEliminarUsuario');
    form.action = `/usuarios/${id}`;
  });

  document.querySelectorAll('[title]').forEach(el => {
    new bootstrap.Tooltip(el)
  });

  document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('buscarUsuario');
    const filas = document.querySelectorAll('.users-table tbody tr');

    input.addEventListener('input', function () {
      const valor = this.value.toLowerCase();

      filas.forEach(fila => {
        const nombre = fila.children[1]?.textContent.toLowerCase() || '';
        const cedula = fila.children[2]?.textContent.toLowerCase() || '';
        const correo = fila.children[3]?.textContent.toLowerCase() || '';

        if (nombre.includes(valor) || cedula.includes(valor) || correo.includes(valor)) {
          fila.style.display = '';
        } else {
          fila.style.display = 'none';
        }
      });
    });
  });
</script>
@endpush

@endsection

