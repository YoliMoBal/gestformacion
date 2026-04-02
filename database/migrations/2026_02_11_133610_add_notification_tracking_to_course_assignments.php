<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('course_assignments', function (Blueprint $table) {
            $table->timestamp('notified_7_days_at')->nullable();
            $table->timestamp('notified_3_days_at')->nullable();
            $table->timestamp('notified_1_day_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('course_assignments', function (Blueprint $table) {
            $table->dropColumn([
                'notified_7_days_at',
                'notified_3_days_at',
                'notified_1_day_at'
            ]);
        });
    }
};

