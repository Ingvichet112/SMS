<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TeacherMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ពិនិត្យថាតើ User បាន Login និងជា Teacher
        if (Auth::check() && Auth::user()->isTeacher()) {
            return $next($request);
        }

        // ប្រសិនបើជា Student ឱ្យទៅកាន់ Profile វិញ
        if (Auth::check() && Auth::user()->isStudent()) {
            return redirect()->route('student.dashboard')->with('error', 'អ្នកមិនមានសិទ្ធិចូលប្រើផ្នែកនេះទេ។');
        }

        // ផ្សេងពីនេះ (Guest/Admin/Staff) ឱ្យទៅ Login ឬ Dashboard វិញ
        if (Auth::check()) {
            return redirect()->route('dashboard')->with('error', 'អ្នកមិនមានសិទ្ធិចូលប្រើផ្នែកនេះទេ។');
        }

        return redirect()->route('login');
    }
}
