@extends('layouts.app')

@section('content')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600&family=DM+Sans:wght@500&display=swap');

  body {
    background: linear-gradient(to right, #f8f9ff, #ecf2ff);
    font-family: 'DM Sans', sans-serif;
  }

  .content-container {
    padding: 2rem;
    background-color: #ffffffcc;
    font-family: 'DM Sans', sans-serif;
    animation: fadeIn 0.8s ease-in-out;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
  }

  h1, h2, h3 {
    font-family: 'Quicksand', sans-serif;
    font-weight: 600;
    color: #354259;
  }

  .form-control, .form-select {
    border-radius: 12px;
    border: 1px solid #d4e1f4;
    background-color: #f6f9ff;
    transition: all 0.3s ease-in-out;
  }

  .form-control:focus, .form-select:focus {
    border-color: #7ea8ff;
    box-shadow: 0 0 10px rgba(112, 172, 255, 0.4);
  }

  .btn-crear {
    background: linear-gradient(to right, #85F3FF, #91EAE4);
    border: none;
    border-radius: 10px;
    color: #213547;
    font-weight: 600;
    padding: 10px 24px;
    transition: 0.3s ease-in-out;
  }

  .btn-crear:hover {
    background: linear-gradient(to right, #7cd7ff, #a2f2eb);
    box-shadow: 0 0 10px rgba(0, 140, 255, 0.3);
    transform: translateY(-2px);
  }

  .table-responsive {
    margin-top: 1.5rem;
    overflow-x: auto;
    width: 96%;
    margin-left: auto;
    margin-right: auto;
  }

  .table {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
  }

  .table thead th {
    background-color: #ddeeff;
    color: #2e3d59;
    font-weight: 600;
    padding: 14px 16px;
  }

  .table tbody td {
    background-color: #ffffff;
    border-top: 1px solid #edf2f7;
    color: #333;
    padding: 12px 14px;
  }

  .table tbody tr:hover {
    background-color: #f0f8ff;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-15px); }
    to { opacity: 1; transform: translateY(0); }
  }
</style>


<div class="container-fluid mt-5">
    <h1 class="text-center mb-4 fw-bold display-5 text-primary">Gestión de Productos</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#crearProductoModal">
        Agregar Producto
    </button>

    <form method="GET" action="{{ route('productos.index') }}" class="row g-3 mb-3">
        <div class="col-md-4">
            <input type="text" name="buscar" class="form-control" placeholder="Buscar por nombre o código" value="{{ request('buscar') }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-outline-primary">Buscar</button>
            <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary">Limpiar</a>
        </div>
    </form>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Código</th>
                            <th>Unidad de Medida</th>
                            <th>Categoría</th>
                            <th>Cantidad</th>
                            <th>Observación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productos as $producto)
                            <tr>
                                <td>{{ $producto->id_producto }}</td>
                                <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->codigo }}</td>
                                <td>{{ $producto->unidad_medida }}</td>
                                <td>{{ $producto->categoria }}</td>
                                <td>{{ $producto->cantidad }}</td>
                                <td>{{ $producto->observacion }}</td>
                                <td>
                                    <!-- Botón Editar -->
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $producto->Id_producto }}">
                                        Editar
                                    </button>

                                    <!-- Botón Eliminar -->
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalEliminar{{ $producto->id_producto }}">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- .table-responsive -->

            <!-- 🔽 Modales de confirmación para eliminar -->
            @foreach($productos as $producto)
            <div class="modal fade" id="modalEliminar{{ $producto->id_producto }}" tabindex="-1" aria-labelledby="modalEliminarLabel{{ $producto->id_producto }}" aria-hidden="true">
              <div class="modal-dialog">
                <form method="POST" action="{{ route('productos.destroy', $producto->id_producto) }}">
                  @csrf
                  @method('DELETE')
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalEliminarLabel{{ $producto->id_producto }}">Confirmar Eliminación</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                      ¿Estás seguro de que deseas eliminar el producto <strong>{{ $producto->nombre }}</strong>?
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-danger">Eliminar</button>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            @endforeach
            <!-- 🔼 Fin de modales de eliminación -->

        </div> <!-- .card-body -->
    </div> <!-- .card -->
</div> <!-- .container-fluid -->


<!-- 🔽 Fuera de la tabla, todos los modales -->
@foreach($productos as $producto)
<div class="modal fade" id="modalEditar{{ $producto->Id_producto }}" tabindex="-1" aria-labelledby="modalEditarLabel{{ $producto->Id_producto }}" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('productos.update', ['id' => $producto->id_producto]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarLabel{{ $producto->Id_producto }}">Editar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="{{ $producto->nombre }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Código</label>
                        <input type="text" name="codigo" class="form-control" value="{{ $producto->codigo }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Unidad de Medida</label>
                        <input type="text" name="unidad_medida" class="form-control" value="{{ $producto->unidad_medida }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Categoría</label>
                        <input type="text" name="categoria" class="form-control" value="{{ $producto->categoria }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cantidad</label>
                        <input type="number" name="cantidad" class="form-control" value="{{ $producto->cantidad }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Observación</label>
                        <textarea name="observacion" class="form-control">{{ $producto->observacion }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach


<!-- Modal para crear producto -->
<div class="modal fade" id="crearProductoModal" tabindex="-1" aria-labelledby="crearProductoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('productos.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="crearProductoModalLabel">Agregar Nuevo Producto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Código</label>
            <input type="text" name="codigo" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Unidad de Medida</label>
            <select name="unidad_medida" class="form-select" required>
              <option value="" selected disabled>Seleccione una unidad</option>
              <option value="Unidad">Unidad</option>
              <option value="kg">kg</option>
              <option value="Lata">Lata</option>
              <option value="Bolsas">Bolsas</option>
              <option value="Paquete">Paquete</option>
              <option value="Caja">Caja</option>
              <option value="Gramos">Gramos</option>
              <option value="Java">Java</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Categoría</label>
            <select name="categoria" class="form-select" required>
              <option value="" selected disabled>Seleccione una categoría</option>
              <option value="Verduras">Verduras</option>
              <option value="Abarrotes">Abarrotes</option>
              <option value="Frutos secos">Frutos secos</option>
              <option value="Frutas">Frutas</option>
              <option value="Semillas">Semillas</option>
              <option value="Enlatados">Enlatados</option>
              <option value="Lácteos">Lácteos</option>
              <option value="Plásticos">Plásticos</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Cantidad</label>
            <input type="number" name="cantidad" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Observación</label>
            <textarea name="observacion" class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Guardar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">