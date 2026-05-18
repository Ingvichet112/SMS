<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

// Seeder សម្រាប់បង្កើតទិន្នន័យថ្នាក់រៀន
class ClassSeeder extends Seeder
{
    public function run(): void
    {
        // ទទួលបញ្ជីគ្រូ
        $teachers = Teacher::all();

        // ថ្នាក់ ៦ ថ្នាក់
        $classes = [
            ['class_name' => 'ថ្នាក់ទី ១០ A', 'room_number' => '101'],
            ['class_name' => 'ថ្នាក់ទី ១០ B', 'room_number' => '102'],
            ['class_name' => 'ថ្នាក់ទី ១១ A', 'room_number' => '201'],
            ['class_name' => 'ថ្នាក់ទី ១១ B', 'room_number' => '202'],
            ['class_name' => 'ថ្នាក់ទី ១២ A', 'room_number' => '301'],
            ['class_name' => 'ថ្នាក់ទី ១២ B', 'room_number' => '302'],
        ];

        foreach ($classes as $i => $class) {
            // ចាត់គ្រូ ១ ម្នាក់ ប្រសិនមាន
            $teacher = $teachers->get($i % max($teachers->count(), 1));
            SchoolClass::create([
                'class_name'  => $class['class_name'],
                'room_number' => $class['room_number'],
                'teacher_id'  => $teacher?->id,
            ]);
        }

        $this->command->info('✅ 6 classes seeded.');
    }
}
