<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course');
            $table->foreign('course')->on('courses')->references('id')
                ->cascadeOnDelete();
            $table->unsignedBigInteger('teacher');
            $table->foreign('teacher')->on('users')->references('id')
                ->cascadeOnDelete();
            $table->string('day');
            $table->time('time');
            $table->string('room',11);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_schedules');
    }
}
