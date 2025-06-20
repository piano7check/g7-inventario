<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\InventarioController;
// Importación de Mensaje eliminada

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Ruta raíz que redirecciona automáticamente
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas protegidas por login
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        // Si es administrador, redirigir al dashboard, si es registrador, redirigir al inventario
        return auth()->user()->rol == 'administrador' 
            ? redirect()->route('inventario.dashboard')
            : redirect()->route('inventario.index');
    })->name('dashboard');
});

// Rutas de productos
Route::middleware(['auth'])->group(function () {
    // Rutas accesibles para ambos roles
    Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
    
    // Rutas solo para administradores
    Route::middleware(['role:administrador'])->group(function () {
        Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
        Route::get('/productos/{id}/editar', [ProductoController::class, 'edit'])->name('productos.edit');
        Route::put('/productos/{id}/actualizar', [ProductoController::class, 'update'])->name('productos.update');
        Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');
    });
});

// Rutas de usuarios - solo para administradores
Route::middleware(['auth', 'role:administrador'])->group(function () {
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::post('/usuarios/{id}/actualizar', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
    
    // Exportación de usuarios
    Route::get('/usuarios/export/excel', [UsuarioController::class, 'exportExcel'])->name('usuarios.export.excel');
    Route::get('/usuarios/export/pdf', [UsuarioController::class, 'exportPDF'])->name('usuarios.export.pdf');
});

// Ruta de eliminación de usuarios

// Rutas de inventario
Route::middleware(['auth'])->group(function () {
    // Rutas accesibles para ambos roles
    Route::get('/inventario', [InventarioController::class, 'index'])->name('inventario.index');
    Route::get('/inventario/dashboard', [InventarioController::class, 'dashboard'])->name('inventario.dashboard');
    Route::post('/inventario', [InventarioController::class, 'store'])->name('inventario.store'); // Registrar movimientos
    
    // Rutas solo para administradores
    Route::middleware(['role:administrador'])->group(function () {
        Route::get('/inventario/conteo-fisico', [InventarioController::class, 'conteoFisico'])->name('inventario.conteo-fisico');
        Route::post('/inventario/procesar-conteo', [InventarioController::class, 'procesarConteo'])->name('inventario.procesar-conteo');
        Route::post('/inventario/configurar-alertas', [InventarioController::class, 'configurarAlertas'])->name('inventario.configurar-alertas');
        Route::get('/reportes/inventario', [InventarioController::class, 'reporteInventario'])->name('reportes.inventario');
    });
});

// Vistas simples
Route::get('/reportes', function () {
    return view('reportes');
});

// Ruta Hola Mundo eliminada





// Fin de rutas de productos