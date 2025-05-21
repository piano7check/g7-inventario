<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return view('productos', compact('productos'));
    }

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

        Producto::create($request->only([
            'nombre', 'codigo', 'unidad_medida', 'categoria', 'cantidad', 'observacion'
        ]));

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente');
    }

    public function edit($id)
    {
        $producto = Producto::where('Id_producto', $id)->firstOrFail();
        return view('productos.editar', compact('producto'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'codigo' => 'required|string|max:50',
            'unidad_medida' => 'required|string|max:50',
            'categoria' => 'required|string|max:100',
            'cantidad' => 'required|integer|min:0',
            'observacion' => 'nullable|string',
        ]);

        $producto = Producto::where('Id_producto', $id)->firstOrFail();

        $producto->update($request->only([
            'nombre', 'codigo', 'unidad_medida', 'categoria', 'cantidad', 'observacion'
        ]));

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente');
    }
}
