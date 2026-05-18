<?php

namespace Database\Factories;

use App\Models\SchoolClass;
use Illuminate\Database\Eloquent\Factories\Factory;

// Factory សម្រាប់បង្កើតទិន្នន័យសិស្សក្លែងក្លាយ
class StudentFactory extends Factory
{
    public function definition(): array
    {
        static $counter = 1;

        // ឈ្មោះខ្មែរក្លែងក្លាយ
        $firstNames = ['Sokha', 'Dara', 'Maly', 'Ratana', 'Piseth', 'Chanthy',
                       'Bopha', 'Vireak', 'Sreymom', 'Kosal', 'Menghour', 'Sothea',
                       'Phally', 'Ratha', 'Chenda', 'Bunna', 'Lina', 'Vibol'];
        $lastNames  = ['Kim', 'Sok', 'Chan', 'Pich', 'Heng', 'Men', 'Sar',
                       'Keo', 'Chhun', 'Mao', 'Nget', 'Tep', 'Ros', 'Ly'];

        return [
            'student_id'    => 'STU-' . str_pad($counter++, 4, '0', STR_PAD_LEFT),
            'first_name'    => $this->faker->randomElement($firstNames),
            'last_name'     => $this->faker->randomElement($lastNames),
            'gender'        => $this->faker->randomElement(['Male', 'Female']),
            'date_of_birth' => $this->faker->dateTimeBetween('-22 years', '-15 years')->format('Y-m-d'),
            'email'         => $this->faker->unique()->safeEmail(),
            'phone'         => '0' . $this->faker->numerify('#########'),
            'address'       => $this->faker->city() . ', Cambodia',
            'class_id'      => null, // ត្រូវកំណត់ក្នុង Seeder
            'photo'         => null,
        ];
    }
}
