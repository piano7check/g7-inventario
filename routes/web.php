<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuarioController;
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
Route::get('/productos', function () {
    return view('productos');
});
//rutas de usuario
Route::get('/usuarios', function () {
    return view('usuarios');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
});
Route::post('/usuarios/{id}/actualizar', [UsuarioController::class, 'update'])->name('usuarios.update');
Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
//ruta de exportacion de usuarios
Route::get('/usuarios/export/excel', [UsuarioController::class, 'exportExcel'])->name('usuarios.export.excel');
Route::get('/usuarios/export/pdf', [UsuarioController::class, 'exportPDF'])->name('usuarios.export.pdf');

//instaladro de excel y pdf
//composer require maatwebsite/excel
//composer require barryvdh/laravel-dompdf


Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']);

Route::get('/movimientos', function () {
    return view('movimientos');
});

Route::get('/reportes', function () {
    return view('reportes');
});





