<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin role if it doesn't exist
        $adminRole = Role::where('slug', 'admin')->first();

        if (!$adminRole) {
            $adminRole = Role::create([
                'name' => 'Administrator',
                'slug' => 'admin',
            ]);
        }

        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        // Assign admin role
        $admin->roles()->attach($adminRole->id);
    }
}
