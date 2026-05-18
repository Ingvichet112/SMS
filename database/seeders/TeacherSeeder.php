<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;

// Seeder សម្រាប់បង្កើតទិន្នន័យគ្រូ
class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        // បង្កើតគ្រូ ១០ នាក់ ដោយប្រើ Factory
        Teacher::factory()->count(10)->create();
        $this->command->info('✅ 10 teachers seeded.');
    }
}
