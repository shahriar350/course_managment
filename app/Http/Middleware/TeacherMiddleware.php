<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TeacherMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->hasRole('teacher')){
            return $next($request);
        } else {
            if ($request->wantsJson()){
                return response('Authenticated request',500);
            } else {
                return redirect()->route('teacher.login');
            }
        }
    }
}
