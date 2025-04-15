<?php
namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    // Mostrar formulario de creación de usuario
    public function create()
    {
        if (Auth::user()->rol !== 'administrador') {
            abort(403, 'Acceso no autorizado');
        }

        return view('usuarios.create'); // ← Vamos a crear esta vista ahora
    }

    // Guardar nuevo usuario
    public function store(Request $request)
    {
        if (Auth::user()->rol !== 'administrador') {
            abort(403, 'Acceso no autorizado');
        }

        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|unique:usuarios,correo',
            'contrasena' => 'required|min:6',
            'rol' => 'required|in:administrador,registrador',
        ]);

        Usuario::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'contrasena' => Hash::make($request->contrasena),
            'rol' => $request->rol,
        ]);

        return redirect('/usuarios')->with('success', 'Usuario creado correctamente');
    }
}
