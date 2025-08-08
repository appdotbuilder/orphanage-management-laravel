<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            // Children permissions
            ['name' => 'view_children', 'display_name' => 'View Children', 'description' => 'Can view children data'],
            ['name' => 'create_children', 'display_name' => 'Create Children', 'description' => 'Can add new children'],
            ['name' => 'update_children', 'display_name' => 'Update Children', 'description' => 'Can update children data'],
            ['name' => 'delete_children', 'display_name' => 'Delete Children', 'description' => 'Can delete children'],
            
            // Donations permissions
            ['name' => 'view_donations', 'display_name' => 'View Donations', 'description' => 'Can view donations'],
            ['name' => 'create_donations', 'display_name' => 'Create Donations', 'description' => 'Can make donations'],
            ['name' => 'manage_donations', 'display_name' => 'Manage Donations', 'description' => 'Can manage all donations'],
            
            // User management permissions
            ['name' => 'view_users', 'display_name' => 'View Users', 'description' => 'Can view users'],
            ['name' => 'manage_users', 'display_name' => 'Manage Users', 'description' => 'Can manage users'],
            
            // Dashboard permissions
            ['name' => 'view_dashboard', 'display_name' => 'View Dashboard', 'description' => 'Can access dashboard'],
            ['name' => 'view_admin_dashboard', 'display_name' => 'View Admin Dashboard', 'description' => 'Can access admin dashboard with statistics'],
            
            // Activities permissions
            ['name' => 'view_activities', 'display_name' => 'View Activities', 'description' => 'Can view activities'],
            ['name' => 'manage_activities', 'display_name' => 'Manage Activities', 'description' => 'Can manage activities'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission['name']], $permission);
        }

        // Create roles
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'Full access to all features',
                'permissions' => [
                    'view_children', 'create_children', 'update_children', 'delete_children',
                    'view_donations', 'create_donations', 'manage_donations',
                    'view_users', 'manage_users',
                    'view_dashboard', 'view_admin_dashboard',
                    'view_activities', 'manage_activities'
                ]
            ],
            [
                'name' => 'pengurus',
                'display_name' => 'Pengurus',
                'description' => 'Can manage children, activities, and donations',
                'permissions' => [
                    'view_children', 'create_children', 'update_children',
                    'view_donations', 'manage_donations',
                    'view_dashboard',
                    'view_activities', 'manage_activities'
                ]
            ],
            [
                'name' => 'donatur',
                'display_name' => 'Donatur',
                'description' => 'Can view basic children data and make donations',
                'permissions' => [
                    'view_children',
                    'view_donations', 'create_donations',
                    'view_dashboard'
                ]
            ],
            [
                'name' => 'anak',
                'display_name' => 'Anak Asuh',
                'description' => 'Can view own profile and donation history',
                'permissions' => [
                    'view_donations',
                    'view_dashboard'
                ]
            ],
        ];

        foreach ($roles as $roleData) {
            $role = Role::firstOrCreate(
                ['name' => $roleData['name']],
                [
                    'display_name' => $roleData['display_name'],
                    'description' => $roleData['description']
                ]
            );

            // Assign permissions to role
            $permissions = Permission::whereIn('name', $roleData['permissions'])->get();
            $role->permissions()->syncWithoutDetaching($permissions);
        }
    }
}