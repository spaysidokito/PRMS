<?php

namespace App\Livewire;

use App\Models\StudentProfile;
use Livewire\Component;
use Livewire\WithPagination;

class StudentProfilesTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $search = '';
    public $sortField = 'last_name'; // Default sort field
    public $sortDirection = 'asc'; // Default sort direction
    public $confirmingDelete = false;
    public $studentToDelete = null;

    protected $queryString = ['search', 'sortField', 'sortDirection'];

    protected $listeners = [];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSortField()
    {
        $this->resetPage();
    }

    public function updatingSortDirection()
    {
        $this->resetPage();
    }

    public function confirmDelete($studentId)
    {
        $this->confirmingDelete = true;
        $this->studentToDelete = $studentId;
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = false;
        $this->studentToDelete = null;
    }

    public function deleteStudent()
    {
        if ($this->studentToDelete) {
            $student = StudentProfile::find($this->studentToDelete);
            if ($student) {
                // Perform permanent delete
                $student->forceDelete();
                session()->flash('message', 'Student profile permanently deleted.');
            }
        }

        $this->confirmingDelete = false;
        $this->studentToDelete = null;
    }

    public function render()
    {
        $students = StudentProfile::where(function ($query) {
            $query->where('student_id', 'like', '%' . $this->search . '%')
                  ->orWhere('first_name', 'like', '%' . $this->search . '%')
                  ->orWhere('last_name', 'like', '%' . $this->search . '%')
                  ->orWhere('course', 'like', '%' . $this->search . '%')
                  ->orWhere('year_level', 'like', '%' . $this->search . '%')
                  ->orWhere('department_cluster', 'like', '%' . $this->search . '%');
        })
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate(10);

        return view('livewire.student-profiles-table', [
            'students' => $students,
        ]);
    }
}
