@extends('layouts.app')

@section('title', 'Productos')

@push('styles')
    {{-- Bootstrap y tus estilos personalizados --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
@endpush

@section('content')
<div class="container mt-4">
    <div class="content-container">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Gestión de Productos</h4>
            <button class="btn btn-secondary">Informe</button>
        </div>

        <div class="d-flex justify-content-between flex-wrap gap-2 mb-4">
            <div class="d-flex gap-2">
                <button class="btn btn-crear" data-bs-toggle="modal" data-bs-target="#modalCrearProducto">
                    <i class="bi bi-plus-lg"></i> Agregar Producto
                </button>
                <button class="btn btn-exportar">
                    <i class="bi bi-file-earmark-arrow-down"></i> Exportar
                </button>
            </div>
            <div>
                <button class="btn btn-primary">Buscar Producto</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered users-table">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Cantidad Unitaria</th>
                        <th>Cantidad</th>
                        <th>Fecha de Vencimiento</th>
                        <th>Tipo de Producto</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $productos = [
                            ['id' => 1, 'nombre' => 'Producto 1', 'cantidad_unitaria' => '10 unidades', 'cantidad' => 50, 'fecha_vencimiento' => '2025-12-31', 'tipo' => 'Alimento'],
                            ['id' => 2, 'nombre' => 'Producto 2', 'cantidad_unitaria' => '5 kg', 'cantidad' => 25, 'fecha_vencimiento' => '2025-10-15', 'tipo' => 'Bebida'],
                        ];
                    @endphp

                    @for ($i = 0; $i < 12; $i++)
                        <tr>
                            @if (isset($productos[$i]))
                                <td>{{ $productos[$i]['id'] }}</td>
                                <td>{{ $productos[$i]['nombre'] }}</td>
                                <td>{{ $productos[$i]['cantidad_unitaria'] }}</td>
                                <td>{{ $productos[$i]['cantidad'] }}</td>
                                <td>{{ $productos[$i]['fecha_vencimiento'] }}</td>
                                <td>{{ $productos[$i]['tipo'] }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-primary">Ver</button>
                                    <button class="btn btn-sm btn-outline-success">Editar</button>
                                    <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                                </td>
                            @else
                                <td colspan="7" class="text-center text-muted">-</td>
                            @endif
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Crear Producto -->
<div class="modal fade" id="modalCrearProducto" tabindex="-1" aria-labelledby="modalCrearProductoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCrearProductoLabel">Agregar Nuevo Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row g-3">
            <div class="col-md-6">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="nombre" placeholder="Ej: Leche Entera">
            </div>
            <div class="col-md-6">
              <label for="cantidad" class="form-label">Cantidad</label>
              <input type="number" class="form-control" id="cantidad" placeholder="Ej: 100">
            </div>
            <div class="col-md-6">
              <label for="unidad" class="form-label">Cantidad Unitaria</label>
              <input type="text" class="form-control" id="unidad" placeholder="Ej: 1 litro, 5 kg">
            </div>
            <div class="col-md-6">
              <label for="vencimiento" class="form-label">Fecha de Vencimiento</label>
              <input type="date" class="form-control" id="vencimiento">
            </div>
            <div class="col-md-12">
              <label for="tipo" class="form-label">Tipo de Producto</label>
              <select class="form-select" id="tipo">
                <option selected disabled>Seleccione</option>
                <option value="Alimento">Alimento</option>
                <option value="Bebida">Bebida</option>
                <option value="Otro">Otro</option>
              </select>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success">Guardar Producto</button>
      </div>
    </div>
  </div>
</div>

{{-- Bootstrap Bundle --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection