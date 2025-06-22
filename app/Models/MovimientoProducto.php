<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimientoProducto extends Model
{
    use HasFactory;
    
    protected $table = 'movimientos_productos';
    protected $primaryKey = 'id_movimiento';
    
    protected $fillable = [
        'id_producto',
        'tipo_movimiento',
        'cantidad',
        'fecha_movimiento',
        'observacion'
    ];
    
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
