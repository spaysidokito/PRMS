<?php

namespace App\Http\Controllers;

use App\Models\StudentDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentDocumentController extends Controller
{
    public function index()
    {
        return view('student-documents.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'document_type' => 'required|string|in:receipt,permit,id,certificate,memo,report,contract,invoice,other',
            'description' => 'nullable|string|max:1000',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10240', // 10MB max
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('student-documents/' . Auth::id(), $fileName, 'public');

        StudentDocument::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'document_type' => $request->document_type,
            'description' => $request->description,
            'file_path' => $filePath,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
        ]);

        return redirect()->route('my-documents.index')->with('message', 'Document uploaded successfully.');
    }

    public function download($id)
    {
        $document = StudentDocument::where('user_id', Auth::id())->findOrFail($id);

        return Storage::disk('public')->download($document->file_path, $document->file_name);
    }

    public function destroy($id)
    {
        $document = StudentDocument::where('user_id', Auth::id())->findOrFail($id);

        // Delete file from storage
        Storage::disk('public')->delete($document->file_path);

        // Delete database record
        $document->delete();

        return redirect()->route('my-documents.index')->with('message', 'Document deleted successfully.');
    }
}
