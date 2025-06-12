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
        Schema::create('conteos_fisicos', function (Blueprint $table) {
            $table->id('id_conteo');
            $table->foreignId('id_usuario')->constrained('users');
            $table->timestamp('fecha_conteo');
            $table->text('observacion')->nullable();
            $table->integer('total_productos');
            $table->timestamps();
        });

        Schema::create('detalle_conteos_fisicos', function (Blueprint $table) {
            $table->id('id_detalle_conteo');
            $table->foreignId('id_conteo')->constrained('conteos_fisicos');
            $table->foreignId('id_producto')->constrained('productos');
            $table->integer('stock_anterior');
            $table->integer('stock_nuevo');
            $table->timestamps();
        });
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