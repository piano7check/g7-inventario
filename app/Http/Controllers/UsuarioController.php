<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsuariosExport;
use PDF;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();
        return view('usuarios', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'documento_identidad' => 'required|string|max:20|unique:usuarios,documento_identidad',
            'correo' => 'required|email|max:255|unique:usuarios,correo',
            'contrasena' => 'required|string|min:6',
            'rol' => 'required|in:Administrador,Usuario,registrador',
        ]);

        Usuario::create([
            'nombre' => $request->nombre,
            'documento_identidad' => $request->documento_identidad,
            'correo' => $request->correo,
            'contrasena' => bcrypt($request->contrasena),
            'rol' => $request->rol,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'documento_identidad' => 'required|string|max:20',
            'correo' => 'required|email',
            'rol' => 'required|in:Administrador,Usuario',
        ]);

        $usuario = Usuario::findOrFail($id);

        $usuario->update([
            'nombre' => $request->nombre,
            'documento_identidad' => $request->documento_identidad,
            'correo' => $request->correo,
            'rol' => $request->rol,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente');
    }

    // Exportar usuarios a Excel
    public function exportExcel()
    {
        return Excel::download(new UsuariosExport, 'usuarios.xlsx');
    }

    // Exportar usuarios a PDF
    public function exportPDF()
{
    $usuarios = Usuario::all();

    // Esto genera el HTML manualmente
    $html = view('exports.usuarios-pdf', compact('usuarios'))->render();

    // Esto genera el PDF a partir del HTML
    $pdf = Pdf::loadHTML($html);

    return $pdf->download('usuarios.pdf');
<<<<<<< HEAD
=======

>>>>>>> 52d4cedad1f671cfd1d946b43a065235c09f0704
}
}



