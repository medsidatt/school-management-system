<?php

namespace Database\Factories;

use App\Models\StudentParent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->name(),
            'rim' => $this->faker->randomNumber(7),
            'class' => 4,
            'parent' => StudentParent::all()->random()->id,
            'sex' => 'M',
            'date_of_birth' => '2010-12-12',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

}
