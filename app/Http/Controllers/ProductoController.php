<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // Mostrar todos los productos
    public function index()
    {   
        
        $productos = Producto::all();
        
        return view('productos', compact('productos'));
    }
    
    // Guardar nuevo producto
    public function store(Request $request)
    {
        $request->validate([
            
            'nombre' => 'required|string|max:100',
            'codigo' => 'required|string|max:50|unique:productos,codigo',
            'unidad_medida' => 'required|string|max:50',
            'categoria' => 'required|string|max:100',
            'cantidad' => 'required|integer|min:0',
            'observacion' => 'nullable|string',
        ]);

        Producto::create([
            
            'nombre' => $request->nombre,
            'codigo' => $request->codigo,
            'unidad_medida' => $request->unidad_medida,
            'categoria' => $request->categoria,
            'cantidad' => $request->cantidad,
            'observacion' => $request->observacion,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente');
    }
}
