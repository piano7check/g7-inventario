@extends('layouts.app')

@section('title', 'Inventario')

@section('content')
    <div class="container">
        <h2 class="mb-4 text-primary">Gestión de Inventario</h2>
        
        <!-- Mensajes de alerta -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Registrar Movimiento</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('inventario.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="id_producto" class="form-label">Producto</label>
                                <select class="form-select @error('id_producto') is-invalid @enderror" id="id_producto" name="id_producto" required>
                                    <option value="">Seleccione un producto</option>
                                    @foreach($productos as $producto)
                                        <option value="{{ $producto->id_producto }}">{{ $producto->codigo }} - {{ $producto->nombre }} (Stock: {{ $producto->cantidad }})</option>
                                    @endforeach
                                </select>
                                @error('id_producto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Tipo de Movimiento</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipo_movimiento" id="tipo_entrada" value="entrada" checked>
                                    <label class="form-check-label" for="tipo_entrada">
                                        Entrada
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipo_movimiento" id="tipo_salida" value="salida">
                                    <label class="form-check-label" for="tipo_salida">
                                        Salida
                                    </label>
                                </div>
                                @error('tipo_movimiento')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="cantidad" class="form-label">Cantidad</label>
                                <input type="number" class="form-control @error('cantidad') is-invalid @enderror" id="cantidad" name="cantidad" min="1" required>
                                @error('cantidad')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="observacion" class="form-label">Observación</label>
                                <textarea class="form-control @error('observacion') is-invalid @enderror" id="observacion" name="observacion" rows="2"></textarea>
                                @error('observacion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Registrar Movimiento</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Filtrar Movimientos</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('inventario.index') }}" method="GET">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="buscar" class="form-label">Buscar</label>
                                    <input type="text" class="form-control" id="buscar" name="buscar" placeholder="Código o nombre" value="{{ request('buscar') }}">
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="tipo_movimiento" class="form-label">Tipo de Movimiento</label>
                                    <select class="form-select" id="tipo_movimiento" name="tipo_movimiento">
                                        <option value="">Todos</option>
                                        <option value="entrada" {{ request('tipo_movimiento') == 'entrada' ? 'selected' : '' }}>Entradas</option>
                                        <option value="salida" {{ request('tipo_movimiento') == 'salida' ? 'selected' : '' }}>Salidas</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-outline-primary">Filtrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Historial de Movimientos</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Producto</th>
                                <th>Tipo</th>
                                <th>Cantidad</th>
                                <th>Observación</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($movimientos as $movimiento)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($movimiento->fecha_movimiento)->format('d/m/Y H:i') }}</td>
                                    <td>{{ $movimiento->producto->codigo }} - {{ $movimiento->producto->nombre }}</td>
                                    <td>
                                        @if($movimiento->tipo_movimiento == 'entrada')
                                            <span class="badge bg-success">Entrada</span>
                                        @else
                                            <span class="badge bg-danger">Salida</span>
                                        @endif
                                    </td>
                                    <td>{{ $movimiento->cantidad }}</td>
                                    <td>{{ $movimiento->observacion ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No hay movimientos registrados</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Validación del lado del cliente para evitar salidas con stock insuficiente
    document.addEventListener('DOMContentLoaded', function() {
        const productoSelect = document.getElementById('id_producto');
        const tipoSalida = document.getElementById('tipo_salida');
        const cantidadInput = document.getElementById('cantidad');
        const form = cantidadInput.closest('form');
        
        form.addEventListener('submit', function(e) {
            if (tipoSalida.checked) {
                const selectedOption = productoSelect.options[productoSelect.selectedIndex];
                if (selectedOption.value) {
                    const stockText = selectedOption.text.match(/Stock: (\d+)/);
                    if (stockText && stockText[1]) {
                        const stockActual = parseInt(stockText[1]);
                        const cantidadSalida = parseInt(cantidadInput.value);
                        
                        if (cantidadSalida > stockActual) {
                            e.preventDefault();
                            alert('No hay suficiente stock disponible para realizar esta salida.');
                        }
                    }
                }
            }
        });
    });
</script>
@endsection