<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $confirmingUserDeletion = false;
    public $userToDelete = null;

    // Create/Edit User Form
    public $userId = null;
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $selectedRole = '';
    public $showUserModal = false;
    public $isEditing = false;

    protected $queryString = ['search', 'sortField', 'sortDirection'];

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

    public function confirmUserDeletion($userId)
    {
        if (!Auth::user()->canDelete()) {
            session()->flash('error', 'You do not have permission to delete users.');
            return;
        }

        $this->confirmingUserDeletion = true;
        $this->userToDelete = $userId;
    }

    public function deleteUser()
    {
        if (!Auth::user()->canDelete()) {
            session()->flash('error', 'You do not have permission to delete users.');
            return;
        }

        $user = User::find($this->userToDelete);
        if ($user && Auth::check() && $user->id !== Auth::id()) {
            $user->delete();
            session()->flash('message', 'User deleted successfully.');
        }

        $this->confirmingUserDeletion = false;
        $this->userToDelete = null;
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
        ->with('roles')
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate(10);

        return view('livewire.user-management', [
            'users' => $users,
            'roles' => Role::all()
        ]);
    }
}
