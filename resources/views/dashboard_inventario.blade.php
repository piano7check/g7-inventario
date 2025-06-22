@extends('layouts.app')

@section('title', 'Dashboard de Inventario')

@section('content')
<div class="container">
    <h2 class="mb-4 text-primary">Dashboard de Inventario</h2>
    
    <!-- Mensajes de alerta -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <!-- Tarjetas de resumen -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Total Productos</h6>
                            <h2 class="mb-0">{{ $totalProductos }}</h2>
                        </div>
                        <i class="bi bi-box fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Entradas (Mes)</h6>
                            <h2 class="mb-0">{{ $entradasMes }}</h2>
                        </div>
                        <i class="bi bi-arrow-down-circle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Salidas (Mes)</h6>
                            <h2 class="mb-0">{{ $salidasMes }}</h2>
                        </div>
                        <i class="bi bi-arrow-up-circle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Productos Críticos</h6>
                            <h2 class="mb-0">{{ $productosBajoStock }}</h2>
                        </div>
                        <i class="bi bi-exclamation-triangle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Gráficos -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Movimientos por Mes</h5>
                </div>
                <div class="card-body">
                    <canvas id="graficoMovimientos" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Productos por Categoría</h5>
                </div>
                <div class="card-body">
                    <canvas id="graficoCategorias" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Productos con bajo stock -->
    <div class="card shadow mb-4">
        <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Alertas de Bajo Stock</h5>
            <button class="btn btn-sm btn-light" id="btnConfigAlerta" data-bs-toggle="modal" data-bs-target="#modalConfigAlerta">
                <i class="bi bi-gear"></i> Configurar
            </button>
        </div>
        <div class="card-body">
            @if(count($productosBajoStockLista) > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th>Stock Actual</th>
                                <th>Stock Mínimo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productosBajoStockLista as $producto)
                                <tr>
                                    <td>{{ $producto->codigo }}</td>
                                    <td>{{ $producto->nombre }}</td>
                                    <td>{{ $producto->categoria }}</td>
                                    <td>
                                        <span class="badge bg-danger">{{ $producto->cantidad }}</span>
                                    </td>
                                    <td>{{ $producto->stock_minimo ?? 5 }}</td>
                                    <td>
                                        <a href="{{ route('inventario.index', ['id_producto' => $producto->id_producto]) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-plus-circle"></i> Registrar Entrada
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-2"></i> No hay productos con bajo stock actualmente.
                </div>
            @endif
        </div>
    </div>
    
    <!-- Últimos movimientos -->
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Últimos Movimientos</h5>
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
                        @forelse($ultimosMovimientos as $movimiento)
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

<!-- Modal Configuración de Alertas -->
<div class="modal fade" id="modalConfigAlerta" tabindex="-1" aria-labelledby="modalConfigAlertaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalConfigAlertaLabel">Configurar Alertas de Stock</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('inventario.configurar-alertas') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="stock_minimo_global" class="form-label">Stock Mínimo Global</label>
                        <input type="number" class="form-control" id="stock_minimo_global" name="stock_minimo_global" value="{{ $stockMinimoGlobal ?? 5 }}" min="1">
                        <small class="text-muted">Este valor se aplicará a todos los productos que no tengan un stock mínimo específico.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Configuración</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gráfico de Movimientos por Mes
        const ctxMovimientos = document.getElementById('graficoMovimientos').getContext('2d');
        new Chart(ctxMovimientos, {
            type: 'bar',
            data: {
                labels: {!! json_encode($mesesLabels) !!},
                datasets: [
                    {
                        label: 'Entradas',
                        data: {!! json_encode($entradasPorMes) !!},
                        backgroundColor: 'rgba(40, 167, 69, 0.7)',
                        borderColor: 'rgba(40, 167, 69, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Salidas',
                        data: {!! json_encode($salidasPorMes) !!},
                        backgroundColor: 'rgba(220, 53, 69, 0.7)',
                        borderColor: 'rgba(220, 53, 69, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        
        // Gráfico de Productos por Categoría
        const ctxCategorias = document.getElementById('graficoCategorias').getContext('2d');
        new Chart(ctxCategorias, {
            type: 'pie',
            data: {
                labels: {!! json_encode($categoriasLabels) !!},
                datasets: [{
                    data: {!! json_encode($productosPorCategoria) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)',
                        'rgba(199, 199, 199, 0.7)',
                        'rgba(83, 102, 255, 0.7)',
                        'rgba(40, 159, 64, 0.7)',
                        'rgba(210, 199, 199, 0.7)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(199, 199, 199, 1)',
                        'rgba(83, 102, 255, 1)',
                        'rgba(40, 159, 64, 1)',
                        'rgba(210, 199, 199, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    }
                }
            }
        });
    });
</script>
@endsection