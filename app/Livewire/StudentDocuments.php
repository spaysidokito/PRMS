<?php

namespace App\Livewire;

use App\Models\StudentDocument;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentDocuments extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'tailwind';

    public $search = '';
    public $filterType = 'all';
    public $showUploadModal = false;
    public $confirmingDelete = false;
    public $documentToDelete = null;

    // Upload form fields
    public $title = '';
    public $document_type = '';
    public $description = '';
    public $file;

    protected $queryString = ['search', 'filterType'];

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'document_type' => 'required|string|in:receipt,permit,id,certificate,memo,report,contract,invoice,other',
            'description' => 'nullable|string|max:1000',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:10240', // 10MB
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function filterByType($type)
    {
        $this->filterType = $type;
        $this->resetPage();
    }

    public function openUploadModal()
    {
        $this->resetForm();
        $this->showUploadModal = true;
    }

    public function uploadDocument()
    {
        $this->validate();

        $fileName = time() . '_' . $this->file->getClientOriginalName();
        $filePath = $this->file->storeAs('student-documents/' . Auth::id(), $fileName, 'public');

        StudentDocument::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'document_type' => $this->document_type,
            'description' => $this->description,
            'file_path' => $filePath,
            'file_name' => $this->file->getClientOriginalName(),
            'file_type' => $this->file->getMimeType(),
            'file_size' => $this->file->getSize(),
        ]);

        session()->flash('message', 'Document uploaded successfully.');
        $this->resetForm();
    }

    public function confirmDelete($documentId)
    {
        $this->confirmingDelete = true;
        $this->documentToDelete = $documentId;
    }

    public function deleteDocument()
    {
        $document = StudentDocument::where('user_id', Auth::id())->find($this->documentToDelete);

        if ($document) {
            Storage::disk('public')->delete($document->file_path);
            $document->delete();
            session()->flash('message', 'Document deleted successfully.');
        }

        $this->confirmingDelete = false;
        $this->documentToDelete = null;
    }

    public function resetForm()
    {
        $this->title = '';
        $this->document_type = '';
        $this->description = '';
        $this->file = null;
        $this->showUploadModal = false;
        $this->reset(['title', 'document_type', 'description', 'file']);
    }

    public function render()
    {
        $documents = StudentDocument::where('user_id', Auth::id())
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
                      ->orWhere('file_name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterType !== 'all', function ($query) {
                $query->where('document_type', $this->filterType);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // Get counts for filter badges
        $counts = StudentDocument::where('user_id', Auth::id())
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN document_type = "receipt" THEN 1 ELSE 0 END) as receipt,
                SUM(CASE WHEN document_type = "permit" THEN 1 ELSE 0 END) as permit,
                SUM(CASE WHEN document_type = "id" THEN 1 ELSE 0 END) as id,
                SUM(CASE WHEN document_type = "certificate" THEN 1 ELSE 0 END) as certificate,
                SUM(CASE WHEN document_type = "memo" THEN 1 ELSE 0 END) as memo,
                SUM(CASE WHEN document_type = "report" THEN 1 ELSE 0 END) as report,
                SUM(CASE WHEN document_type = "contract" THEN 1 ELSE 0 END) as contract,
                SUM(CASE WHEN document_type = "invoice" THEN 1 ELSE 0 END) as invoice,
                SUM(CASE WHEN document_type = "other" THEN 1 ELSE 0 END) as other
            ')->first();

        return view('livewire.student-documents', [
            'documents' => $documents,
            'counts' => $counts,
        ]);
    }
}
