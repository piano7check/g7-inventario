<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConteoFisico extends Model
{
    protected $table = 'conteos_fisicos';
    protected $primaryKey = 'id_conteo';

    protected $fillable = [
        'id_usuario',
        'fecha_conteo',
        'observacion',
        'total_productos',
    ];

    public $timestamps = true;

    /**
     * Relación con el usuario que realizó el conteo
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    /**
     * Relación con los detalles del conteo
     */
    public function detalles()
    {
        return $this->hasMany(DetalleConteoFisico::class, 'id_conteo');
    }
}
