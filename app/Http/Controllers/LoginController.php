<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login.login'); // Asegúrate que exista esta vista Blade
    }

    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'contrasena' => 'required|string|min:6',
        ]);

        $usuario = Usuario::where('correo', $request->correo)->first();

        if (!$usuario || !Hash::check($request->contrasena, $usuario->contrasena)) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Credenciales inválidas'], 401);
            }

            return back()->withErrors(['correo' => 'Credenciales incorrectas'])->withInput();
        }

        Auth::login($usuario);

        // Si es POSTMAN, devolver JSON
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'usuario' => $usuario->only(['id_usuario', 'nombre', 'correo', 'rol']),
                'redirect_to' => route('dashboard'),
            ]);
        }

        // Si es navegador, redirigir normal
        return redirect()->route('dashboard');
    }
    
    /**
     * Cierra la sesión del usuario actual
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->route('login');
    }
}
