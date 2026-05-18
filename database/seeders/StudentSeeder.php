<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Database\Seeder;

// Seeder សម្រាប់បង្កើតទិន្នន័យសិស្ស
class StudentSeeder extends Seeder
{
    public function run(): void
    {
        // ទទួលថ្នាក់ទាំងអស់
        $classes = SchoolClass::all();

        if ($classes->isEmpty()) {
            $this->command->warn('⚠️ No classes found. Run ClassSeeder first.');
            return;
        }

        // បង្កើតសិស្ស ៣០ នាក់ ចែកចូលថ្នាក់
        Student::factory()
            ->count(30)
            ->make()
            ->each(function ($student) use ($classes) {
                // ចាត់សិស្សចូលថ្នាក់ randomly
                $student->class_id = $classes->random()->id;
                $student->save();
            });

        $this->command->info('✅ 30 students seeded across ' . $classes->count() . ' classes.');
    }
}
