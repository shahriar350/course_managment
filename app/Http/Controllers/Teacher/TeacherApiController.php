<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\CourseSchedule;
use App\Models\StudentCourse;
use Illuminate\Http\Request;

class TeacherApiController extends Controller
{
    function login(Request $request){
        if ($request->isMethod('post')){
            $request->validate([
                'username' => 'required',
                'password' => 'required',
            ]);
            $cred = [
                'username' => $request->get('username'),
                'password' => $request->get('password')
            ];
            if (\Auth::attempt($cred)){
                if (\Auth::user()->hasRole('teacher')){
                    return redirect()->intended(route('teacher.dashboard'));
                }
                auth()->logout();
            }
            return redirect()->route('teacher.login')->with('message','Wrong credential');

        } else {
            return view('teacher.auth.login');
        }
    }

    function index(){
        $total_class = collect(CourseSchedule::where('teacher',auth()->user()->id)->get())->count();
        return view('teacher.index',compact('total_class'));
    }
    function schedule(Request $request){
        if ($request->isMethod('post')){
            $request->validate([
                'id'=> 'required|integer',
                'mid_term'=> 'required|numeric',
                'final'=> 'required|numeric',
                'class_performance'=> 'required|numeric',
            ]);
            $course = StudentCourse::findOrFail($request->id);
            if ($course){
                $course->midterm = $request->mid_term;
                $course->final_exam = $request->final;
                $course->class_performance = $request->class_performance;
                $course->update();
                return http_response_code(200);
            }

        } else {
            return response()->json([
                'data' => CourseSchedule::with('get_course','get_student_course.get_student')
                    ->where('teacher',auth()->user()->id)->get(),
            ]);
        }
    }
}
