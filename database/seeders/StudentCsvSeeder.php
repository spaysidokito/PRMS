<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\StudentProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentCsvSeeder extends Seeder
{
    public function run(): void
    {
        $filePath = base_path('TES (1).csv');

        if (!file_exists($filePath)) {
            echo "CSV file not found at: {$filePath}\n";
            return;
        }

        echo "Starting import from CSV...\n";

        $file = fopen($filePath, 'r');
        $headers = fgetcsv($file); // Skip header row

        $imported = 0;
        $skipped = 0;

        DB::beginTransaction();

        try {
            while (($row = fgetcsv($file)) !== false) {
                try {
                    // Skip if student ID is empty
                    if (empty($row[1])) {
                        $skipped++;
                        continue;
                    }

                    $studentId = trim($row[1]);

                    // Check if student already exists
                    if (StudentProfile::where('student_id', $studentId)->exists()) {
                        $skipped++;
                        continue;
                    }

                    $lastName = trim($row[2]);
                    $givenName = trim($row[3]);
                    $middleName = !empty($row[5]) ? trim($row[5]) : null;
                    $sex = trim($row[6]);
                    $birthDate = $this->parseBirthDate($row[7]);
                    $program = trim($row[8]);
                    $yearLevel = trim($row[9]);
                    $address = $this->buildAddress($row);
                    $contactNumber = $this->cleanContactNumber($row[19]);
                    $email = trim($row[20]);

                    // Skip if essential data is missing
                    if (empty($lastName) || empty($givenName) || empty($email)) {
                        $skipped++;
                        continue;
                    }

                    // Check if email already exists
                    if (User::where('email', $email)->exists()) {
                        $skipped++;
                        continue;
                    }

                    $departmentCluster = $this->getDepartmentCluster($program);

                    // Create user
                    $user = User::create([
                        'name' => "{$givenName} {$lastName}",
                        'email' => $email,
                        'password' => Hash::make('password123'),
                        'email_verified_at' => now(),
                    ]);

                    // Assign student role (role_id = 3)
                    DB::table('role_user')->insert([
                        'user_id' => $user->id,
                        'role_id' => 3,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // Create student profile
                    StudentProfile::create([
                        'user_id' => $user->id,
                        'student_id' => $studentId,
                        'first_name' => $givenName,
                        'last_name' => $lastName,
                        'middle_name' => $middleName,
                        'birth_date' => $birthDate,
                        'gender' => strtolower($sex) === 'male' ? 'male' : 'female',
                        'address' => $address,
                        'contact_number' => $contactNumber,
                        'email' => $email,
                        'course' => $program,
                        'year_level' => $yearLevel,
                        'section' => '',
                        'status' => 'active',
                        'department_cluster' => $departmentCluster,
                    ]);

                    $imported++;

                    if ($imported % 100 == 0) {
                        echo "Imported {$imported} students...\n";
                    }

                } catch (\Exception $e) {
                    echo "Error on row: " . $e->getMessage() . "\n";
                    $skipped++;
                }
            }

            DB::commit();
            fclose($file);

            echo "\n=== Import Complete ===\n";
            echo "Successfully imported: {$imported} students\n";
            echo "Skipped: {$skipped} records\n";

        } catch (\Exception $e) {
            DB::rollBack();
            fclose($file);
            echo "Import failed: " . $e->getMessage() . "\n";
        }
    }

    private function parseBirthDate($dateString)
    {
        if (empty($dateString) || $dateString === '0000-00-00') {
            return '2000-01-01';
        }

        try {
            $date = \DateTime::createFromFormat('n/j/Y', $dateString);
            if (!$date) {
                $date = \DateTime::createFromFormat('Y-m-d', $dateString);
            }
            if (!$date) {
                return '2000-01-01';
            }
            return $date->format('Y-m-d');
        } catch (\Exception $e) {
            return '2000-01-01';
        }
    }

    private function buildAddress($row)
    {
        $parts = [];

        if (!empty($row[16])) {
            $parts[] = trim($row[16]);
        }

        if (!empty($row[17]) && $row[17] != '0') {
            $parts[] = trim($row[17]);
        }

        return !empty($parts) ? implode(', ', $parts) : 'N/A';
    }

    private function cleanContactNumber($number)
    {
        if (empty($number)) {
            return 'N/A';
        }

        $cleaned = preg_replace('/[^0-9+]/', '', $number);
        return !empty($cleaned) ? $cleaned : 'N/A';
    }

    private function getDepartmentCluster($program)
    {
        $program = strtoupper(trim($program));

        $clusters = [
            'SAHS' => ['BSM', 'BSN', 'BSPT', 'BSMEDTECH', 'DMD'],
            'SBEAT' => ['BSA', 'BSBAFM', 'BSBAMM', 'BSCECEM', 'BSIE', 'BSIT'],
            'COC' => ['BSCRIM'],
            'SMITH' => ['BSHM', 'BSTM'],
            'SEAS' => ['ABPSYC', 'BEEDGE', 'BSEDENG'],
        ];

        foreach ($clusters as $cluster => $programs) {
            if (in_array($program, $programs)) {
                return $cluster;
            }
        }

        return 'GENERAL';
    }
}
