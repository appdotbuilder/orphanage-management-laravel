<?php

namespace Database\Seeders;

use App\Models\Child;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Database\Seeder;

class SampleDonationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get donatur user
        $donatur = User::whereHas('roles', function ($query) {
            $query->where('name', 'donatur');
        })->first();

        if (!$donatur) {
            return; // No donatur user found
        }

        // Get some children for targeted donations
        $children = Child::take(3)->get();

        // Create some sample donations
        $donations = [
            [
                'user_id' => $donatur->id,
                'child_id' => $children->first()?->id,
                'amount' => 500000,
                'type' => 'uang',
                'description' => 'Donasi untuk biaya pendidikan',
                'status' => 'diterima',
                'donation_date' => now()->subDays(10),
                'received_date' => now()->subDays(8),
            ],
            [
                'user_id' => $donatur->id,
                'child_id' => null, // General donation
                'amount' => 200000,
                'type' => 'makanan',
                'description' => 'Paket sembako untuk panti',
                'status' => 'digunakan',
                'donation_date' => now()->subDays(20),
                'received_date' => now()->subDays(18),
            ],
            [
                'user_id' => $donatur->id,
                'child_id' => $children->skip(1)->first()?->id,
                'amount' => 150000,
                'type' => 'pakaian',
                'description' => 'Seragam sekolah dan pakaian sehari-hari',
                'status' => 'selesai',
                'donation_date' => now()->subDays(30),
                'received_date' => now()->subDays(28),
            ],
            [
                'user_id' => $donatur->id,
                'child_id' => null,
                'amount' => 1000000,
                'type' => 'uang',
                'description' => 'Donasi bulanan untuk operasional panti',
                'status' => 'diterima',
                'donation_date' => now()->subDays(5),
                'received_date' => now()->subDays(3),
            ],
        ];

        foreach ($donations as $donation) {
            Donation::create($donation);
        }
    }
}