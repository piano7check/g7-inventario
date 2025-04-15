@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h2 class="mb-4 text-primary">Bienvenido, {{ Auth::user()->nombre }}</h2>

    <div class="row text-center">
        <div class="col-md-3 mb-4">
            <div class="card p-4">
                <div class="card-icon mb-2"><i class="bi bi-box-seam"></i></div>
                <div class="card-title">Productos</div>
                <div class="fs-5 text-secondary">Ver y registrar</div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card p-4">
                <div class="card-icon mb-2"><i class="bi bi-people-fill"></i></div>
                <div class="card-title">Usuarios</div>
                <div class="fs-5 text-secondary">Administración</div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card p-4">
                <div class="card-icon mb-2"><i class="bi bi-arrow-left-right"></i></div>
                <div class="card-title">Movimientos</div>
                <div class="fs-5 text-secondary">Entradas y salidas</div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card p-4">
                <div class="card-icon mb-2"><i class="bi bi-bar-chart-line"></i></div>
                <div class="card-title">Reportes</div>
                <div class="fs-5 text-secondary">PDF y Excel</div>
            </div>
        </div>
    </div>
@endsection
