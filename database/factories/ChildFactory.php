<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Child>
 */
class ChildFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $genders = ['laki-laki', 'perempuan'];
        $educationLevels = ['tk', 'sd', 'smp', 'sma', 'kuliah'];
        $statuses = ['aktif', 'alumni', 'pindah'];
        
        $gender = fake()->randomElement($genders);
        $birthDate = fake()->dateTimeBetween('-18 years', '-3 years');
        $entryDate = fake()->dateTimeBetween($birthDate, 'now');
        
        return [
            'name' => fake()->name($gender === 'laki-laki' ? 'male' : 'female'),
            'nickname' => fake()->optional(0.7)->firstName(),
            'birth_date' => $birthDate,
            'gender' => $gender,
            'photo_url' => null,
            'background_story' => fake()->optional(0.8)->paragraph(),
            'education_level' => fake()->randomElement($educationLevels),
            'school_name' => fake()->optional(0.9)->company() . ' ' . fake()->randomElement(['Elementary', 'Middle School', 'High School']),
            'health_condition' => fake()->optional(0.3)->sentence(),
            'special_needs' => fake()->optional(0.1)->sentence(),
            'status' => fake()->randomElement(['aktif', 'aktif', 'aktif', 'alumni', 'pindah']), // More likely to be active
            'entry_date' => $entryDate,
            'exit_date' => fake()->optional(0.1)->dateTimeBetween($entryDate, 'now'),
            'notes' => fake()->optional(0.5)->paragraph(),
        ];
    }

    /**
     * Indicate that the child is active.
     */
    public function active(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'aktif',
            'exit_date' => null,
        ]);
    }

    /**
     * Indicate that the child is an alumni.
     */
    public function alumni(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'alumni',
            'exit_date' => fake()->dateTimeBetween($attributes['entry_date'], 'now'),
        ]);
    }
}