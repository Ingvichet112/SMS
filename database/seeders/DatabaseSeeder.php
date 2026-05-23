<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// DatabaseSeeder ចម្បង — ដំណើរការ Seeder ទាំងអស់
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🌱 Seeding Student Management System...');

        // ១. បង្កើត Admin User
        $this->call(UserSeeder::class);

        // ២. បង្កើតគ្រូ
        $this->call(TeacherSeeder::class);

        // ៣. បង្កើតមុខវិជ្ជា
        $this->call(CourseSeeder::class);

        // ៤. បង្កើតថ្នាក់ (ភ្ជាប់ទៅគ្រូ)
        $this->call(ClassSeeder::class);

        // ៥. បង្កើតសិស្ស (ចែកចូលថ្នាក់)
        $this->call(StudentSeeder::class);

        // ៦. បង្កើតការបង់ប្រាក់
        $this->call(PaymentSeeder::class);

        $this->command->info('✅ All data seeded successfully!');
    }
}
