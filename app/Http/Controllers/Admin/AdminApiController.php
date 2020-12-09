<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSchedule;
use App\Models\Role;
use App\Models\Setup;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use Validator;

class AdminApiController extends Controller
{
    function teacher_init(Request $request, $id = null)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required',
                'username' => 'required|min:6|unique:users,username',
                'password' => 'required|string',
                'gender' => 'required|in:man,woman',
                'age' => 'required|numeric',
            ]);
            $user = new User();
            $user->name = $request->get('name');
            $user->username = $request->get('username');
            $user->password = bcrypt($request->get('password'));
            $user->gender = $request->get('gender');
            $user->age = $request->get('age');
            if ($user->save()) {
                $teacherRole = Role::where('name', 'teacher')->first();
                $user->attachRole($teacherRole);
                return response()->json(['data' => $user], 200);
            }
        } elseif ($request->isMethod('delete')) {
            if (isset($id)) {
                $user = User::findOrFail($id);
                if ($user && $user->delete()) {
                    return http_response_code(200);
                }

            }
        } else {
            return response()->json(['data' => User::whereRoleIs('teacher')->get()]);
        }
    }

    function course(Request $request, $id = null)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string',
                'code' => 'required|string',
                'credit' => 'required|numeric',
                'prerequisite' => 'nullable',
            ]);
            $course = new Course();
            $course->name = $request->get('name');
            $course->code = $request->get('code');
            $course->credit = (int)$request->get('credit');
            if (isset($request->prerequisite)) {
                $course->prerequisite = $request->prerequisite['id'];
            }
            $course->save();
            $course['get_precourse'] = $course->get_precourse;
            return response()->json(['data' => $course]);
        } elseif ($request->isMethod('delete')) {
            if (isset($id)) {
                $course = Course::findOrFail($id);
                if ($course && $course->delete()) {
                    return http_response_code(200);
                }
            }
        } else {
            return response()->json(['data' => Course::with('get_precourse')->get()], 200);
        }
    }

    function schedule(Request $request, $id = null)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'course' => 'required',
                'teacher' => 'required',
                'time' => 'required|regex:/(\d+\:\d+)/',
                'room' => 'required',
                'day' => 'required|in:monday,tuesday,wednesday,thursday,friday',
            ]);
            $overlapTeacher = CourseSchedule::where('time',$request->time)->where('day',$request->day)->where('teacher',$request->teacher['id'])->count();
            $overlapRoom = CourseSchedule::where('room',$request->room)->where('day',$request->day)->where('time',$request->time)->count();
            if ($overlapTeacher === 0 && $overlapRoom === 0){
                $schedule = new CourseSchedule();
                $schedule->course = $request->course['id'];
                $schedule->teacher = $request->teacher['id'];
                $schedule->time = $request->get('time');
                $schedule->room = $request->get('room');
                $schedule->day = $request->get('day');
                $schedule->save();
                $schedule['get_teacher'] = $schedule->get_teacher;
                $schedule['get_course'] = $schedule->get_course;
                return response()->json(['data' => $schedule]);
            } else {
                $error = array();
                if ($overlapTeacher > 0){
                    array_push($error,ucfirst($request->teacher['name']).' is already assigned in this time');
                } else {
                    array_push($error,'Room '.$request->get('room').' is not available in this time');
                }
                return response()->json(['data'=>$error],404);
            }



        } elseif ($request->isMethod('delete')) {
            if (isset($id)) {
                $course = CourseSchedule::findOrFail($id);
                if ($course && $course->delete()) {
                    return http_response_code(200);
                }
            }
        } else {
            return response()->json([
                'data' => CourseSchedule::with('get_teacher', 'get_course')->get(),
            ], 200);
        }
    }

    function registration_date(Request $request){
        if ($request->isMethod('post')){
            $request->validate([
                'start' => 'required|date',
                'end' => 'required|date',
            ]);
//            return $request->start;
            $setup = Setup::first();
            if ($setup){
                $setup->registration_start = $request->start;
                $setup->registration_end = $request->end;
                $setup->save();
                return http_response_code(200);
            } else {
                $setup = new Setup();
                $setup->registration_start = $request->start;
                $setup->registration_end = $request->end;
                $setup->save();
                return http_response_code(200);
            }

        } else {
            return response()->json(['data' => Setup::select('registration_start','registration_end')->first()]);
        }
    }
}
