<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

// Factory សម្រាប់បង្កើតទិន្នន័យគ្រូក្លែងក្លាយ
class TeacherFactory extends Factory
{
    public function definition(): array
    {
        // មុខវិជ្ជាដែលអាចក្លែងក្លាយ
        $subjects = ['Mathematics', 'Physics', 'Chemistry', 'Biology', 'History',
                     'Geography', 'English', 'Khmer Literature', 'Computer Science', 'Economics'];

        static $counter = 1;

        return [
            'teacher_id' => 'TCH-' . str_pad($counter++, 3, '0', STR_PAD_LEFT),
            'name'       => $this->faker->name(),
            'gender'     => $this->faker->randomElement(['Male', 'Female']),
            'email'      => $this->faker->unique()->safeEmail(),
            'phone'      => '0' . $this->faker->numerify('#########'),
            'subject'    => $this->faker->randomElement($subjects),
            'address'    => $this->faker->address(),
        ];
    }
}
