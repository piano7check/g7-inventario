<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect('login');
        }

        // Obtener el usuario autenticado
        $usuario = Auth::user();

        // Verificar si el rol del usuario está en la lista de roles permitidos
        if (in_array(strtolower($usuario->rol), array_map('strtolower', $roles))) {
            return $next($request);
        }

        // Si el usuario no tiene el rol requerido, redirigir al dashboard
        return redirect()->route('dashboard')->with('error', 'No tienes permiso para acceder a esta sección.');
    }
}