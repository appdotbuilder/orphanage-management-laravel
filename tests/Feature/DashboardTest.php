<?php

use App\Models\Role;
use App\Models\User;

test('guests are redirected to the login page', function () {
    $this->get('/dashboard')->assertRedirect('/login');
});

test('authenticated users can visit the dashboard', function () {
    // Create roles and permissions first
    $this->artisan('db:seed', ['--class' => 'RolePermissionSeeder']);
    
    $user = User::factory()->create();
    
    // Assign donatur role (has view_dashboard permission)
    $donaturRole = Role::where('name', 'donatur')->first();
    $user->roles()->attach($donaturRole);

    $this->actingAs($user);

    $this->get('/dashboard')->assertOk();
});
