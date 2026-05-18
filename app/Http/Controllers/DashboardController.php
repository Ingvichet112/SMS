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

        return view('dashboard.index', compact(
            'totalStudents', 'totalTeachers', 'totalCourses', 'totalClasses',
            'maleStudents', 'femaleStudents', 'recentTeachers', 'recentStudents'
        ));
    }
}
