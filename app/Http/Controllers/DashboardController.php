<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\SchoolClass;

// Controller សម្រាប់ Dashboard
class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents  = Student::count();
        $totalTeachers  = Teacher::count();
        $totalCourses   = Course::count();
        $totalClasses   = SchoolClass::count();

        // ការបែងចែកភេទសិស្ស
        $maleStudents   = Student::where('gender', 'Male')->count();
        $femaleStudents = Student::where('gender', 'Female')->count();

        // គ្រូថ្មីៗ ៥ នាក់
        $recentTeachers = Teacher::with('classes')->latest()->take(5)->get();

        // សិស្សថ្មីៗ ១០ នាក់
        $recentStudents = Student::with('schoolClass')->latest()->take(10)->get();

        // គណនាប្រាក់ចំណូល (Collected vs Pending)
        // ឧបមាCollected $120 និង Pending $30 ក្នុងសិស្សម្នាក់ (សរុប $150)
        $totalEarnings = $totalStudents * 120;
        $totalPending  = $totalStudents * 30;

        // ទិន្នន័យប្រាក់ចំណូលប្រចាំសប្ដាហ៍ (Mon - Fri) តាមសមាមាត្រសិស្ស
        // Collected Series (Light Blue)
        $thisWeekCollected = [
            (int) round($totalStudents * 15 * 0.9), // Mon
            (int) round($totalStudents * 15 * 1.1), // Tue
            (int) round($totalStudents * 15 * 0.75), // Wed
            (int) round($totalStudents * 15 * 1.0), // Thu
            (int) round($totalStudents * 15 * 1.2), // Fri
        ];
        // Pending Series (Light Purple)
        $thisWeekPending = [
            (int) round($totalStudents * 15 * 0.3),
            (int) round($totalStudents * 15 * 0.15),
            (int) round($totalStudents * 15 * 0.5),
            (int) round($totalStudents * 15 * 0.25),
            (int) round($totalStudents * 15 * 0.35),
        ];

        $lastWeekCollected = [
            (int) round($totalStudents * 15 * 0.8), // Mon
            (int) round($totalStudents * 15 * 0.95), // Tue
            (int) round($totalStudents * 15 * 0.6), // Wed
            (int) round($totalStudents * 15 * 1.1), // Thu
            (int) round($totalStudents * 15 * 0.85), // Fri
        ];
        $lastWeekPending = [
            (int) round($totalStudents * 15 * 0.25),
            (int) round($totalStudents * 15 * 0.2),
            (int) round($totalStudents * 15 * 0.4),
            (int) round($totalStudents * 15 * 0.15),
            (int) round($totalStudents * 15 * 0.3),
        ];

        // ទាញយកបញ្ជីថ្នាក់ទាំងអស់សម្រាប់ filter
        $classesList = SchoolClass::orderBy('class_name')->get();

        // រៀបចំស្ថិតិសិស្សតាមថ្នាក់នីមួយៗ (សម្រាប់ donut chart)
        $classStats = [
            'all' => [
                'total'  => $totalStudents,
                'male'   => $maleStudents,
                'female' => $femaleStudents,
            ]
        ];

        foreach ($classesList as $cls) {
            $classStats[$cls->id] = [
                'total'  => Student::where('class_id', $cls->id)->count(),
                'male'   => Student::where('class_id', $cls->id)->where('gender', 'Male')->count(),
                'female' => Student::where('class_id', $cls->id)->where('gender', 'Female')->count(),
            ];
        }

        return view('dashboard.index', compact(
            'totalStudents', 'totalTeachers', 'totalCourses', 'totalClasses',
            'maleStudents', 'femaleStudents', 'recentTeachers', 'recentStudents',
            'totalEarnings', 'totalPending',
            'thisWeekCollected', 'thisWeekPending',
            'lastWeekCollected', 'lastWeekPending',
            'classesList', 'classStats'
        ));
    }

    public function guest()
    {
        $totalStudents  = Student::count();
        $totalTeachers  = Teacher::count();
        $totalCourses   = Course::count();
        $totalClasses   = SchoolClass::count();

        $maleStudents   = Student::where('gender', 'Male')->count();
        $femaleStudents = Student::where('gender', 'Female')->count();

        $recentTeachers = Teacher::with('classes')->latest()->take(5)->get();

        return view('guest.index', compact(
            'totalStudents', 'totalTeachers', 'totalCourses', 'totalClasses',
            'maleStudents', 'femaleStudents', 'recentTeachers'
        ));
    }
}
