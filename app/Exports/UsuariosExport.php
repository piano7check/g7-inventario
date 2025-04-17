<?php

namespace App\Exports;

use App\Models\Usuario;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsuariosExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Usuario::select('id_usuario', 'nombre', 'documento_identidad', 'correo', 'rol')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Nombre', 'Cédula de Identidad', 'Correo Electrónico', 'Rol'];
    }
}
