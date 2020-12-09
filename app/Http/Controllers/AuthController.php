<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    function register(Request $request){
        if ($request->isMethod('post')){
            $request->validate([
                'name' => 'required',
                'username' => 'required|email|unique:users,username',
                'password' => 'required|confirmed|string',
                'gender' => 'required|in:man,woman',
                'age' => 'required|numeric',
                'school' => 'required',
                'department' => 'required',
                'student_id' => 'required',
            ]);
            $user = new User();
            $user->name = $request->get('name');
            $user->username = $request->get('username');
            $user->password = bcrypt($request->get('password'));
            $user->gender = $request->get('gender');
            $user->age = $request->get('age');
            $user->school = $request->get('school');
            $user->department = $request->get('department');
            $user->student_id = $request->get('student_id');
            if ($user->save()){
                $studentRole = Role::where('name','student')->first();
                $user->attachRole($studentRole);
                return redirect()->route('student.login');
            }
        } else {
            return view('student.auth.register');
        }
    }
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
                if (\Auth::user()->hasRole('student')){
                    return redirect()->intended(route('student.dashboard'));
                }
                auth()->logout();
            }
            return redirect()->route('student.login')->with('message','Wrong credential');

        } else {
            return view('student.auth.login');
        }
    }
    function logout(){
        auth()->logout();
        return redirect()->route('student.login');
    }
}
