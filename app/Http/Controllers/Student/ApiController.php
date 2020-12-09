<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSchedule;
use App\Models\Setup;
use App\Models\StudentCourse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    function all_course()
    {
        return response()->json([
            'data' => CourseSchedule::with('get_course', 'get_teacher')->get(),
        ]);
    }

    function course(Request $request, $id = null)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'courses' => 'required|array',
            ]);
            $setup = Setup::first();
            $now = Carbon::now();
            if ($now->toDateString() >= $setup->registration_start && $now->toDateString() <= $setup->registration_end) {
                // $request have CourseSchedule model
                $studentSelectedCourse = StudentCourse::with('get_schedule.get_course')
                    ->where('user', auth()->user()->id)->get();
//            return response($studentSelectedCourse,411);
                //get total credit which already in our database

                $totalCredit = $studentSelectedCourse->pluck('get_schedule.get_course')->sum('credit');
                if ($studentSelectedCourse) {
                    foreach ($request->courses as $course) {
                        $prereq = StudentCourse::onlyTrashed()->with('get_schedule')->where('user', auth()->user()->id)->get()
                            ->pluck('get_schedule');
                        //check if student complete prerequisite course
                        if (isset($course['get_course']['prerequisite'])) {
                            if ($prereq->where('course', $course['get_course']['prerequisite'])->count() === 0) {
                                $coursepre = Course::findOrFail($course['get_course']['prerequisite']);
                                return response()->json(['message' => 'You must complete ' . $coursepre->name . '-' . $coursepre->code], 411);
                            }
                        }
                        //sum all request credit with user already enrolled subject credit
                        $totalCredit += $course['get_course']['credit'];
                        //check student course that he cannot enroll same subject again
                        if ($studentSelectedCourse->pluck('get_schedule')->where('course', '=', $course['course'])->count() > 0) {
                            return response()->json(['message' => $course['get_course']['name'] . '-' . $course['get_course']['code']
                                . ' is already added in your schedule '], 411);
                            //check student time that make sure time donot overlap
                        } elseif ($studentSelectedCourse->pluck('get_schedule')
                                ->where('time', '=', $course['time'])
                                ->where('day', '=', $course['day'])->count() > 0) {
                            return response()->json(['message' => 'You have already a class at ' .$course['day'].' - '. $course['time']], 411);
                        }

                    }
                }
                //check credit. maximum 18 credit can be added
                if ($totalCredit >= 18) {
                    return response()->json(['message' => 'Maximum 18 credit can be enroll. You already add ' . $studentSelectedCourse->pluck('get_schedule.get_course')->sum('credit') . '.']);
                }
                //after checking all staff. Student are free to add their course
                foreach ($request->courses as $courseSchedule) {
                    $add_course = new StudentCourse();
                    $add_course->user = auth()->user()->id;
                    $add_course->course_schedule = $courseSchedule['id'];
                    $add_course->save();
                }
                return response()->json(['data' => StudentCourse::with('get_schedule.get_course', 'get_schedule.get_teacher')->where('user', auth()->user()->id)->get()]);

            } else {
                if ($now->toDateString() < $setup->registration_start) {
                    return response()->json(['message' => 'Registration will start at ' . $setup->registration_start], 422);
                } else {
                    return response()->json(['message' => 'Registration time was over'], 422);
                }
            }


        } elseif ($request->isMethod('delete')) {
            if (isset($id)) {
                $schedule = StudentCourse::findOrFail($id);
                if ($schedule && $schedule->forceDelete()) {
                    return http_response_code(200);
                }
                return http_response_code(500);
            }
        } else {
            return response()->json([
                'data' => StudentCourse::with('get_schedule.get_course', 'get_schedule.get_teacher')->where('user', auth()->user()->id)->get(),
            ]);
        }
    }
}
