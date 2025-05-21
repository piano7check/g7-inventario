@extends('layouts.app')

@section('content')
<style>
  .content-container {
    padding: 2rem;
    background-color:rgba(255, 255, 255, 0.24);
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
  
  /* Estilo para los selects */
  .form-select {
    border-radius: 10px;
    border: 1px solid #cce6ff;
    padding: 0.5rem 1rem;
    transition: all 0.2s ease;
  }
  
  .form-select:hover {
    border-color: #99ccff;
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

  .btn-crear:hover {
    background: linear-gradient(to right, #00c6ff, #0072ff);
    box-shadow: 0 0 12px rgba(0, 123, 255, 0.4);
  }

  .users-table {
    min-width: 100%;
  }

  /* Estilo para hacer la tabla más ancha */
  .table-responsive {
    margin-top: 1rem;
    overflow-x: auto;
    width: 95%;
    margin-left: auto;
    margin-right: auto;
  }

  /* Estilo para el encabezado de la tabla en azul claro */
  .table thead th {
    background-color: #e6f2ff; /* Color azul más claro similar a la imagen */
    color: #333;
    font-weight: 700;
    border: 1px solid #b8d8fd;
    padding: 10px 15px;
    text-align: center;
    vertical-align: middle;
    /* No usar uppercase para coincidir con la imagen de referencia */
    letter-spacing: normal;
  }
  
  /* Estilo para agregar líneas horizontales de separación entre filas */
  .table tbody tr {
    border-bottom: 1px solid #dee2e6;
  }
  
  /* Dar un poco más de padding a las celdas para mejor separación visual */
  .table td, .table th {
    padding: 12px 15px;
    vertical-align: middle;
    text-align: center; /* Centrar todo el texto en las celdas */
  }
  
  /* Estilos para la tabla completa */
  .table {
    border-collapse: separate;
    border-spacing: 0;
  }
  
  /* Estilo para las celdas del cuerpo de la tabla */
  .table tbody td {
    background-color: white;
    border: 1px solid #dee2e6;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
  }
</style>

<div class="container-fluid mt-5">
    <h1 class="text-center mb-4">Gestión de Productos</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#crearProductoModal">
        Agregar Producto
    </button>

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
                            <td>{{ $producto->Id_producto }}</td>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $producto->codigo }}</td>
                            <td>{{ $producto->unidad_medida }}</td>
                            <td>{{ $producto->categoria }}</td>
                            <td>{{ $producto->cantidad }}</td>
                            <td>{{ $producto->observacion }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $producto->Id_producto }}">
                                    Editar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

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