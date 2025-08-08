<?php

namespace Database\Factories;

use App\Models\Child;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donation>
 */
class DonationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['uang', 'barang', 'makanan', 'pakaian', 'pendidikan', 'kesehatan', 'lainnya'];
        $statuses = ['pending', 'diterima', 'digunakan', 'selesai'];
        
        $donationDate = fake()->dateTimeBetween('-2 years', 'now');
        $receivedDate = fake()->optional(0.8)->dateTimeBetween($donationDate, 'now');
        
        return [
            'user_id' => User::factory(),
            'child_id' => fake()->optional(0.3)->randomElement(Child::pluck('id')->toArray() ?: [null]),
            'amount' => fake()->randomFloat(2, 50000, 5000000), // Between 50k and 5M IDR
            'type' => fake()->randomElement($types),
            'description' => fake()->sentence(),
            'notes' => fake()->optional(0.4)->paragraph(),
            'status' => fake()->randomElement($statuses),
            'donation_date' => $donationDate,
            'received_date' => $receivedDate,
            'receipt_url' => fake()->optional(0.3)->url(),
            'metadata' => fake()->optional(0.2)->randomElement([
                ['bank' => 'BCA', 'account' => '1234567890'],
                ['method' => 'transfer', 'reference' => fake()->uuid()],
                ['courier' => 'JNE', 'tracking' => fake()->numerify('##########')],
            ]),
        ];
    }

    /**
     * Indicate that the donation is received.
     */
    public function received(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'status' => fake()->randomElement(['diterima', 'digunakan', 'selesai']),
            'received_date' => fake()->dateTimeBetween($attributes['donation_date'], 'now'),
        ]);
    }

    /**
     * Indicate that the donation is for a specific child.
     */
    public function forChild(Child $child): Factory
    {
        return $this->state(fn (array $attributes) => [
            'child_id' => $child->id,
        ]);
    }
}