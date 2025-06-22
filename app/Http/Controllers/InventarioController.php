<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\MovimientoProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InventarioController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');
        $filtroTipo = $request->input('tipo_movimiento');
        
        $movimientos = MovimientoProducto::with('producto');
        
        // Aplicar filtros de búsqueda
        if ($buscar) {
            $movimientos->whereHas('producto', function($query) use ($buscar) {
                $query->where('nombre', 'like', "%{$buscar}%")
                      ->orWhere('codigo', 'like', "%{$buscar}%");
            });
        }
        
        // Filtrar por tipo de movimiento
        if ($filtroTipo && in_array($filtroTipo, ['entrada', 'salida'])) {
            $movimientos->where('tipo_movimiento', $filtroTipo);
        }
        
        $movimientos = $movimientos->orderBy('fecha_movimiento', 'desc')->get();
        
        // Obtener todos los productos para el formulario de nuevo movimiento
        $productos = Producto::orderBy('nombre')->get();
        
        return view('inventario', compact('movimientos', 'productos', 'filtroTipo'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'id_producto' => 'required|exists:productos,id_producto',
            'tipo_movimiento' => 'required|in:entrada,salida',
            'cantidad' => 'required|integer|min:1',
            'observacion' => 'nullable|string',
        ]);
        
        // Iniciar transacción para asegurar la integridad de los datos
        DB::beginTransaction();
        
        try {
            $producto = Producto::findOrFail($request->id_producto);
            
            // Crear el movimiento
            $movimiento = new MovimientoProducto();
            $movimiento->id_producto = $request->id_producto;
            $movimiento->tipo_movimiento = $request->tipo_movimiento;
            $movimiento->cantidad = $request->cantidad;
            $movimiento->observacion = $request->observacion;
            $movimiento->save();
            
            // Actualizar el stock del producto
            if ($request->tipo_movimiento == 'entrada') {
                $producto->cantidad += $request->cantidad;
            } else { // salida
                // Verificar que haya suficiente stock
                if ($producto->cantidad < $request->cantidad) {
                    return redirect()->back()->with('error', 'No hay suficiente stock disponible para realizar esta salida.');
                }
                $producto->cantidad -= $request->cantidad;
            }
            
            $producto->save();
            
            DB::commit();
            return redirect()->route('inventario.index')->with('success', 'Movimiento registrado correctamente');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al registrar el movimiento: ' . $e->getMessage());
        }
    }
    
    public function reporteInventario()
    {
        $productos = Producto::orderBy('categoria')->orderBy('nombre')->get();
        
        // Agrupar productos por categoría
        $productosPorCategoria = $productos->groupBy('categoria');
        
        return view('reportes.inventario', compact('productosPorCategoria'));
    }
    
    public function dashboard()
    {
        // Estadísticas generales
        $totalProductos = Producto::count();
        
        // Movimientos del mes actual
        $inicioMes = Carbon::now()->startOfMonth();
        $finMes = Carbon::now()->endOfMonth();
        
        $entradasMes = MovimientoProducto::where('tipo_movimiento', 'entrada')
            ->whereBetween('fecha_movimiento', [$inicioMes, $finMes])
            ->sum('cantidad');
            
        $salidasMes = MovimientoProducto::where('tipo_movimiento', 'salida')
            ->whereBetween('fecha_movimiento', [$inicioMes, $finMes])
            ->sum('cantidad');
        
        // Productos con bajo stock (menos de 5 unidades por defecto)
        $stockMinimoGlobal = 5; // Esto podría venir de una configuración
        $productosBajoStockLista = Producto::where('cantidad', '<', $stockMinimoGlobal)->get();
        $productosBajoStock = $productosBajoStockLista->count();
        
        // Datos para gráfico de movimientos por mes (últimos 6 meses)
        $mesesLabels = [];
        $entradasPorMes = [];
        $salidasPorMes = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $mes = Carbon::now()->subMonths($i);
            $mesesLabels[] = $mes->format('M Y');
            
            $inicioMesLoop = $mes->copy()->startOfMonth();
            $finMesLoop = $mes->copy()->endOfMonth();
            
            $entradasPorMes[] = MovimientoProducto::where('tipo_movimiento', 'entrada')
                ->whereBetween('fecha_movimiento', [$inicioMesLoop, $finMesLoop])
                ->sum('cantidad');
                
            $salidasPorMes[] = MovimientoProducto::where('tipo_movimiento', 'salida')
                ->whereBetween('fecha_movimiento', [$inicioMesLoop, $finMesLoop])
                ->sum('cantidad');
        }
        
        // Datos para gráfico de productos por categoría
        $categorias = Producto::select('categoria')->distinct()->pluck('categoria');
        $categoriasLabels = [];
        $productosPorCategoria = [];
        
        foreach ($categorias as $categoria) {
            $categoriasLabels[] = $categoria;
            $productosPorCategoria[] = Producto::where('categoria', $categoria)->count();
        }
        
        // Últimos movimientos
        $ultimosMovimientos = MovimientoProducto::with('producto')
            ->orderBy('fecha_movimiento', 'desc')
            ->limit(10)
            ->get();
        
        return view('dashboard_inventario', compact(
            'totalProductos', 'entradasMes', 'salidasMes', 'productosBajoStock',
            'productosBajoStockLista', 'mesesLabels', 'entradasPorMes', 'salidasPorMes',
            'categoriasLabels', 'productosPorCategoria', 'ultimosMovimientos', 'stockMinimoGlobal'
        ));
    }
    
    public function configurarAlertas(Request $request)
    {
        $request->validate([
            'stock_minimo_global' => 'required|integer|min:1',
        ]);
        
        // Aquí se guardaría la configuración en la base de datos
        // Por ahora, simplemente redirigimos con un mensaje de éxito
        
        return redirect()->route('inventario.dashboard')
            ->with('success', 'Configuración de alertas actualizada correctamente');
    }
    
    // Funciones de QR eliminadas
    
    public function conteoFisico(Request $request)
    {
        // Obtener categorías para el filtro
        $categorias = Producto::select('categoria')->distinct()->pluck('categoria');
        
        // Filtrar productos por categoría si se especifica
        $query = Producto::query();
        
        if ($request->has('categoria') && $request->categoria) {
            $query->where('categoria', $request->categoria);
        }
        
        $productos = $query->orderBy('nombre')->get();
        
        // Obtener historial de conteos físicos
        $conteos = \App\Models\ConteoFisico::with(['usuario', 'detalles.producto'])
            ->orderBy('fecha_conteo', 'desc')
            ->limit(10)
            ->get();
        
        return view('conteo_fisico', compact('productos', 'categorias', 'conteos'));
    }
    
    public function procesarConteo(Request $request)
    {
        $request->validate([
            'productos' => 'required|array',
            'productos.*.id_producto' => 'required|exists:productos,id_producto',
            'productos.*.stock_sistema' => 'required|integer|min:0',
            'productos.*.conteo_real' => 'required|integer|min:0',
            'observacion' => 'nullable|string',
        ]);
        
        // Iniciar transacción
        DB::beginTransaction();
        
        try {
            // Crear registro de conteo físico
            $conteo = new \App\Models\ConteoFisico();
            $conteo->id_usuario = auth()->id(); // Asumiendo que hay autenticación
            $conteo->fecha_conteo = now();
            $conteo->observacion = $request->observacion;
            $conteo->total_productos = count($request->productos);
            $conteo->save();
            
            $productosAjustados = 0;
            
            // Procesar cada producto
            foreach ($request->productos as $datos) {
                $idProducto = $datos['id_producto'];
                $stockSistema = (int)$datos['stock_sistema'];
                $conteoReal = (int)$datos['conteo_real'];
                
                // Si hay diferencia, crear ajuste
                if ($stockSistema != $conteoReal) {
                    $producto = Producto::findOrFail($idProducto);
                    
                    // Registrar detalle del conteo
                    $detalle = new \App\Models\DetalleConteoFisico();
                    $detalle->id_conteo = $conteo->id_conteo;
                    $detalle->id_producto = $idProducto;
                    $detalle->stock_anterior = $stockSistema;
                    $detalle->stock_nuevo = $conteoReal;
                    $detalle->save();
                    
                    // Crear movimiento de ajuste
                    $diferencia = $conteoReal - $stockSistema;
                    $tipoMovimiento = $diferencia > 0 ? 'entrada' : 'salida';
                    
                    $movimiento = new MovimientoProducto();
                    $movimiento->id_producto = $idProducto;
                    $movimiento->tipo_movimiento = $tipoMovimiento;
                    $movimiento->cantidad = abs($diferencia);
                    $movimiento->observacion = 'Ajuste por conteo físico: ' . $request->observacion;
                    $movimiento->save();
                    
                    // Actualizar stock del producto
                    $producto->cantidad = $conteoReal;
                    $producto->save();
                    
                    $productosAjustados++;
                }
            }
            
            DB::commit();
            
            if ($productosAjustados > 0) {
                return redirect()->route('inventario.conteo-fisico')
                    ->with('success', "Se han ajustado {$productosAjustados} productos según el conteo físico.");
            } else {
                return redirect()->route('inventario.conteo-fisico')
                    ->with('info', 'No se encontraron diferencias para ajustar en el inventario.');
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al procesar el conteo físico: ' . $e->getMessage());
        }
    }
}