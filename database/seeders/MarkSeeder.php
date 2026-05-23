<?php

namespace Database\Seeders;

use App\Models\Mark;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Database\Seeder;

class MarkSeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::all();
        $courses = Course::all();

        foreach ($students as $student) {
            foreach ($courses as $course) {
                Mark::create([
                    'student_id' => $student->id,
                    'course_id'  => $course->id,
                    'score'      => rand(50, 98), // Random score between 50 and 98
                    'semester'   => 'Semester 1',
                    'academic_year' => '2023-2024',
                ]);
            }
        }
    }
}
