<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');

        $productos = Producto::query();

        if ($buscar) {
            $productos->where('nombre', 'like', "%{$buscar}%")
                      ->orWhere('codigo', 'like', "%{$buscar}%");
        }

        $productos = $productos->orderBy('id_producto', 'desc')->get();

        try {
            // Verificar si la vista existe
            if (view()->exists('productos')) {
                return view('productos', compact('productos'));
            } else {
                \Log::error('La vista productos no existe');
                return response()->view('layouts.app', ['error' => 'No se pudo cargar la página de productos. Por favor, contacte al administrador.'], 500);
            }
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error al cargar la vista de productos: ' . $e->getMessage());
            
            // Devolver una vista alternativa o un mensaje de error
            return response()->view('layouts.app', ['error' => 'No se pudo cargar la página de productos. Por favor, contacte al administrador.'], 500);
        }
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
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $data = $request->only([
            'nombre', 'codigo', 'unidad_medida', 'categoria', 'cantidad', 'observacion'
        ]);

        // Manejar la subida de imagen
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $imagen->storeAs('public/productos', $nombreImagen);
            $data['imagen'] = $nombreImagen;
        }

        Producto::create($data);

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente');
    }
    

    public function edit($id)
    {
        $producto = Producto::where('id_producto', $id)->firstOrFail();
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
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'observacion' => 'nullable|string',
        ]);

        $producto = Producto::where('id_producto', $id)->firstOrFail();

        $data = $request->only([
            'nombre', 'codigo', 'unidad_medida', 'categoria', 'cantidad', 'observacion'
        ]);

        // Manejar la subida de imagen
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($producto->imagen) {
                Storage::delete('public/productos/' . $producto->imagen);
            }
            
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $imagen->storeAs('public/productos', $nombreImagen);
            $data['imagen'] = $nombreImagen;
        }

        $producto->update($data);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente');
    }
}
