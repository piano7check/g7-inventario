@extends('layouts.app')

@section('title', 'Reportes')

@section('content')
    <div class="container">
        <h2 class="mb-4 text-primary">Reportes del Sistema</h2>
        
        <div class="row">
            <!-- Reporte de Inventario -->
            <div class="col-md-4 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Inventario Actual</h5>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <p class="card-text flex-grow-1">
                            Muestra el stock actual de todos los productos en inventario, agrupados por categoría.
                        </p>
                        <a href="{{ route('reportes.inventario') }}" class="btn btn-outline-primary mt-auto">
                            <i class="fas fa-boxes me-2"></i> Ver Reporte
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Reporte de Movimientos -->
            <div class="col-md-4 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Movimientos de Inventario</h5>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <p class="card-text flex-grow-1">
                            Historial de entradas y salidas de productos con filtros por fecha y tipo de movimiento.
                        </p>
                        <a href="{{ route('inventario.index') }}" class="btn btn-outline-primary mt-auto">
                            <i class="fas fa-exchange-alt me-2"></i> Ver Movimientos
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Reporte de Usuarios -->
            <div class="col-md-4 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Usuarios del Sistema</h5>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <p class="card-text flex-grow-1">
                            Lista de usuarios registrados en el sistema con sus roles y permisos.
                        </p>
                        <div class="mt-auto">
                            <a href="{{ route('usuarios.export.excel') }}" class="btn btn-outline-success me-2">
                                <i class="fas fa-file-excel me-1"></i> Excel
                            </a>
                            <a href="{{ route('usuarios.export.pdf') }}" class="btn btn-outline-danger">
                                <i class="fas fa-file-pdf me-1"></i> PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Productos con Bajo Stock -->
            <div class="col-md-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">Productos con Bajo Stock</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            Lista de productos que están por debajo del nivel mínimo de stock recomendado.
                        </p>
                        <p class="text-muted"><em>Próximamente disponible</em></p>
                    </div>
                </div>
            </div>
            
            <!-- Estadísticas de Movimientos -->
            <div class="col-md-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Estadísticas de Movimientos</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            Gráficos y estadísticas de movimientos de inventario por período.
                        </p>
                        <p class="text-muted"><em>Próximamente disponible</em></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
