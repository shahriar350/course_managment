<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user');
            $table->foreign('user')->on('users')->references('id')
                ->cascadeOnDelete();
            $table->unsignedBigInteger('course_schedule');
            $table->foreign('course_schedule')->on('course_schedules')->references('id')
                ->cascadeOnDelete();
            $table->unsignedFloat('class_performance')->nullable();
            $table->unsignedFloat('midterm')->nullable();
            $table->unsignedFloat('final_exam')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('student_courses');
    }
}
