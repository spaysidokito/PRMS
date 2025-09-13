<?php

namespace App\Http\Controllers;

use App\Models\StudentProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $studentProfiles = StudentProfile::latest()->paginate(10);
        return view('student-profiles.index', compact('studentProfiles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('student-profiles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'student_id' => 'required|string|max:255|unique:student_profiles',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|string|in:male,female,other',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:student_profiles',
            'course' => 'required|string|max:255',
            'year_level' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'status' => 'required|string|in:active,inactive,graduated,dropped',
            'department_cluster' => 'required|string|max:255',
        ]);

        StudentProfile::create($validatedData);

        return redirect()->route('student-profiles.index')->with('message', 'Student profile created successfully.');
    }


    public function show(StudentProfile $studentProfile)
    {
        return view('student-profiles.show', compact('studentProfile'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudentProfile $studentProfile)
    {
        return view('student-profiles.edit', compact('studentProfile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StudentProfile $studentProfile)
    {
        $validatedData = $request->validate([
            'student_id' => 'required|string|max:255|unique:student_profiles,student_id,' . $studentProfile->id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|string|in:male,female,other',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:student_profiles,email,' . $studentProfile->id,
            'course' => 'required|string|max:255',
            'year_level' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'status' => 'required|string|in:active,inactive,graduated,dropped',
            'department_cluster' => 'required|string|max:255',
        ]);

        $studentProfile->update($validatedData);

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

        $studentProfile->delete();
        return redirect()->route('student-profiles.index')
            ->with('message', 'Student profile deleted successfully.');
    }
}
