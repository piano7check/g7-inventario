@extends('layouts.app')

@section('title', 'Conteo Físico de Inventario')

@section('content')
<div class="container">
    <h2 class="mb-4 text-primary">Conteo Físico de Inventario</h2>
    
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
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Instrucciones</h5>
                </div>
                <div class="card-body">
                    <p>El conteo físico de inventario le permite ajustar las cantidades en el sistema según el conteo real de productos. Siga estos pasos:</p>
                    <ol>
                        <li>Seleccione la categoría de productos que desea contar.</li>
                        <li>Ingrese las cantidades reales contadas para cada producto.</li>
                        <li>El sistema calculará automáticamente las diferencias.</li>
                        <li>Confirme los ajustes para actualizar el inventario.</li>
                    </ol>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i> Esta operación generará movimientos de ajuste en el historial de inventario.
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Filtrar por Categoría</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('inventario.conteo-fisico') }}" method="GET">
                        <div class="mb-3">
                            <label for="categoria" class="form-label">Categoría</label>
                            <select class="form-select" id="categoria" name="categoria">
                                <option value="">Todas las categorías</option>
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat }}" {{ request('categoria') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-filter"></i> Filtrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-8 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Conteo Físico {{ request('categoria') ? '- ' . request('categoria') : '' }}</h5>
                    <span class="badge bg-light text-dark">{{ count($productos) }} productos</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('inventario.procesar-conteo') }}" method="POST" id="formConteo">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Producto</th>
                                        <th class="text-center">Stock Sistema</th>
                                        <th class="text-center">Conteo Real</th>
                                        <th class="text-center">Diferencia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($productos as $producto)
                                        <tr>
                                            <td>{{ $producto->codigo }}</td>
                                            <td>{{ $producto->nombre }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-secondary">{{ $producto->cantidad }}</span>
                                                <input type="hidden" name="productos[{{ $producto->id_producto }}][stock_sistema]" value="{{ $producto->cantidad }}">
                                                <input type="hidden" name="productos[{{ $producto->id_producto }}][id_producto]" value="{{ $producto->id_producto }}">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm text-center conteo-real" 
                                                    name="productos[{{ $producto->id_producto }}][conteo_real]" 
                                                    min="0" value="{{ $producto->cantidad }}" 
                                                    data-stock="{{ $producto->cantidad }}">
                                            </td>
                                            <td class="text-center">
                                                <span class="badge diferencia">0</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No hay productos en esta categoría</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        @if(count($productos) > 0)
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="observacion" class="form-label">Observación del Conteo</label>
                                        <textarea class="form-control" id="observacion" name="observacion" rows="2" placeholder="Motivo del ajuste de inventario"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex align-items-end justify-content-end">
                                    <button type="submit" class="btn btn-primary" id="btnProcesarConteo">
                                        <i class="bi bi-check-circle"></i> Procesar Ajustes
                                    </button>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Historial de Conteos -->
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Historial de Conteos Físicos</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Productos Ajustados</th>
                            <th>Observación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($conteos as $conteo)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($conteo->fecha_conteo)->format('d/m/Y H:i') }}</td>
                                <td>{{ $conteo->usuario->nombre }}</td>
                                <td>{{ $conteo->total_productos }}</td>
                                <td>{{ $conteo->observacion ?? '-' }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalDetalleConteo{{ $conteo->id_conteo }}">
                                        <i class="bi bi-eye"></i> Ver Detalle
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No hay conteos físicos registrados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Modales de Detalle de Conteo -->
    @foreach($conteos as $conteo)
        <div class="modal fade" id="modalDetalleConteo{{ $conteo->id_conteo }}" tabindex="-1" aria-labelledby="modalDetalleConteoLabel{{ $conteo->id_conteo }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalDetalleConteoLabel{{ $conteo->id_conteo }}">Detalle de Conteo Físico</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($conteo->fecha_conteo)->format('d/m/Y H:i') }}</p>
                                <p><strong>Usuario:</strong> {{ $conteo->usuario->nombre }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Observación:</strong> {{ $conteo->observacion ?? 'Sin observaciones' }}</p>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Producto</th>
                                        <th class="text-center">Stock Anterior</th>
                                        <th class="text-center">Conteo Real</th>
                                        <th class="text-center">Diferencia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($conteo->detalles as $detalle)
                                        <tr>
                                            <td>{{ $detalle->producto->codigo }} - {{ $detalle->producto->nombre }}</td>
                                            <td class="text-center">{{ $detalle->stock_anterior }}</td>
                                            <td class="text-center">{{ $detalle->stock_nuevo }}</td>
                                            <td class="text-center">
                                                @php $diferencia = $detalle->stock_nuevo - $detalle->stock_anterior; @endphp
                                                @if($diferencia > 0)
                                                    <span class="badge bg-success">+{{ $diferencia }}</span>
                                                @elseif($diferencia < 0)
                                                    <span class="badge bg-danger">{{ $diferencia }}</span>
                                                @else
                                                    <span class="badge bg-secondary">0</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Calcular diferencias al cambiar valores
        const conteoInputs = document.querySelectorAll('.conteo-real');
        
        conteoInputs.forEach(input => {
            input.addEventListener('input', function() {
                const stockSistema = parseInt(this.getAttribute('data-stock'));
                const conteoReal = parseInt(this.value) || 0;
                const diferencia = conteoReal - stockSistema;
                
                const diferenciaSpan = this.closest('tr').querySelector('.diferencia');
                
                if (diferencia > 0) {
                    diferenciaSpan.textContent = '+' + diferencia;
                    diferenciaSpan.className = 'badge bg-success diferencia';
                } else if (diferencia < 0) {
                    diferenciaSpan.textContent = diferencia;
                    diferenciaSpan.className = 'badge bg-danger diferencia';
                } else {
                    diferenciaSpan.textContent = '0';
                    diferenciaSpan.className = 'badge bg-secondary diferencia';
                }
            });
        });
        
        // Confirmación antes de procesar
        const formConteo = document.getElementById('formConteo');
        if (formConteo) {
            formConteo.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const hayDiferencias = document.querySelectorAll('.diferencia:not(.bg-secondary)').length > 0;
                
                if (hayDiferencias) {
                    if (confirm('¿Está seguro de procesar estos ajustes de inventario? Esta acción no se puede deshacer.')) {
                        this.submit();
                    }
                } else {
                    alert('No hay diferencias para ajustar en el inventario.');
                }
            });
        }
    });
</script>
@endsection