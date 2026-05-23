<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SelfResetPasswordController extends Controller
{
    // Show the identity verification form
    public function showVerifyForm()
    {
        return view('auth.passwords.verify');
    }

    // Verify user identity
    public function verify(Request $request)
    {
        $role = $request->input('role');
        $email = $request->input('email');

        if ($role === 'student') {
            $request->validate([
                'email' => 'required|email',
                'student_id' => 'required|string',
                'phone' => 'required|string',
            ], [
                'email.required' => 'សូមបញ្ចូលអ៊ីមែល / Please enter email',
                'student_id.required' => 'សូមបញ្ចូលអត្តលេខសិស្ស / Please enter Student ID',
                'phone.required' => 'សូមបញ្ចូលលេខទូរស័ព្ទ / Please enter phone number',
            ]);

            $student = Student::where('email', $email)
                ->where('student_id', $request->input('student_id'))
                ->where('phone', $request->input('phone'))
                ->first();

            if (!$student || !$student->user) {
                return back()->withErrors(['message' => 'ព័ត៌មានសិស្សមិនត្រឹមត្រូវ ឬគ្មានគណនីក្នុងប្រព័ន្ធ! / Invalid student credentials or account not found!'])->withInput();
            }

            session(['reset_verified_user_id' => $student->user_id]);
            return redirect()->route('password.self_reset.new');

        } elseif ($role === 'teacher') {
            $request->validate([
                'email' => 'required|email',
                'teacher_id' => 'required|string',
                'phone' => 'required|string',
            ], [
                'email.required' => 'សូមបញ្ចូលអ៊ីមែល / Please enter email',
                'teacher_id.required' => 'សូមបញ្ចូលអត្តលេខគ្រូ / Please enter Teacher ID',
                'phone.required' => 'សូមបញ្ចូលលេខទូរស័ព្ទ / Please enter phone number',
            ]);

            $teacher = Teacher::where('email', $email)
                ->where('teacher_id', $request->input('teacher_id'))
                ->where('phone', $request->input('phone'))
                ->first();

            if (!$teacher || !$teacher->user) {
                return back()->withErrors(['message' => 'ព័ត៌មានគ្រូមិនត្រឹមត្រូវ ឬគ្មានគណនីក្នុងប្រព័ន្ធ! / Invalid teacher credentials or account not found!'])->withInput();
            }

            session(['reset_verified_user_id' => $teacher->user_id]);
            return redirect()->route('password.self_reset.new');
        }

        return back()->withErrors(['message' => 'សូមជ្រើសរើសតួនាទីត្រឹមត្រូវ! / Please select a valid role!']);
    }

    // Show the choose new password form
    public function showNewPasswordForm()
    {
        if (!session()->has('reset_verified_user_id')) {
            return redirect()->route('password.self_reset.verify')->withErrors(['message' => 'សូមផ្ទៀងផ្ទាត់អត្តសញ្ញាណជាមុនសិន! / Please verify your identity first!']);
        }

        return view('auth.passwords.new');
    }

    // Save the new password
    public function reset(Request $request)
    {
        if (!session()->has('reset_verified_user_id')) {
            return redirect()->route('password.self_reset.verify')->withErrors(['message' => 'សូមផ្ទៀងផ្ទាត់អត្តសញ្ញាណជាមុនសិន! / Please verify your identity first!']);
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.required' => 'សូមបញ្ចូលពាក្យសម្ងាត់ថ្មី / Please enter a new password',
            'password.min' => 'ពាក្យសម្ងាត់ត្រូវមានយ៉ាងហោចណាស់ ៨ ខ្ទង់ / Password must be at least 8 characters',
            'password.confirmed' => 'ការបញ្ជាក់ពាក្យសម្ងាត់មិនត្រូវគ្នា / Password confirmation does not match',
        ]);

        $user = User::findOrFail(session('reset_verified_user_id'));
        $user->update([
            'password' => Hash::make($request->input('password')),
        ]);

        session()->forget('reset_verified_user_id');

        return redirect()->route('login')->with('success', 'ពាក្យសម្ងាត់ត្រូវបានផ្លាស់ប្តូរដោយជោគជ័យ! សូមចូលប្រព័ន្ធ។ / Password updated successfully! Please log in.');
    }
}
