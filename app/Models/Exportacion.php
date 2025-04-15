<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exportacion extends Model
{
    public function usuario()
    {
    return $this->belongsTo(Usuario::class, 'id_usuario');
    }

}
