<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rules\Password;

class UserManagement extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $statusFilter = 'all'; // all, active, inactive
    public $confirmingUserToggle = false;
    public $userToToggle = null;
    public $toggleAction = '';

    // Create/Edit User Form
    public $userId = null;
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $selectedRole = '';
    public $showUserModal = false;
    public $isEditing = false;

    protected $queryString = ['search', 'sortField', 'sortDirection', 'statusFilter'];

    public function mount()
    {
        if (!Auth::user()->canManageUsers()) {
            return redirect()->route('dashboard');
        }
    }

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->userId],
            'password' => $this->isEditing
                ? ['nullable', 'string', Password::defaults(), 'confirmed']
                : ['required', 'string', Password::defaults(), 'confirmed'],
            'selectedRole' => ['required', 'exists:roles,id'],
        ];
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function filterByStatus($status)
    {
        $this->statusFilter = $status;
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

    public function createUser()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showUserModal = true;
    }

    public function editUser(User $user)
    {
        $this->isEditing = true;
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->selectedRole = $user->roles->first()->id ?? '';
        $this->showUserModal = true;
    }

    public function saveUser()
    {
        $validatedData = $this->validate();

        if ($this->isEditing) {
            $user = User::find($this->userId);
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            if (!empty($validatedData['password'])) {
                $user->password = Hash::make($validatedData['password']);
            }
            $user->save();

            // Update role
            $user->roles()->sync([$validatedData['selectedRole']]);

            session()->flash('message', 'User updated successfully.');
        } else {
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);

            // Assign role
            $user->roles()->attach($validatedData['selectedRole']);

            session()->flash('message', 'User created successfully.');
        }

        $this->resetForm();
    }

    public function confirmUserToggle($userId, $action)
    {
        if (!Auth::user()->canManageUsers()) {
            session()->flash('error', 'You do not have permission to manage users.');
            return;
        }

        $this->confirmingUserToggle = true;
        $this->userToToggle = $userId;
        $this->toggleAction = $action;
    }

    public function toggleUserStatus()
    {
        if (!Auth::user()->canManageUsers()) {
            session()->flash('error', 'You do not have permission to manage users.');
            return;
        }

        $user = User::find($this->userToToggle);
        if ($user && Auth::check() && $user->id !== Auth::id()) {
            $user->is_active = $this->toggleAction === 'activate';
            $user->save();

            $message = $this->toggleAction === 'activate'
                ? 'User activated successfully.'
                : 'User deactivated successfully.';
            session()->flash('message', $message);
        }

        $this->confirmingUserToggle = false;
        $this->userToToggle = null;
        $this->toggleAction = '';
    }

    public function resetForm()
    {
        $this->userId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->selectedRole = '';
        $this->showUserModal = false;
        $this->isEditing = false;
    }

    public function render()
    {
        $users = User::where(function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
        })
        ->when($this->statusFilter === 'active', function ($query) {
            $query->where('is_active', true);
        })
        ->when($this->statusFilter === 'inactive', function ($query) {
            $query->where('is_active', false);
        })
        ->with('roles')
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate(10);

        // Get counts for filter badges using a single optimized query
        $counts = User::selectRaw('
            COUNT(*) as total,
            SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active,
            SUM(CASE WHEN is_active = 0 THEN 1 ELSE 0 END) as inactive
        ')->first();

        // Cache roles for 1 hour since they rarely change
        $roles = Cache::remember('all_roles', 3600, function () {
            return Role::all();
        });

        return view('livewire.user-management', [
            'users' => $users,
            'roles' => $roles,
            'activeCount' => $counts->active ?? 0,
            'inactiveCount' => $counts->inactive ?? 0,
            'totalCount' => $counts->total ?? 0,
        ]);
    }
}
