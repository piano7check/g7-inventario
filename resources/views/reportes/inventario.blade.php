@extends('layouts.app')

@section('title', 'Reporte de Inventario')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary">Reporte de Inventario</h2>
            <div>
                <button class="btn btn-outline-primary me-2" onclick="window.print()">
                    <i class="fas fa-print"></i> Imprimir
                </button>
                <a href="#" class="btn btn-outline-success">
                    <i class="fas fa-file-excel"></i> Exportar a Excel
                </a>
            </div>
        </div>
        
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Producto</th>
                                <th>Unidad</th>
                                <th class="text-end">Stock Actual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($productosPorCategoria as $categoria => $productos)
                                <tr class="table-primary">
                                    <th colspan="4" class="fs-5">{{ $categoria }}</th>
                                </tr>
                                @foreach($productos as $producto)
                                    <tr>
                                        <td>{{ $producto->codigo }}</td>
                                        <td>{{ $producto->nombre }}</td>
                                        <td>{{ $producto->unidad_medida }}</td>
                                        <td class="text-end fw-bold {{ $producto->cantidad <= 5 ? 'text-danger' : '' }}">
                                            {{ $producto->cantidad }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="table-light">
                                    <td colspan="3" class="text-end fw-bold">Total en {{ $categoria }}:</td>
                                    <td class="text-end fw-bold">{{ $productos->sum('cantidad') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No hay productos registrados</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="table-dark">
                                <td colspan="3" class="text-end fw-bold">TOTAL GENERAL:</td>
                                <td class="text-end fw-bold">{{ $productosPorCategoria->flatten()->sum('cantidad') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        @media print {
            .btn, nav, footer {
                display: none !important;
            }
            
            .card {
                border: none !important;
                box-shadow: none !important;
            }
            
            .container {
                max-width: 100% !important;
                width: 100% !important;
            }
        }
    </style>
@endsection