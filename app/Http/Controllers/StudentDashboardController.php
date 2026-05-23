<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Attendance;
use App\Models\ExamSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // ទាញយកព័ត៌មានសិស្សដែលភ្ជាប់ជាមួយ User នេះ រួមជាមួយព័ត៌មានថ្នាក់ និងគ្រូ
        $student = $user->student()->with(['schoolClass.teacher', 'schoolClass.students', 'marks.course'])->first();

        if (!$student) {
            return redirect('/login')->withErrors(['email' => 'គណនីនេះមិនទាន់មានព័ត៌មានសិស្សនៅឡើយទេ។']);
        }

        // Calculate overall score from marks
        $marks = $student->marks;
        $overallScore = $marks->count() > 0 ? round($marks->avg('score')) : 0;
        
        // Get courses with student marks
        $courses = Course::with(['marks' => function($query) use ($student) {
            $query->where('student_id', $student->id);
        }])->get();

        // Count classmates
        $classmatesCount = $student->schoolClass ? $student->schoolClass->students->count() : 0;

        // Calculate attendance rate
        $totalAttendance = Attendance::where('student_id', $student->id)->count();
        $presentAttendance = Attendance::where('student_id', $student->id)
            ->whereIn('status', ['present', 'late'])
            ->count();
        $attendanceRate = $totalAttendance > 0 ? round(($presentAttendance / $totalAttendance) * 100) : 100;

        // Fetch detailed attendance history for this student
        $attendanceLogs = Attendance::with('course')
            ->where('student_id', $student->id)
            ->orderBy('attendance_date', 'desc')
            ->take(10)
            ->get();

        // Fetch upcoming exams
        $upcomingExams = ExamSchedule::with('course')
            ->where('class_id', $student->class_id)
            ->where('exam_date', '>=', now()->toDateString())
            ->orderBy('exam_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        return view('student.dashboard', compact('student', 'overallScore', 'courses', 'classmatesCount', 'attendanceRate', 'attendanceLogs', 'upcomingExams'));
    }

    public function myClass()
    {
        $student = Auth::user()->student;
        
        if (!$student || !$student->class_id) {
            return back()->with('error', 'អ្នកមិនទាន់មានថ្នាក់នៅឡើយទេ។');
        }

        $class = $student->schoolClass()->with(['teacher', 'students'])->first();
        
        return view('student.my-class', compact('class', 'student'));
    }

    public function mySubjects()
    {
        $student = Auth::user()->student;

        if (!$student) {
            return back()->with('error', 'មិនមានព័ត៌មានសិស្ស។');
        }

        // ទាញយកមុខវិជ្ជាទាំងអស់ ជាមួយពិន្ទុរបស់សិស្សម្នាក់នេះ
        $subjects = Course::with(['marks' => function($query) use ($student) {
            $query->where('student_id', $student->id);
        }])->get();

        return view('student.subjects', compact('subjects'));
    }

    public function myExams()
    {
        $student = Auth::user()->student;

        if (!$student) {
            return back()->with('error', 'មិនមានព័ត៌មានសិស្ស។');
        }

        // Fetch upcoming and historical exams for this student's class
        $exams = ExamSchedule::with('course')
            ->where('class_id', $student->class_id)
            ->orderBy('exam_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        return view('student.exams', compact('exams'));
    }

    public function myPayments()
    {
        $student = Auth::user()->student;

        if (!$student) {
            return back()->with('error', 'មិនមានព័ត៌មានសិស្ស។');
        }

        // Load all payments ordered by latest
        $payments = $student->payments()->orderBy('created_at', 'desc')->get();
        
        $tuitionFee = 150.00;
        $isPaid = $student->payment_status === 'paid';
        $latestPayment = $student->latest_payment;

        return view('student.payments', compact('student', 'payments', 'tuitionFee', 'isPaid', 'latestPayment'));
    }

    public function payTuition(Request $request)
    {
        $student = Auth::user()->student;

        if (!$student) {
            return back()->with('error', 'មិនមានព័ត៌មានសិស្ស។');
        }

        if ($student->payment_status === 'paid') {
            return back()->with('error', 'អ្នកបានបង់ប្រាក់រួចរាល់ហើយសម្រាប់ឆមាសនេះ។');
        }

        $request->validate([
            'payment_method' => 'required|string',
            'remarks'        => 'nullable|string',
            'months'         => 'required|integer|min:1|max:12',
        ]);

        $months = (int) $request->months;
        $monthlyRate = 30.00;
        $amount = $months * $monthlyRate;

        $remarks = "Paid for {$months} Month(s). " . ($request->remarks ?: '');

        $payment = \App\Models\Payment::create([
            'student_id'     => $student->id,
            'amount'         => $amount,
            'payment_date'   => now(),
            'status'         => 'paid',
            'payment_method' => $request->payment_method,
            'semester'       => 'Semester 1',
            'academic_year'  => '2023-2024',
            'remarks'        => $remarks,
        ]);

        return redirect()->route('student.payments')->with('success', 'ការបង់ប្រាក់ចំនួន $' . number_format($amount, 2) . ' សម្រាប់រយៈពេល ' . $months . ' ខែ ត្រូវបានកត់ត្រាទុកដោយជោគជ័យ។');
    }

    public function paymentReceipt(\App\Models\Payment $payment)
    {
        $student = Auth::user()->student;

        if (!$student || $payment->student_id !== $student->id) {
            abort(403, 'Unauthorized action.');
        }

        $payment->load('student.schoolClass');
        return view('payments.receipt', compact('payment'));
    }
}
