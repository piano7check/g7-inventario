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
            'documento_identidad' => '99999999', // ✅ AGREGA ESTE CAMPO
            'correo' => 'admin@uab.com',
            'contrasena' => bcrypt('123456'),
            'rol' => 'administrador',
        ]);
    }
}
