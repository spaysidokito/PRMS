<?php

namespace App\Http\Controllers;

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
        return view('resources.soa');
    }

    /**
     * Display GTC form
     */
    public function gtc(): View
    {
        return view('resources.gtc');
    }

    /**
     * Display POD form
     */
    public function pod(): View
    {
        return view('resources.pod');
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
     * Download POD form as PDF
     */
    public function podDownload()
    {
        // TODO: Implement PDF generation when forms are provided
        return response()->json(['message' => 'Download functionality will be implemented when forms are provided']);
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
            return response()->download($templatePath);
        }

        return redirect()->back()->with('error', 'Template not found. Please place the file in public/forms/soa/ directory.');
    }

}

