<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentCourse extends Model
{
    use HasFactory, SoftDeletes;

    function get_schedule(){
        return $this->hasOne('App\Models\CourseSchedule','id','course_schedule');
    }
    function get_student(){
        return $this->hasOne('App\Models\User','id','user');
    }
}
