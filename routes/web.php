<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
//student start
Route::match(['get','post'],'/register',
    [\App\Http\Controllers\AuthController::class,'register'])
    ->name('student.register');
Route::match(['get','post'],'/login',
    [\App\Http\Controllers\AuthController::class,'login'])
    ->name('student.login');
Route::group(['prefix' => 'student','middleware' => 'student'],function (){
    Route::view('/dashboard','student.index')->name('student.dashboard');
    Route::post('/logout',[\App\Http\Controllers\AuthController::class,'logout'])->name('student.logout');
    Route::view('/courses','student.components.courses.index')
        ->name('student.course');
    Route::get('/all/course',[\App\Http\Controllers\Student\ApiController::class,'all_course']);
    Route::match(['get','post','delete'],'/courses/init/{id?}',[
         \App\Http\Controllers\Student\ApiController::class,'course'
    ]);
});
//student end
//admin start
Route::match(['get','post'],'/admin/login',[
    \App\Http\Controllers\Admin\AuthController::class,'login'
])->name('admin.login');
Route::group(['prefix' => 'admin','middleware' => 'admin'],function (){
    Route::view('dashboard','admin.index')->name('admin.dashboard');
    Route::view('setup','admin.components.setup')->name('admin.setup');
    Route::post('/logout',[\App\Http\Controllers\Admin\AuthController::class,'logout'])->name('admin.logout');
    Route::view('/teacher','admin.components.teacher.index')->name('admin.teacher');
    Route::match(['get','post','delete'],'/teacher/init/{id?}',[\App\Http\Controllers\Admin\AdminApiController::class,'teacher_init']);
    Route::view('/course','admin.components.course.index')->name('admin.course');
    Route::match(['get','post','delete'],'/course/init/{id?}',[\App\Http\Controllers\Admin\AdminApiController::class,'course']);
    Route::view('/schedule','admin.components.class_related.index')->name('admin.schedule');
    Route::match(['get','post','delete'],'/schedule/init/{id?}',[\App\Http\Controllers\Admin\AdminApiController::class,'schedule']);
    Route::match(['get','post'],'/registration/date',[\App\Http\Controllers\Admin\AdminApiController::class,'registration_date']);
    //api
    Route::match(['get','post'],'/role/related',[\App\Http\Controllers\SetupController::class,'roles']);
});
//admin end

Route::match(['post','get'],'/teacher/login',[\App\Http\Controllers\Teacher\TeacherApiController::class,'login'])->name('teacher.login');
Route::group(['middleware' => 'teacher','prefix' => 'teacher'], function (){
    Route::get('/dashboard',[\App\Http\Controllers\Teacher\TeacherApiController::class,'index'])->name('teacher.dashboard');
    Route::view('/schedule','teacher.components.schedule')->name('teacher.schedule');
    Route::match(['post','get','delete'],'/schedule/init',[\App\Http\Controllers\Teacher\TeacherApiController::class,'schedule']);
});
