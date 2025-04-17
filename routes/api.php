<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Models\Usuario;
use App\Http\Controllers\UsuarioController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


<<<<<<< HEAD

Route::post('/usuarios/test', function (Request $request) {
    $request->validate([
        'nombre' => 'required',
        'correo' => 'required|email|unique:usuarios,correo',
        'contrasena' => 'required|min:6',
        'rol' => 'required|in:administrador,registrador',
        'documento_identidad' => 'required',
    ]);

    $usuario = Usuario::create([
        'nombre' => $request->nombre,
        'correo' => $request->correo,
        'contrasena' => bcrypt($request->contrasena),
        'rol' => $request->rol,
        'documento_identidad' => $request->documento_identidad,
    ]);

    return response()->json([
        'message' => 'Usuario creado correctamente',
        'usuario' => $usuario
    ]);
    
});
=======

>>>>>>> 36dca72 (vista de usuario terminado y funcional)
