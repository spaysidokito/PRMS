<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Administrator',
                'slug' => 'admin',
            ],
            [
                'name' => 'Faculty/Staff',
                'slug' => 'faculty-staff',
            ],
            [
                'name' => 'Student',
                'slug' => 'student',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
