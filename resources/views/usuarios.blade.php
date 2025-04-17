@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

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

