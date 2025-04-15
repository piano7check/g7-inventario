<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id_producto';

    public function conteos()
    {
        return $this->hasMany(ConteoFisico::class, 'id_producto');
    }

    public function movimientos()
    {
        return $this->hasMany(MovimientoProducto::class, 'id_producto');
    }

    public function modificaciones()
    {
        return $this->hasMany(HistorialModificacion::class, 'id_producto');
    }
}

