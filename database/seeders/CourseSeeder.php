<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

// Seeder សម្រាប់បង្កើតទិន្នន័យមុខវិជ្ជា
class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // មុខវិជ្ជា ១០ ព្រឹត្តការ
        $courses = [
            ['course_code' => 'CS101', 'course_name' => 'Introduction to Computer Science', 'description' => 'Basic concepts of computing and programming.', 'credit' => 3],
            ['course_code' => 'MATH201', 'course_name' => 'Advanced Mathematics', 'description' => 'Calculus, algebra, and statistics.', 'credit' => 4],
            ['course_code' => 'ENG101', 'course_name' => 'English Communication', 'description' => 'Speaking, listening, reading and writing skills.', 'credit' => 3],
            ['course_code' => 'PHY101', 'course_name' => 'Physics I', 'description' => 'Mechanics, thermodynamics, and waves.', 'credit' => 4],
            ['course_code' => 'CHEM101', 'course_name' => 'Chemistry I', 'description' => 'Atomic structure, bonds, and reactions.', 'credit' => 3],
            ['course_code' => 'BIO101', 'course_name' => 'Biology', 'description' => 'Cell biology, genetics, and ecology.', 'credit' => 3],
            ['course_code' => 'HIS101', 'course_name' => 'Khmer History', 'description' => 'Cambodian history from Angkor to modern era.', 'credit' => 2],
            ['course_code' => 'GEO101', 'course_name' => 'Geography', 'description' => 'Physical and human geography.', 'credit' => 2],
            ['course_code' => 'ECON101', 'course_name' => 'Economics', 'description' => 'Micro and macroeconomics fundamentals.', 'credit' => 3],
            ['course_code' => 'ART101', 'course_name' => 'Art & Design', 'description' => 'Creative arts, drawing, and digital design.', 'credit' => 2],
        ];

        foreach ($courses as $course) {
            Course::updateOrCreate(['course_code' => $course['course_code']], $course);
        }

        $this->command->info('✅ 10 courses seeded.');
    }
}
