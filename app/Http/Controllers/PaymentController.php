<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Payment;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display the payments portal.
     */
    public function index(Request $request)
    {
        $status = $request->query('status'); // paid, unpaid, or null (all)
        $search = $request->query('search');
        $selectedStudentId = $request->query('student');

        // calculate high-level statistics
        $tuitionFee = 150.00;
        $totalStudentsCount = Student::count();
        
        $paidCount = Student::whereHas('payments', function ($q) {
            $q->where('semester', 'Semester 1')->where('status', 'paid');
        })->count();
        
        $unpaidCount = $totalStudentsCount - $paidCount;
        
        $totalCollected = Payment::where('semester', 'Semester 1')->where('status', 'paid')->sum('amount');
        $totalPending = $unpaidCount * $tuitionFee;

        // Build base student query
        $query = Student::with(['schoolClass', 'payments' => function ($q) {
            $q->orderBy('created_at', 'desc');
        }]);

        // Apply search if present
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $allStudents = $query->get()->sortBy(function ($student) {
            return ($student->schoolClass?->class_name ?? 'ZZZ') . '_' . $student->first_name . ' ' . $student->last_name;
        });

        // Separate and filter by status
        $students = $allStudents->filter(function ($student) use ($status) {
            $s = $student->payment_status;
            if ($status === 'paid') {
                return $s === 'paid';
            } elseif ($status === 'unpaid') {
                return $s === 'unpaid';
            }
            return true;
        });

        // Determine which student is currently selected
        $selectedStudent = null;
        if ($selectedStudentId) {
            $selectedStudent = Student::with(['schoolClass', 'payments' => function($q) {
                $q->latest();
            }])->find($selectedStudentId);
        }

        // If no student is explicitly selected but there are students in our list, auto-select the first one
        if (!$selectedStudent && $students->isNotEmpty()) {
            $selectedStudent = $students->first();
        }

        return view('payments.index', compact(
            'students',
            'status',
            'search',
            'selectedStudent',
            'paidCount',
            'unpaidCount',
            'totalCollected',
            'totalPending',
            'tuitionFee'
        ));
    }

    /**
     * Store a payment for a student.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id'     => 'required|exists:students,id',
            'amount'         => 'required|numeric|min:0',
            'payment_date'   => 'required|date',
            'payment_method' => 'required|string',
            'remarks'        => 'nullable|string',
        ]);

        $payment = Payment::create([
            'student_id'     => $request->student_id,
            'amount'         => $request->amount,
            'payment_date'   => $request->payment_date,
            'status'         => 'paid',
            'payment_method' => $request->payment_method,
            'semester'       => 'Semester 1',
            'academic_year'  => '2023-2024',
            'remarks'        => $request->remarks,
        ]);

        $student = Student::find($request->student_id);

        return redirect()->route('payments.index', [
            'student' => $student->id,
            'status'  => $request->query('status'),
            'search'  => $request->query('search')
        ])->with('success', "ការបង់ប្រាក់ចំនួន \$" . number_format($payment->amount, 2) . " សម្រាប់សិស្ស {$student->full_name} ត្រូវបានកត់ត្រាទុកដោយជោគជ័យ។");
    }

    /**
     * Mark student as unpaid (deletes their active paid payments).
     */
    public function markUnpaid(Request $request, Student $student)
    {
        // Delete paid payments for Semester 1 to revert to unpaid
        $student->payments()->where('semester', 'Semester 1')->where('status', 'paid')->delete();

        return redirect()->route('payments.index', [
            'student' => $student->id,
            'status'  => $request->query('status'),
            'search'  => $request->query('search')
        ])->with('success', "បានលុបព័ត៌មានបង់ប្រាក់ និងផ្លាស់ប្ដូរស្ថានភាពទៅជា មិនទាន់បង់ សម្រាប់សិស្ស {$student->full_name}។");
    }

    /**
     * Display a receipt for printing.
     */
    public function receipt(Payment $payment)
    {
        $payment->load('student.schoolClass');
        return view('payments.receipt', compact('payment'));
    }
}
