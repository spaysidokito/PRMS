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
    public $first_name = '';
    public $middle_name = '';
    public $last_name = '';
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
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
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

        // Parse the full name back into components
        $nameParts = explode(' ', $user->name);
        $this->first_name = $nameParts[0] ?? '';
        $this->last_name = end($nameParts);

        // Check for middle initial (ends with .)
        if (count($nameParts) > 2) {
            $middlePart = $nameParts[1];
            if (substr($middlePart, -1) === '.') {
                $this->middle_name = rtrim($middlePart, '.');
            } else {
                // If no period, it might be part of first name or a full middle name
                $this->middle_name = $middlePart;
            }
        } else {
            $this->middle_name = '';
        }

        $this->email = $user->email;
        $this->selectedRole = $user->roles->first()->id ?? '';
        $this->showUserModal = true;
    }

    public function saveUser()
    {
        $validatedData = $this->validate();

        // Build full name
        $fullName = $validatedData['first_name'];
        if (!empty($validatedData['middle_name'])) {
            $fullName .= ' ' . substr($validatedData['middle_name'], 0, 1) . '.';
        }
        $fullName .= ' ' . $validatedData['last_name'];

        // Check if user with this exact name already exists
        $existingUser = User::where('name', $fullName);
        if ($this->isEditing) {
            $existingUser = $existingUser->where('id', '!=', $this->userId);
        }

        if ($existingUser->exists()) {
            $this->addError('first_name', 'A user with the name "' . $fullName . '" already exists in the system.');
            return;
        }

        // Also check if a user with the same first and last name exists (regardless of middle name)
        $firstName = $validatedData['first_name'];
        $lastName = $validatedData['last_name'];

        $similarUsers = User::where(function($query) use ($firstName, $lastName) {
            $query->where('name', 'LIKE', $firstName . ' %' . $lastName)
                  ->orWhere('name', $firstName . ' ' . $lastName);
        });

        if ($this->isEditing) {
            $similarUsers = $similarUsers->where('id', '!=', $this->userId);
        }

        if ($similarUsers->exists()) {
            $existingName = $similarUsers->first()->name;
            $this->addError('first_name', 'A user with a similar name "' . $existingName . '" already exists. Please use a different first or last name.');
            return;
        }

        if ($this->isEditing) {
            $user = User::find($this->userId);
            $user->name = $fullName;
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
                'name' => $fullName,
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
        $this->first_name = '';
        $this->middle_name = '';
        $this->last_name = '';
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
