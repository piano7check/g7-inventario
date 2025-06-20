<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Cambiado el nombre del archivo para que se ejecute antes de la migración que añade stock_minimo
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id('id_producto');
            $table->string('codigo', 50)->unique();
            $table->string('nombre', 100);
            $table->string('categoria', 100);
            $table->string('unidad_medida', 50);
            $table->integer('cantidad')->default(0);
            $table->string('imagen')->nullable();
            $table->text('observacion')->nullable();

            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};