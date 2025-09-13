<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class EventManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'start_date';
    public $sortDirection = 'asc';
    public $confirmingEventDeletion = false;
    public $eventToDelete = null;

    protected $queryString = ['search', 'sortField', 'sortDirection'];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function confirmEventDeletion($eventId)
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user || !$user->canDelete()) {
            session()->flash('error', 'You do not have permission to delete events.');
            return;
        }

        $this->confirmingEventDeletion = true;
        $this->eventToDelete = $eventId;
    }

    public function deleteEvent()
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user || !$user->canDelete()) {
            session()->flash('error', 'You do not have permission to delete events.');
            return;
        }

        $event = Event::find($this->eventToDelete);
        if ($event) {
            $event->delete();
            session()->flash('message', 'Event deleted successfully.');
        }

        $this->confirmingEventDeletion = false;
        $this->eventToDelete = null;
    }

    public function render()
    {
        $events = Event::where(function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhere('venue', 'like', '%' . $this->search . '%');
        })
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate(10);

        return view('livewire.event-management', [
            'events' => $events
        ]);
    }
}
