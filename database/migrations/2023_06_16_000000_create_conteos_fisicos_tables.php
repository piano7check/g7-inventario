<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modificar la tabla existente en lugar de crearla
        Schema::table('conteos_fisicos', function (Blueprint $table) {
            // Eliminar columnas existentes que vamos a modificar
            // Verificar si existe la llave foránea antes de intentar eliminarla
            if (Schema::hasColumn('conteos_fisicos', 'id_producto')) {
                // Intentar eliminar la llave foránea si existe
                try {
                    $table->dropForeign(['id_producto']);
                } catch (\Exception $e) {
                    // Si la llave foránea no existe, continuamos
                }
                $table->dropColumn(['id_producto', 'cantidad_contada']);
            }
            
            // Agregar nuevas columnas solo si no existen
            if (!Schema::hasColumn('conteos_fisicos', 'id_usuario')) {
                $table->unsignedBigInteger('id_usuario')->after('id_conteo');
                // Agregar la relación con la tabla usuarios en lugar de users
                $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');
            }
            
            if (!Schema::hasColumn('conteos_fisicos', 'total_productos')) {
                $table->integer('total_productos')->after('observacion');
            }
            
            // La columna fecha_conteo ya existe, pero es de tipo date, la dejamos como está
        });

        // Verificar si la tabla detalle_conteos_fisicos ya existe
        if (!Schema::hasTable('detalle_conteos_fisicos')) {
            Schema::create('detalle_conteos_fisicos', function (Blueprint $table) {
                $table->id('id_detalle_conteo');
                // Corregido para usar la columna id_conteo en lugar de id
                $table->unsignedBigInteger('id_conteo');
                $table->foreign('id_conteo')->references('id_conteo')->on('conteos_fisicos');
                // Corregido para usar la columna id_producto en lugar de id
                $table->unsignedBigInteger('id_producto');
                $table->foreign('id_producto')->references('id_producto')->on('productos');
                $table->integer('stock_anterior');
                $table->integer('stock_nuevo');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_conteos_fisicos');
        Schema::dropIfExists('conteos_fisicos');
    }
};