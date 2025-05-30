<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConteoFisico extends Model
{
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
    
}
