<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSchedule extends Model
{
    use HasFactory;

    function get_course(){
        return $this->hasOne('App\Models\Course','id','course');
    }
    function get_teacher(){
        return $this->hasOne('App\Models\User','id','teacher');
    }
    function get_student_course(){
        return $this->hasMany('App\Models\StudentCourse','course_schedule','id');
    }
    protected $casts = [
//        'time' => 'timestamp'
    ];
}
