<?php

namespace App\Http\Controllers;

use App\Models\StudentProfile;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StudentProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Only Faculty/Staff and Admins can access
        if (!Auth::user()->canEdit()) {
            abort(403, 'Unauthorized. Only Faculty/Staff and Administrators can access Student Management.');
        }

        $studentProfiles = StudentProfile::latest()->paginate(10);
        return view('student-profiles.index', compact('studentProfiles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Only Faculty/Staff and Admins can access
        if (!Auth::user()->canEdit()) {
            abort(403, 'Unauthorized. Only Faculty/Staff and Administrators can access Student Management.');
        }

        return view('student-profiles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Only Faculty/Staff and Admins can access
        if (!Auth::user()->canEdit()) {
            abort(403, 'Unauthorized. Only Faculty/Staff and Administrators can access Student Management.');
        }

        $validatedData = $request->validate([
            'student_id' => 'required|string|max:255|unique:student_profiles',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|string|in:male,female,other',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:student_profiles|unique:users',
            'course' => 'required|string|max:255',
            'year_level' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'status' => 'required|string|in:active,inactive,graduated,dropped',
            'department_cluster' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($validatedData) {
            // Create user account
            $fullName = $validatedData['first_name'];
            if (!empty($validatedData['middle_name'])) {
                $fullName .= ' ' . substr($validatedData['middle_name'], 0, 1) . '.';
            }
            $fullName .= ' ' . $validatedData['last_name'];

            // Generate default password from student_id
            $defaultPassword = 'Student@' . $validatedData['student_id'];

            $user = User::create([
                'name' => $fullName,
                'email' => $validatedData['email'],
                'password' => Hash::make($defaultPassword),
                'email_verified_at' => now(),
            ]);

            // Assign student role
            $studentRole = Role::where('slug', 'student')->first();
            if ($studentRole) {
                $user->roles()->attach($studentRole);
            }

            // Create student profile linked to user
            $validatedData['user_id'] = $user->id;
            StudentProfile::create($validatedData);
        });

        return redirect()->route('student-profiles.index')
            ->with('message', 'Student profile and user account created successfully. Default password: Student@[StudentID]');
    }


    public function show(StudentProfile $studentProfile)
    {
        // Only Faculty/Staff and Admins can access
        if (!Auth::user()->canEdit()) {
            abort(403, 'Unauthorized. Only Faculty/Staff and Administrators can access Student Management.');
        }

        return view('student-profiles.show', compact('studentProfile'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudentProfile $studentProfile)
    {
        // Only Faculty/Staff and Admins can access
        if (!Auth::user()->canEdit()) {
            abort(403, 'Unauthorized. Only Faculty/Staff and Administrators can access Student Management.');
        }

        return view('student-profiles.edit', compact('studentProfile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StudentProfile $studentProfile)
    {
        // Only Faculty/Staff and Admins can access
        if (!Auth::user()->canEdit()) {
            abort(403, 'Unauthorized. Only Faculty/Staff and Administrators can access Student Management.');
        }

        $validatedData = $request->validate([
            'student_id' => 'required|string|max:255|unique:student_profiles,student_id,' . $studentProfile->id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|string|in:male,female,other',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:student_profiles,email,' . $studentProfile->id . '|unique:users,email,' . ($studentProfile->user_id ?? 'NULL'),
            'course' => 'required|string|max:255',
            'year_level' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'status' => 'required|string|in:active,inactive,graduated,dropped',
            'department_cluster' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($validatedData, $studentProfile) {
            // Update student profile
            $studentProfile->update($validatedData);

            // Update associated user if exists
            if ($studentProfile->user) {
                $fullName = $validatedData['first_name'];
                if (!empty($validatedData['middle_name'])) {
                    $fullName .= ' ' . substr($validatedData['middle_name'], 0, 1) . '.';
                }
                $fullName .= ' ' . $validatedData['last_name'];

                $studentProfile->user->update([
                    'name' => $fullName,
                    'email' => $validatedData['email'],
                ]);
            }
        });

        return redirect()->route('student-profiles.index')->with('message', 'Student profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentProfile $studentProfile)
    {
        if (!Auth::user()->canDelete()) {
            return redirect()->route('student-profiles.show', $studentProfile)
                ->with('error', 'You do not have permission to delete student profiles.');
        }

        DB::transaction(function () use ($studentProfile) {
            // Delete associated user account (will cascade delete the profile)
            if ($studentProfile->user) {
                $studentProfile->user->delete();
            } else {
                // If no user, just delete the profile
                $studentProfile->delete();
            }
        });

        return redirect()->route('student-profiles.index')
            ->with('message', 'Student profile and user account deleted successfully.');
    }
}
