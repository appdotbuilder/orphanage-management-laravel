<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@pantiasuhan.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
            ]
        );

        // Assign admin role
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole && !$admin->hasRole('admin')) {
            $admin->roles()->attach($adminRole);
        }

        // Create sample pengurus
        $pengurus = User::firstOrCreate(
            ['email' => 'pengurus@pantiasuhan.com'],
            [
                'name' => 'Pengurus Panti',
                'password' => Hash::make('password'),
            ]
        );

        $pengurusRole = Role::where('name', 'pengurus')->first();
        if ($pengurusRole && !$pengurus->hasRole('pengurus')) {
            $pengurus->roles()->attach($pengurusRole);
        }

        // Create sample donatur
        $donatur = User::firstOrCreate(
            ['email' => 'donatur@pantiasuhan.com'],
            [
                'name' => 'Donatur Sample',
                'password' => Hash::make('password'),
            ]
        );

        $donaturRole = Role::where('name', 'donatur')->first();
        if ($donaturRole && !$donatur->hasRole('donatur')) {
            $donatur->roles()->attach($donaturRole);
        }
    }
}