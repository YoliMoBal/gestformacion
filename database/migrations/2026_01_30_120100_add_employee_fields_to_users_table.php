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
    Schema::table('users', function (Blueprint $table) {
        $table->string('dni')->nullable()->after('email');
        $table->string('dealer_code')->after('dni');
        $table->foreignId('location_id')->nullable()->after('dealer_code');
        $table->foreignId('department_id')->nullable()->after('location_id');
        $table->foreignId('job_position_id')->nullable()->after('department_id');
        $table->boolean('active')->default(true)->after('job_position_id');
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn([
            'dni',
            'dealer_code',
            'location_id',
            'department_id',
            'job_position_id',
            'active'
        ]);
    });
}

};
