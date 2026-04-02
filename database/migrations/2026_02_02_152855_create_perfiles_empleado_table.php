<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('perfiles_empleado', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
              ->constrained()
              ->cascadeOnDelete();

            $table->foreignId('codigo_concesionario_id')
              ->constrained('codigos_concesionario');

            $table->foreignId('departamento_id')
              ->constrained('departamentos');

            $table->foreignId('puesto_id')
              ->constrained('puestos');

            $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perfiles_empleado');
    }
};
