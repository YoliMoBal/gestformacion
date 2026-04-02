<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_calls', function (Blueprint $table) {
            $table->id();

            $table->foreignId('course_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->date('start_date');
            $table->date('end_date')->nullable();

            $table->integer('notify_days_before')->default(7);
            $table->boolean('notify_on_start')->default(true);
            $table->boolean('notify_on_end')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_calls');
    }
};


