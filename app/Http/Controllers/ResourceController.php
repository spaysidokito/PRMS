<?php

namespace App\Http\Controllers;

use App\Models\FormAccessLog;
use App\Models\ResourceForm;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ResourceController extends Controller
{
    /**
     * Display SOA form
     */
    public function soa(): View
    {
        FormAccessLog::logAccess('soa', 'view');
        $forms = ResourceForm::byCategory('soa')->active()->ordered()->get();
        $formsBySubcategory = $forms->groupBy('subcategory');
        return view('resources.soa', compact('formsBySubcategory'));
    }

    /**
     * Display GTC form
     */
    public function gtc(): View
    {
        FormAccessLog::logAccess('gtc', 'view');
        $forms = ResourceForm::byCategory('gtc')->active()->ordered()->get();
        $formsBySubcategory = $forms->groupBy('subcategory');
        return view('resources.gtc', compact('formsBySubcategory'));
    }

    /**
     * Display POD form
     */
    public function pod(): View
    {
        FormAccessLog::logAccess('pod', 'view');
        $forms = ResourceForm::byCategory('pod')->active()->ordered()->get();
        return view('resources.pod', compact('forms'));
    }

    /**
     * Store SOA form data
     */
    public function soaStore(Request $request)
    {
        // TODO: Add validation and storage logic when forms are provided
        return redirect()->back()->with('success', 'SOA form data saved successfully!');
    }

    /**
     * Store GTC form data
     */
    public function gtcStore(Request $request)
    {
        // TODO: Add validation and storage logic when forms are provided
        return redirect()->back()->with('success', 'GTC form data saved successfully!');
    }

    /**
     * Store POD form data
     */
    public function podStore(Request $request)
    {
        // TODO: Add validation and storage logic when forms are provided
        return redirect()->back()->with('success', 'POD form data saved successfully!');
    }

    /**
     * Download SOA form as PDF
     */
    public function soaDownload()
    {
        // TODO: Implement PDF generation when forms are provided
        return response()->json(['message' => 'Download functionality will be implemented when forms are provided']);
    }

    /**
     * Download GTC form as PDF
     */
    public function gtcDownload()
    {
        // TODO: Implement PDF generation when forms are provided
        return response()->json(['message' => 'Download functionality will be implemented when forms are provided']);
    }

    /**
     * Download POD template
     */
    public function podDownload(Request $request)
    {
        $templateName = $request->get('template');
        $templatePath = public_path('forms/pod/' . $templateName . '.docx');

        if (File::exists($templatePath)) {
            FormAccessLog::logAccess('pod', 'download', $templateName, 'forms/pod/' . $templateName . '.docx');
            return response()->download($templatePath);
        }

        // Try PDF extension
        $templatePath = public_path('forms/pod/' . $templateName . '.pdf');
        if (File::exists($templatePath)) {
            FormAccessLog::logAccess('pod', 'download', $templateName, 'forms/pod/' . $templateName . '.pdf');
            return response()->download($templatePath);
        }

        return redirect()->back()->with('error', 'Template not found. Please place the file in public/forms/pod/ directory.');
    }

    /**
     * Print SOA form
     */
    public function soaPrint()
    {
        // TODO: Implement print view when forms are provided
        return view('resources.print.soa');
    }

    /**
     * Print GTC form
     */
    public function gtcPrint()
    {
        // TODO: Implement print view when forms are provided
        return view('resources.print.gtc');
    }

    /**
     * Print POD form
     */
    public function podPrint()
    {
        // TODO: Implement print view when forms are provided
        return view('resources.print.pod');
    }

    /**
     * Upload SOA forms
     */
    public function soaUpload(Request $request)
    {
        $request->validate([
            'forms.*' => 'required|file|mimes:doc,docx|max:10240', // 10MB max per file
        ]);

        $uploadedFiles = [];
        $uploadPath = 'forms/soa/uploads';

        if ($request->hasFile('forms')) {
            foreach ($request->file('forms') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs($uploadPath, $filename, 'public');
                $uploadedFiles[] = $filename;

                FormAccessLog::logAccess('soa', 'upload', $filename, $uploadPath . '/' . $filename);
            }
        }

        return redirect()->route('resources.soa')->with('success',
            count($uploadedFiles) . ' form(s) uploaded successfully!');
    }

    /**
     * Download specific SOA form
     */
    public function soaDownloadFile(Request $request)
    {
        $filename = $request->get('file');
        $filePath = 'forms/soa/uploads/' . $filename;

        if (Storage::disk('public')->exists($filePath)) {
            FormAccessLog::logAccess('soa', 'download', $filename, $filePath);
            return response()->download(storage_path('app/public/' . $filePath));
        }

        return redirect()->back()->with('error', 'File not found.');
    }

    /**
     * Get uploaded forms list
     */
    private function getUploadedForms()
    {
        $forms = [];
        $uploadPath = storage_path('app/public/forms/soa/uploads');

        if (File::exists($uploadPath)) {
            $files = File::files($uploadPath);

            foreach ($files as $file) {
                $forms[] = [
                    'filename' => $file->getFilename(),
                    'name' => $file->getFilename(),
                    'size' => $this->formatFileSize($file->getSize()),
                    'path' => $file->getPathname(),
                    'modified' => date('Y-m-d H:i:s', $file->getMTime()),
                ];
            }
        }

        return $forms;
    }

    /**
     * Format file size
     */
    private function formatFileSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    /**
     * Preview uploaded SOA form
     */
    public function soaPreview(Request $request)
    {
        $filename = $request->get('file');
        $filePath = 'forms/soa/uploads/' . $filename;

        if (Storage::disk('public')->exists($filePath)) {
            // For now, redirect to download - in future, implement proper preview
            return response()->download(storage_path('app/public/' . $filePath));
        }

        return response()->json(['error' => 'File not found'], 404);
    }


    /**
     * Preview SOA template
     */
    public function soaTemplatePreview(Request $request)
    {
        $templateName = $request->get('template');
        $templatePath = public_path('forms/soa/' . $templateName . '.docx');

        if (File::exists($templatePath)) {
            FormAccessLog::logAccess('soa', 'preview', $templateName, 'forms/soa/' . $templateName . '.docx');
            return view('resources.soa-preview', [
                'templateName' => $templateName,
                'templatePath' => $templatePath,
                'originalFileUrl' => asset('forms/soa/' . $templateName . '.docx')
            ]);
        }

        return redirect()->back()->with('error', 'Template not found. Please place the file in public/forms/soa/ directory.');
    }



    /**
     * Download SOA template
     */
    public function soaTemplateDownload(Request $request)
    {
        $templateName = $request->get('template');
        $templatePath = public_path('forms/soa/' . $templateName . '.docx');

        if (File::exists($templatePath)) {
            FormAccessLog::logAccess('soa', 'download', $templateName, 'forms/soa/' . $templateName . '.docx');
            return response()->download($templatePath);
        }

        return redirect()->back()->with('error', 'Template not found. Please place the file in public/forms/soa/ directory.');
    }

    /**
     * Preview GTC template
     */
    public function gtcTemplatePreview(Request $request)
    {
        $templateName = $request->get('template');
        $templatePath = public_path('forms/gtc/' . $templateName . '.docx');

        if (File::exists($templatePath)) {
            FormAccessLog::logAccess('gtc', 'preview', $templateName, 'forms/gtc/' . $templateName . '.docx');
            return view('resources.gtc-preview', [
                'templateName' => $templateName,
                'templatePath' => $templatePath,
                'originalFileUrl' => asset('forms/gtc/' . $templateName . '.docx')
            ]);
        }

        return redirect()->back()->with('error', 'Template not found. Please place the file in public/forms/gtc/ directory.');
    }

    /**
     * Download GTC template
     */
    public function gtcTemplateDownload(Request $request)
    {
        $templateName = $request->get('template');
        $templatePath = public_path('forms/gtc/' . $templateName . '.docx');

        if (File::exists($templatePath)) {
            FormAccessLog::logAccess('gtc', 'download', $templateName, 'forms/gtc/' . $templateName . '.docx');
            return response()->download($templatePath);
        }

        return redirect()->back()->with('error', 'Template not found. Please place the file in public/forms/gtc/ directory.');
    }

    /**
     * Upload GTC forms
     */
    public function gtcUpload(Request $request)
    {
        $request->validate([
            'forms.*' => 'required|file|mimes:doc,docx|max:10240', // 10MB max per file
        ]);

        $uploadedFiles = [];
        $uploadPath = 'forms/gtc/uploads';

        if ($request->hasFile('forms')) {
            foreach ($request->file('forms') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs($uploadPath, $filename, 'public');
                $uploadedFiles[] = $filename;

                FormAccessLog::logAccess('gtc', 'upload', $filename, $uploadPath . '/' . $filename);
            }
        }

        return redirect()->route('resources.gtc')->with('success',
            count($uploadedFiles) . ' form(s) uploaded successfully!');
    }

    /**
     * Download specific GTC form
     */
    public function gtcDownloadFile(Request $request)
    {
        $filename = $request->get('file');
        $filePath = 'forms/gtc/uploads/' . $filename;

        if (Storage::disk('public')->exists($filePath)) {
            FormAccessLog::logAccess('gtc', 'download', $filename, $filePath);
            return response()->download(storage_path('app/public/' . $filePath));
        }

        return redirect()->back()->with('error', 'File not found.');
    }

    /**
     * Preview uploaded GTC form
     */
    public function gtcPreview(Request $request)
    {
        $filename = $request->get('file');
        $filePath = 'forms/gtc/uploads/' . $filename;

        if (Storage::disk('public')->exists($filePath)) {
            // For now, redirect to download - in future, implement proper preview
            return response()->download(storage_path('app/public/' . $filePath));
        }

        return response()->json(['error' => 'File not found'], 404);
    }

    /**
     * Manage SOA forms
     */
    public function manageSoa()
    {
        $forms = ResourceForm::byCategory('soa')->ordered()->get();
        $formsBySubcategory = $forms->groupBy('subcategory');

        return view('resources.manage-soa', [
            'formsBySubcategory' => $formsBySubcategory,
            'allForms' => $forms
        ]);
    }

    /**
     * Manage GTC forms
     */
    public function manageGtc()
    {
        $forms = ResourceForm::byCategory('gtc')->ordered()->get();
        $formsBySubcategory = $forms->groupBy('subcategory');

        return view('resources.manage-gtc', [
            'formsBySubcategory' => $formsBySubcategory,
            'allForms' => $forms
        ]);
    }

    /**
     * Manage POD forms
     */
    public function managePod()
    {
        $forms = ResourceForm::byCategory('pod')->ordered()->get();

        return view('resources.manage-pod', [
            'forms' => $forms
        ]);
    }

    /**
     * Store a new resource form
     */
    public function storeForm(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subcategory' => 'nullable|string|max:255',
            'template_filename' => 'nullable|string|max:255',
            'display_order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean'
        ]);

        // Determine category from referer
        $referer = $request->headers->get('referer');
        $category = 'soa'; // default

        if (str_contains($referer, 'manage-gtc')) {
            $category = 'gtc';
        } elseif (str_contains($referer, 'manage-pod')) {
            $category = 'pod';
        }

        $validated['category'] = $category;
        // Set is_active to true by default for new forms
        $validated['is_active'] = true;

        ResourceForm::create($validated);

        return redirect()->back()->with('success', 'Form added successfully!');
    }

    /**
     * Update a resource form
     */
    public function updateForm(Request $request, $id)
    {
        $form = ResourceForm::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subcategory' => 'nullable|string|max:255',
            'template_filename' => 'nullable|string|max:255',
            'display_order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean'
        ]);

        // Keep is_active as true by default, don't change it during updates
        // (since we removed the checkbox from the form)

        $form->update($validated);

        return redirect()->back()->with('success', 'Form updated successfully!');
    }

    /**
     * Delete a resource form
     */
    public function destroyForm($id)
    {
        $form = ResourceForm::findOrFail($id);
        $form->delete();

        return redirect()->back()->with('success', 'Form deleted successfully!');
    }

    /**
     * Upload form template file
     */
    public function uploadFormFile(Request $request, $id)
    {
        $form = ResourceForm::findOrFail($id);

        $request->validate([
            'template_file' => 'required|file|mimes:doc,docx,pdf|max:10240', // 10MB max
        ]);

        if ($request->hasFile('template_file')) {
            $file = $request->file('template_file');
            $category = $form->category; // soa, gtc, or pod

            // Create directory if it doesn't exist
            $uploadPath = "forms/{$category}";

            // Generate filename
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $fullFilename = $filename . '.' . $extension;

            // Store file in public directory
            $file->move(public_path($uploadPath), $fullFilename);

            // Update form template_filename
            $form->update([
                'template_filename' => $filename
            ]);

            return redirect()->back()->with('success', 'File uploaded successfully!');
        }

        return redirect()->back()->with('error', 'No file was uploaded.');
    }

}

