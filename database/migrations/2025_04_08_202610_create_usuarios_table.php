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
    Schema::create('usuarios', function (Blueprint $table) {
        $table->id('id_usuario');
        $table->string('nombre', 100);
        $table->string('correo', 100)->unique();
        $table->string('contrasena');
        $table->enum('rol', ['administrador', 'registrador'])->default('registrador');
        $table->string('documento_identidad', 20)->unique();  // Añadir esta línea para el documento de identidad
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
