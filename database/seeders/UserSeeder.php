<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// Seeder សម្រាប់បង្កើត Admin Account
class UserSeeder extends Seeder
{
    public function run(): void
    {
        // បង្កើត Admin User
        User::updateOrCreate(
            ['email' => 'admin@sms.com'],
            [
                'name'     => 'Admin',
                'email'    => 'admin@sms.com',
                // Hash ពាក្យសម្ងាត់
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        $this->command->info('✅ Admin created: admin@sms.com / password');
    }
}
