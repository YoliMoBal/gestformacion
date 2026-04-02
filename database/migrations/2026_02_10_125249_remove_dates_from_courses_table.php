<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('courses', function (Blueprint $table) {
        if (Schema::hasColumn('courses', 'start_date')) {
            $table->dropColumn('start_date');
        }
        if (Schema::hasColumn('courses', 'end_date')) {
            $table->dropColumn('end_date');
        }
    });
}

public function down()
{
    Schema::table('courses', function (Blueprint $table) {
        $table->date('start_date')->nullable();
        $table->date('end_date')->nullable();
    });
}

};
