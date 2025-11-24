<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\StudentProfile;
use Illuminate\Console\Command;
use Illuminateades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ImportStudentsFromCsv extends Command
{
    protected $signature = 'students:import {file=TES (1).csv}';
    protected $description = 'Import students from CSV file';

    public function handle()
    {
        $filePath = base_path($this->argument('file'));

        if (!file_exists($filePath)) {
            $this->error("File not found: {$filePath}");
            return 1;
        }

        $this->info("Reading CSV file: {$filePath}");

        $file = fopen($filePath, 'r');
        $headers = fgetcsv($file); // Read header row

        $imported = 0;
        $skipped = 0;
        $errors = [];

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

                    // Check if student already exists
                    if (StudentProfile::where('student_id', $studentId)->exists()) {
                        $skipped++;
                        continue;
                    }

                    // Determine department cluster based on program
                    $departmentCluster = $this->getDepartmentCluster($program);

                    // Create user account
                    $user = User::create([
                        'name' => "{$givenName} {$lastName}",
                        'email' => $email,
                        'password' => Hash::make('password123'), // Default password
                        'email_verified_at' => now(),
                    ]);

                    // Assign student role
                    $user->roles()->attach(3); // Assuming role_id 3 is for students

                    // Create student profile
                    StudentProfile::create([
                        'user_id' => $user->id,
                        'student_id' => $studentId,
                        'first_name' => $givenName,
                        'last_name' => $lastName,
                        'middle_name' => $middleName,
                        'birth_date' => $birthDate,
                        'gender' => $sex === 'Male' ? 'male' : 'female',
                        'address' => $address,
                        'contact_number' => $contactNumber,
                        'email' => $email,
                        'course' => $program,
                        'year_level' => $yearLevel,
                        'section' => '', // Not provided in CSV
                        'status' => 'active',
                        'department_cluster' => $departmentCluster,
                    ]);

                    $imported++;

                    if ($imported % 50 == 0) {
                        $this->info("Imported {$imported} students...");
                    }

                } catch (\Exception $e) {
                    $errors[] = "Row {$imported}: " . $e->getMessage();
                    $skipped++;
                }
            }

            DB::commit();
            fclose($file);

            $this->info("\n=== Import Complete ===");
            $this->info("Successfully imported: {$imported} students");
            $this->info("Skipped: {$skipped} records");

            if (!empty($errors)) {
                $this->warn("\nErrors encountered:");
                foreach (array_slice($errors, 0, 10) as $error) {
                    $this->warn($error);
                }
                if (count($errors) > 10) {
                    $this->warn("... and " . (count($errors) - 10) . " more errors");
                }
            }

            return 0;

        } catch (\Exception $e) {
            DB::rollBack();
            fclose($file);
            $this->error("Import failed: " . $e->getMessage());
            return 1;
        }
    }

    private function parseBirthDate($dateString)
    {
        if (empty($dateString)) {
            return '2000-01-01'; // Default date
        }

        try {
            // Handle various date formats
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

        // Street & Barangay (index 16)
        if (!empty($row[16])) {
            $parts[] = trim($row[16]);
        }

        // ZIP Code (index 17)
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

        // Remove any non-digit characters except +
        $cleaned = preg_replace('/[^0-9+]/', '', $number);

        return !empty($cleaned) ? $cleaned : 'N/A';
    }

    private function getDepartmentCluster($program)
    {
        $program = strtoupper($program);

        if (in_array($program, ['BSM', 'BSN', 'BSPT', 'BSMEDTECH', 'DMD'])) {
            return 'SAHS';
        }

        if (in_array($program, ['BSA', 'BSBAFM', 'BSBAMM', 'BSCECEM', 'BSIE', 'BSIT'])) {
            return 'SBEAT';
        }

        if (in_array($program, ['BSCRIM'])) {
            return 'COC';
        }

        if (in_array($program, ['BSHM', 'BSTM'])) {
            return 'SMITH';
        }

        if (in_array($program, ['ABPSYC', 'BEEDGE', 'BSEDENG'])) {
            return 'SEAS';
        }

        return 'GENERAL';
    }
}
