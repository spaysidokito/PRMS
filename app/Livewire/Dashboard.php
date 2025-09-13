<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\StudentProfile;
use Livewire\Component;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $currentMonth;
    public $currentYear;

    public function mount()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
    }

    public function previousMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
    }

    public function nextMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
    }

    public function getCurrentMonthYearProperty()
    {
        return Carbon::create($this->currentYear, $this->currentMonth, 1)->format('F Y');
    }

    public function getCalendarDaysProperty()
    {
        try {
            $startOfMonth = Carbon::create($this->currentYear, $this->currentMonth, 1);
            $endOfMonth = $startOfMonth->copy()->endOfMonth();

            // Get the first day of the week (Sunday = 0)
            $firstDayOfWeek = $startOfMonth->copy()->startOfWeek(Carbon::SUNDAY);
            $lastDayOfWeek = $endOfMonth->copy()->endOfWeek(Carbon::SATURDAY);

            $days = [];
            $currentDate = $firstDayOfWeek->copy();

            // Get all events for the visible period (excluding soft deleted)
            $events = Event::whereBetween('start_date', [
                $firstDayOfWeek->startOfDay(),
                $lastDayOfWeek->endOfDay()
            ])->get()->groupBy(function($event) {
                return $event->start_date->format('Y-m-d');
            });

            while ($currentDate->lte($lastDayOfWeek)) {
                $dateKey = $currentDate->format('Y-m-d');
                $dayEvents = $events->get($dateKey, collect());

                $days[] = [
                    'day' => $currentDate->day,
                    'date' => $currentDate->format('Y-m-d'),
                    'isCurrentMonth' => $currentDate->month === $this->currentMonth,
                    'isToday' => $currentDate->isToday(),
                    'hasEvents' => $dayEvents->count() > 0,
                    'events' => $dayEvents,
                ];

                $currentDate->addDay();
            }

            return $days;
        } catch (\Exception $e) {
            // Return empty array if there's an error
            return [];
        }
    }

    public function getTodaysEventsProperty()
    {
        try {
            return Event::whereDate('start_date', today())
                ->orderBy('start_date', 'asc')
                ->get();
        } catch (\Exception $e) {
            return collect();
        }
    }

    public function render()
    {
        try {
            // Get statistics
            $stats = [
                'total_students' => StudentProfile::count(),
                'active_students' => StudentProfile::where('status', 'active')->count(),
                'dropped_students' => StudentProfile::where('status', 'dropped')->count(),
                'graduated_students' => StudentProfile::where('status', 'graduated')->count(),
                'total_events' => Event::count(),
            ];

            // Get upcoming events
            $upcomingEvents = Event::where('status', 'upcoming')
                ->where('start_date', '>=', now())
                ->orderBy('start_date', 'asc')
                ->take(5)
                ->get();

            // Get inactive students
            $inactiveStudents = StudentProfile::where('status', 'inactive')
                ->orderBy('updated_at', 'desc')
                ->take(5)
                ->get();

            return view('livewire.dashboard', [
                'stats' => $stats,
                'upcomingEvents' => $upcomingEvents,
                'inactiveStudents' => $inactiveStudents,
                'currentMonthYear' => $this->currentMonthYear,
                'calendarDays' => $this->calendarDays,
                'todaysEvents' => $this->todaysEvents
            ]);
        } catch (\Exception $e) {
            // Return a basic view if there's an error
            return view('livewire.dashboard', [
                'stats' => [
                    'total_students' => 0,
                    'active_students' => 0,
                    'dropped_students' => 0,
                    'graduated_students' => 0,
                    'total_events' => 0,
                ],
                'upcomingEvents' => collect(),
                'inactiveStudents' => collect(),
                'currentMonthYear' => $this->currentMonthYear,
                'calendarDays' => $this->calendarDays,
                'todaysEvents' => collect()
            ]);
        }
    }
}
