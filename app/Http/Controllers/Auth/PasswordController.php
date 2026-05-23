<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    /**
     * Show the form for changing the user's password.
     */
    public function edit()
    {
        return view('auth.change-password');
    }

    /**
     * Update the user's password in the database.
     */
    public function update(Request $request)
    {
        // Custom validation to verify current password and validate the new one
        $request->validate([
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('ពាក្យសម្ងាត់បច្ចុប្បន្នមិនត្រឹមត្រូវទេ។ (Current password is incorrect)');
                    }
                }
            ],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'សូមបញ្ចូលពាក្យសម្ងាត់បច្ចុប្បន្នរបស់អ្នក។ (Please enter your current password)',
            'new_password.required' => 'សូមបញ្ចូលពាក្យសម្ងាត់ថ្មី។ (Please enter a new password)',
            'new_password.min' => 'ពាក្យសម្ងាត់ថ្មីត្រូវតែមានយ៉ាងហោចណាស់ ៨ ខ្ទង់។ (New password must be at least 8 characters)',
            'new_password.confirmed' => 'ការបញ្ជាក់ពាក្យសម្ងាត់ថ្មីមិនត្រូវគ្នាទេ។ (New password confirmation does not match)',
        ]);

        // Update password
        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        // Determine redirect target based on user role
        $role = $user->role;
        if ($role === 'student') {
            $redirectUrl = route('student.dashboard');
        } elseif ($role === 'teacher') {
            $redirectUrl = route('teacher.dashboard');
        } else {
            $redirectUrl = route('dashboard');
        }

        return redirect($redirectUrl)->with('success', 'ពាក្យសម្ងាត់របស់អ្នកត្រូវបានផ្លាស់ប្តូរដោយជោគជ័យ! (Your password has been changed successfully!)');
    }
}
