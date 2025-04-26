@extends('layouts.app')

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

  .btn-crear:hover {
    background: linear-gradient(to right, #00c6ff, #0072ff);
    box-shadow: 0 0 12px rgba(0, 123, 255, 0.4);
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

<div class="container mt-5">
    <h1 class="text-center mb-4">Gestión de Productos</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Botón para abrir el modal de agregar producto -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#crearProductoModal">
        Agregar Producto
    </button>

    <!-- Tabla de productos -->
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Código</th>
                        <th>Unidad de Medida</th>
                        <th>Categoría</th>
                        <th>Cantidad</th>
                        <th>Observación</th>
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

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
            <input type="text" name="unidad_medida" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Categoría</label>
            <input type="text" name="categoria" class="form-control" required>
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
