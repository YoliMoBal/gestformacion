<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('course_assignments', function (Blueprint $table) {

            // Eliminar columna antigua
            $table->dropForeign(['course_id']);
            $table->dropColumn('course_id');

            // Añadir nueva relación
            $table->foreignId('course_call_id')
                  ->after('user_id')
                  ->constrained('course_calls')
                  ->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::table('course_assignments', function (Blueprint $table) {

            $table->dropForeign(['course_call_id']);
            $table->dropColumn('course_call_id');

            $table->foreignId('course_id')
                  ->constrained()
                  ->cascadeOnDelete();
        });
    }
};

