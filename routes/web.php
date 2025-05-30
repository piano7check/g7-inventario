<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProductoController;
use App\Models\Mensaje;

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
        return view('dashboard');
    })->name('dashboard');
});

// Rutas de productos
Route::get('/productos', function () {
    return view('productos');
});
Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');

// Rutas de usuarios
Route::get('/usuarios', function () {
    return view('usuarios');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
});
Route::post('/usuarios/{id}/actualizar', [UsuarioController::class, 'update'])->name('usuarios.update');
Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');

// Exportación de usuarios
Route::get('/usuarios/export/excel', [UsuarioController::class, 'exportExcel'])->name('usuarios.export.excel');
Route::get('/usuarios/export/pdf', [UsuarioController::class, 'exportPDF'])->name('usuarios.export.pdf');

// Repetida pero la dejamos para seguridad
Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']);

// Vistas simples
Route::get('/movimientos', function () {
    return view('movimientos');
});
Route::get('/reportes', function () {
    return view('reportes');
});

// Ruta Hola Mundo desde base de datos
Route::get('/hola', function () {
    $mensaje = Mensaje::latest()->first();
    return view('hola', [
        'mensaje' => $mensaje ? $mensaje->contenido : 'No hay mensajes en la base de datos todavía.'
    ]);
});





// Mostrar el formulario de edición
Route::get('/productos/{id}/editar', [ProductoController::class, 'edit'])->name('productos.edit');

// Actualizar el producto (ya la tenías)
Route::put('/productos/{id}/actualizar', [ProductoController::class, 'update'])->name('productos.update');

Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');

Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');

Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');


