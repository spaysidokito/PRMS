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
    public $accountStatusFilter = 'all'; // all, active, inactive
    public $departmentFilter = 'all';
    public $courseFilter = 'all';
    public $yearFilter = 'all';
    public $confirmingToggle = false;
    public $studentToToggle = null;
    public $toggleAction = '';

    protected $queryString = ['search', 'sortField', 'sortDirection', 'accountStatusFilter', 'departmentFilter', 'courseFilter', 'yearFilter'];

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

    public function filterByAccountStatus($status)
    {
        $this->accountStatusFilter = $status;
        $this->resetPage();
    }

    public function updatingDepartmentFilter()
    {
        $this->resetPage();
    }

    public function updatingCourseFilter()
    {
        $this->resetPage();
    }

    public function updatingYearFilter()
    {
        $this->resetPage();
    }

    public function confirmToggle($studentId, $action)
    {
        $this->confirmingToggle = true;
        $this->studentToToggle = $studentId;
        $this->toggleAction = $action;
    }

    public function toggleStudentStatus()
    {
        if ($this->studentToToggle) {
            $student = StudentProfile::with('user')->find($this->studentToToggle);
            if ($student && $student->user) {
                $student->user->is_active = $this->toggleAction === 'activate';
                $student->user->save();

                $message = $this->toggleAction === 'activate'
                    ? 'Student account activated successfully.'
                    : 'Student account deactivated successfully.';
                session()->flash('message', $message);
            }
        }

        $this->confirmingToggle = false;
        $this->studentToToggle = null;
        $this->toggleAction = '';
    }

    public function render()
    {
        $students = StudentProfile::with('user')
            ->where(function ($query) {
                $query->where('student_id', 'like', '%' . $this->search . '%')
                      ->orWhere('first_name', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%')
                      ->orWhere('course', 'like', '%' . $this->search . '%')
                      ->orWhere('year_level', 'like', '%' . $this->search . '%')
                      ->orWhere('department_cluster', 'like', '%' . $this->search . '%');
            })
            ->when($this->accountStatusFilter === 'active', function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('is_active', true);
                });
            })
            ->when($this->accountStatusFilter === 'inactive', function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('is_active', false);
                });
            })
            ->when($this->departmentFilter !== 'all', function ($query) {
                $query->where('department_cluster', $this->departmentFilter);
            })
            ->when($this->courseFilter !== 'all', function ($query) {
                $query->where('course', $this->courseFilter);
            })
            ->when($this->yearFilter !== 'all', function ($query) {
                $query->where('year_level', $this->yearFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        // Get counts for filter badges
        $activeCount = StudentProfile::whereHas('user', function ($q) {
            $q->where('is_active', true);
        })->count();

        $inactiveCount = StudentProfile::whereHas('user', function ($q) {
            $q->where('is_active', false);
        })->count();

        $totalCount = StudentProfile::whereHas('user')->count();

        // Get unique values for filters
        $departments = StudentProfile::select('department_cluster')
            ->distinct()
            ->orderBy('department_cluster')
            ->pluck('department_cluster');

        $courses = StudentProfile::select('course')
            ->distinct()
            ->orderBy('course')
            ->pluck('course');

        $years = StudentProfile::select('year_level')
            ->distinct()
            ->orderBy('year_level')
            ->pluck('year_level');

        return view('livewire.student-profiles-table', [
            'students' => $students,
            'activeCount' => $activeCount,
            'inactiveCount' => $inactiveCount,
            'totalCount' => $totalCount,
            'departments' => $departments,
            'courses' => $courses,
            'years' => $years,
        ]);
    }
}
