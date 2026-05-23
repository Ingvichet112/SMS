<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;

// Seeder សម្រាប់បង្កើតទិន្នន័យគ្រូ
class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        // ស្វែងរក Teacher User
        $teacherUser = \App\Models\User::where('email', 'teacher@sms.com')->first();

        if ($teacherUser) {
            // បង្កើតគ្រូជាក់លាក់សម្រាប់ User នេះ
            Teacher::create([
                'user_id'    => $teacherUser->id,
                'teacher_id' => 'TCH-000',
                'name'       => 'Dr. John Doe',
                'gender'     => 'Male',
                'email'      => 'teacher@sms.com',
                'phone'      => '012345678',
                'subject'    => 'Computer Science',
                'address'    => 'Phnom Penh, Cambodia',
            ]);
        }

        // បង្កើតគ្រូ ៩ នាក់ទៀត ដោយប្រើ Factory
        Teacher::factory()->count(9)->create();
        $this->command->info('✅ 10 teachers seeded (1 linked to teacher@sms.com).');
    }
}
