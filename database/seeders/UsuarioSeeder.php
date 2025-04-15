<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        Usuario::create([
            'nombre' => 'Admin Master',
            'correo' => 'admin@uab.com',
            'contrasena' => bcrypt('admin123'),
            'rol' => 'administrador',
        ]);
    }
}
