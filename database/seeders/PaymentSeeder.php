<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function up(): void
    {
        // Handled by run()
    }

    public function run(): void
    {
        $students = Student::all();

        if ($students->isEmpty()) {
            $this->command->warn('⚠️ No students found. Run StudentSeeder first.');
            return;
        }

        $paymentMethods = ['ABA', 'Cash', 'Wing'];
        $count = 0;

        foreach ($students as $index => $student) {
            // Seed payments for roughly 60% of students
            if ($index % 5 < 3) {
                Payment::create([
                    'student_id'     => $student->id,
                    'amount'         => 150.00,
                    'payment_date'   => Carbon::now()->subDays(rand(1, 15))->toDateString(),
                    'status'         => 'paid',
                    'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                    'semester'       => 'Semester 1',
                    'academic_year'  => '2023-2024',
                    'remarks'        => 'Paid full tuition fee for Semester 1.',
                ]);
                $count++;
            }
        }

        $this->command->info("✅ {$count} student payments seeded successfully.");
    }
}
