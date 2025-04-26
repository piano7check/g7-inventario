<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Definir el nombre de la tabla (si no es plural automáticamente detectado)
    protected $table = 'productos';

    // Definir la clave primaria (para que reconozca 'id_productos')
    protected $primaryKey = 'id_producto';

    // Desactivar la autoincrementación si 'id_productos' no es autoincrementable
    public $incrementing = true;

    // Definir los campos que se pueden asignar masivamente (Rellenables)
    protected $fillable = [
        'id_producto',
        'nombre',
        'codigo',
        'unidad_medida',
        'categoria',
        'cantidad',
        'observacion',
    ];
}
