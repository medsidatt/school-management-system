<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TeacherFactory extends Factory
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
            'nni' => $this->faker->unique()->randomNumber(5) . $this->faker->unique()->randomNumber(5),
            'sex' => 'M',
            'date_of_birth' => '1987-12-12',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
