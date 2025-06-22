<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleConteoFisico extends Model
{
    protected $table = 'detalle_conteos_fisicos';
    protected $primaryKey = 'id_detalle_conteo';

    protected $fillable = [
        'id_conteo',
        'id_producto',
        'stock_anterior',
        'stock_nuevo',
    ];

    public $timestamps = true;

    /**
     * Relación con el conteo físico
     */
    public function conteo()
    {
        return $this->belongsTo(ConteoFisico::class, 'id_conteo');
    }

    /**
     * Relación con el producto
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}