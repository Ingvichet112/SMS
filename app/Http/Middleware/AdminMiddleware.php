<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ពិនិត្យថាតើ User បាន Login និងមិនមែនជា Student
        if (Auth::check() && Auth::user()->role !== 'student') {
            return $next($request);
        }

        // ប្រសិនបើជា Student ឱ្យទៅកាន់ Profile វិញ
        if (Auth::check() && Auth::user()->role === 'student') {
            return redirect()->route('student.dashboard')->with('error', 'អ្នកមិនមានសិទ្ធិចូលប្រើផ្នែកនេះទេ។');
        }

        // ផ្សេងពីនេះ (Guest) ឱ្យទៅ Login
        return redirect()->route('login');
    }
}
