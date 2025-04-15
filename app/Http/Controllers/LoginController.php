<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('correo', 'contrasena');

        if (Auth::attempt([
            'correo' => $credentials['correo'],
            'password' => $credentials['contrasena']
        ])) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard'); // Ruta protegida
        }

        return back()->withErrors([
            'correo' => 'Las credenciales no coinciden.',
        ]);
    }
    //postman
    //public function login(Request $request)
    //{
    //    $credentials = $request->only('correo', 'contrasena');
    //
    //    if (Auth::attempt([
    //        'correo' => $credentials['correo'],
    //        'password' => $credentials['contrasena']
    //    ])) {
    //        $request->session()->regenerate();
    //        return response()->json(['message' => 'Login exitoso'], 200);
    //    }
    //
    //    return response()->json(['error' => 'Credenciales incorrectas'], 401);
    //}
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
