<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolesAndUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles if they don't exist
        $adminRole = Role::firstOrCreate(
            ['slug' => 'admin'],
            ['name' => 'Administrator']
        );

        $facultyRole = Role::firstOrCreate(
            ['slug' => 'faculty-staff'],
            ['name' => 'Faculty/Staff']
        );

        $studentRole = Role::firstOrCreate(
            ['slug' => 'student'],
            ['name' => 'Student']
        );

        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@primosa.edu'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('Admin@123'),
                'email_verified_at' => now(),
            ]
        );
        if (!$admin->roles()->where('slug', 'admin')->exists()) {
            $admin->roles()->attach($adminRole);
        }

        // Create Faculty/Staff Users
        $faculty1 = User::firstOrCreate(
            ['email' => 'faculty@primosa.edu'],
            [
                'name' => 'Dr. Maria Santos',
                'password' => Hash::make('Faculty@123'),
                'email_verified_at' => now(),
            ]
        );
        if (!$faculty1->roles()->where('slug', 'faculty-staff')->exists()) {
            $faculty1->roles()->attach($facultyRole);
        }

        $faculty2 = User::firstOrCreate(
            ['email' => 'staff@primosa.edu'],
            [
                'name' => 'John Dela Cruz',
                'password' => Hash::make('Staff@123'),
                'email_verified_at' => now(),
            ]
        );
        if (!$faculty2->roles()->where('slug', 'faculty-staff')->exists()) {
            $faculty2->roles()->attach($facultyRole);
        }

        // Create Student Users
        $students = [
            ['name' => 'Juan Tamad', 'email' => 'juan.tamad@student.primosa.edu'],
            ['name' => 'Maria Clara', 'email' => 'maria.clara@student.primosa.edu'],
            ['name' => 'Jose Rizal', 'email' => 'jose.rizal@student.primosa.edu'],
            ['name' => 'Andres Bonifacio', 'email' => 'andres.bonifacio@student.primosa.edu'],
            ['name' => 'Gabriela Silang', 'email' => 'gabriela.silang@student.primosa.edu'],
        ];

        foreach ($students as $studentData) {
            $student = User::firstOrCreate(
                ['email' => $studentData['email']],
                [
                    'name' => $studentData['name'],
                    'password' => Hash::make('Student@123'),
                    'email_verified_at' => now(),
                ]
            );
            if (!$student->roles()->where('slug', 'student')->exists()) {
                $student->roles()->attach($studentRole);
            }
        }

        $this->command->info('Roles and Users seeded successfully!');
        $this->command->info('Admin: admin@primosa.edu / Admin@123');
        $this->command->info('Faculty: faculty@primosa.edu / Faculty@123');
        $this->command->info('Staff: staff@primosa.edu / Staff@123');
        $this->command->info('Students: *.student.primosa.edu / Student@123');
    }
}
