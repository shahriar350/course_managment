<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
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
                if (\Auth::user()->hasRole('admin')){
                    return redirect()->intended(route('admin.dashboard'));
                }
                auth()->logout();
            }
            return redirect()->route('admin.login')->with('message','Wrong credential');

        } else {
            return view('admin.auth.login');
        }
    }
    function logout(){
        auth()->logout();
        return redirect()->route('admin.login');
    }
}
