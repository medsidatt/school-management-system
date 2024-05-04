<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Subjects;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => Student::all()->random()->id,
            'subject_id' => Subjects::all()->random()->id,
            'note' => $this->faker->randomFloat(2, 1, 20),
            'quarter' => 3
        ];
    }
}
