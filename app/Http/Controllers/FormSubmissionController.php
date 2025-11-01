<?php

namespace App\Http\Controllers;

use App\Models\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FormSubmissionController extends Controller
{
    // Student methods
    public function mySubmissions()
    {
        $user = Auth::user();

        if (!$user->isStudent()) {
            abort(403, 'This page is only accessible to students.');
        }

        $submissions = FormSubmission::where('user_id', $user->id)
            ->with(['reviewer'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('form-submissions.my-submissions', compact('submissions'));
    }

    public function create()
    {
        $user = Auth::user();

        if (!$user->isStudent()) {
            abort(403, 'This page is only accessible to students.');
        }

        return view('form-submissions.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->isStudent()) {
            abort(403, 'This page is only accessible to students.');
        }

        $validated = $request->validate([
            'form_type' => 'required|in:soa,gtc,pod',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            'notes' => 'nullable|string|max:1000',
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . $user->id . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('form-submissions', $filename, 'public');

        FormSubmission::create([
            'user_id' => $user->id,
            'student_profile_id' => $user->studentProfile?->id,
            'form_type' => $validated['form_type'],
            'file_path' => $path,
            'original_filename' => $file->getClientOriginalName(),
            'notes' => $validated['notes'],
            'status' => 'pending',
        ]);

        return redirect()->route('form-submissions.my-submissions')
            ->with('message', 'Form submitted successfully! It will be reviewed by the administrator.');
    }

    public function show(FormSubmission $formSubmission)
    {
        $user = Auth::user();

        // Students can only view their own submissions
        if ($user->isStudent() && $formSubmission->user_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        // Faculty/Staff and Admin can view all submissions
        if (!$user->isStudent() && !$user->canEdit()) {
            abort(403, 'Unauthorized access.');
        }

        return view('form-submissions.show', compact('formSubmission'));
    }

    public function destroy(FormSubmission $formSubmission)
    {
        $user = Auth::user();

        // Students can only delete their own pending submissions
        if ($user->isStudent()) {
            if ($formSubmission->user_id !== $user->id) {
                abort(403, 'Unauthorized access.');
            }
            if ($formSubmission->status !== 'pending') {
                return back()->with('error', 'You can only delete pending submissions.');
            }
        } elseif (!$user->canDelete()) {
            abort(403, 'Unauthorized access.');
        }

        // Delete the file
        if (Storage::disk('public')->exists($formSubmission->file_path)) {
            Storage::disk('public')->delete($formSubmission->file_path);
        }

        $formSubmission->delete();

        return back()->with('message', 'Submission deleted successfully.');
    }

    // Admin/Staff methods
    public function index()
    {
        $user = Auth::user();

        if (!$user->canEdit()) {
            abort(403, 'Unauthorized. Only Faculty/Staff and Administrators can access this page.');
        }

        $submissions = FormSubmission::with(['user', 'studentProfile', 'reviewer'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $stats = [
            'pending' => FormSubmission::where('status', 'pending')->count(),
            'approved' => FormSubmission::where('status', 'approved')->count(),
            'rejected' => FormSubmission::where('status', 'rejected')->count(),
            'total' => FormSubmission::count(),
        ];

        return view('form-submissions.index', compact('submissions', 'stats'));
    }

    public function updateStatus(Request $request, FormSubmission $formSubmission)
    {
        $user = Auth::user();

        if (!$user->canEdit()) {
            abort(403, 'Unauthorized.');
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $formSubmission->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'],
            'reviewed_by' => $user->id,
            'reviewed_at' => now(),
        ]);

        return back()->with('message', 'Submission status updated successfully.');
    }

    public function print(FormSubmission $formSubmission)
    {
        $user = Auth::user();

        if (!$user->canEdit()) {
            abort(403, 'Unauthorized.');
        }

        // Get the file path
        $filePath = storage_path('app/public/' . $formSubmission->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        // Get file extension
        $extension = strtolower(pathinfo($formSubmission->original_filename, PATHINFO_EXTENSION));

        // For PDF files, return the file directly (browsers can print PDFs)
        if ($extension === 'pdf') {
            return response()->file($filePath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $formSubmission->original_filename . '"'
            ]);
        }

        // For image files, show in a printable view
        if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
            return view('form-submissions.print-image', compact('formSubmission'));
        }

        // For Word documents, download them (can't print directly in browser)
        if (in_array($extension, ['doc', 'docx'])) {
            return response()->download($filePath, $formSubmission->original_filename);
        }

        // Fallback: download the file
        return response()->download($filePath, $formSubmission->original_filename);
    }
}
