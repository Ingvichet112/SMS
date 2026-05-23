<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Controller សម្រាប់ Login
class LoginController extends Controller
{
    // បង្ហាញទំព័រ Login
    public function showLoginForm()
    {
        return view('auth.login');
    }




    // ដំណើរការ Login
    public function login(Request $request)
    {
        // Validate ទិន្នន័យ
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // ព្យាយាម Login
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            if ($user->role === 'student') {
                return redirect()->intended('/student/dashboard')
                    ->with('success', 'ចូលប្រព័ន្ធបានជោគជ័យ ក្នុងនាមជាសិស្ស!');
            }
            if ($user->role === 'teacher') {
                return redirect()->intended('/teacher/dashboard')
                    ->with('success', 'ចូលប្រព័ន្ធបានជោគជ័យ ក្នុងនាមជាគ្រូបង្រៀន!');
            }

            return redirect()->intended('/dashboard')
                ->with('success', 'ចូលប្រព័ន្ធបានជោគជ័យ!');
        }

        // Login បរាជ័យ
        return back()->withErrors([
            'email' => 'អ៊ីមែល ឬ ពាក្យសម្ងាត់មិនត្រឹមត្រូវ។',
        ])->onlyInput('email');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'អ្នកបានចាកចេញប្រព័ន្ធដោយជោគជ័យ!');
    }
}
