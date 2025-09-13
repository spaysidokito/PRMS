<?php

namespace App\Livewire;

use App\Models\StudentProfile;
use Livewire\Component;

class DashboardStats extends Component
{
    public function render()
    {
        $stats = [
            'total_students' => StudentProfile::count(),
            'active_students' => StudentProfile::where('status', 'active')->count(),
            'dropped_students' => StudentProfile::where('status', 'dropped')->count(),
            'graduated_students' => StudentProfile::where('status', 'graduated')->count(),
            'events' => 0, // This will be updated when you implement the events feature
        ];

        return view('livewire.dashboard-stats', [
            'stats' => $stats
        ]);
    }
}
