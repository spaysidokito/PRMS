<?php

namespace App\Http\Controllers;

use App\Models\FormAccessLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Display analytics dashboard
     */
    public function index(Request $request)
    {
        // Check if user is Faculty/Staff or Admin
        if (!auth()->user()->canEdit()) {
            abort(403, 'Unauthorized access. Only Faculty/Staff and Administrators can view analytics.');
        }

        $formType = $request->get('form_type', 'all');
        $days = $request->get('days', 30);
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        // Get summary statistics
        $stats = FormAccessLog::getSummaryStats($formType === 'all' ? null : $formType, $days);

        // Get recent activity
        $query = FormAccessLog::with('user')->orderBy('created_at', 'desc');

        if ($formType !== 'all') {
            $query->where('form_type', $formType);
        }

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $recentActivity = $query->paginate(50);

        // Get daily activity chart data (last 30 days)
        $dailyActivity = FormAccessLog::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total'),
                'action'
            )
            ->where('created_at', '>=', now()->subDays($days))
            ->when($formType !== 'all', function($q) use ($formType) {
                return $q->where('form_type', $formType);
            })
            ->groupBy('date', 'action')
            ->orderBy('date')
            ->get()
            ->groupBy('date');

        // Get top users
        $topUsers = FormAccessLog::select('user_id', DB::raw('COUNT(*) as access_count'))
            ->with('user')
            ->where('created_at', '>=', now()->subDays($days))
            ->when($formType !== 'all', function($q) use ($formType) {
                return $q->where('form_type', $formType);
            })
            ->groupBy('user_id')
            ->orderByDesc('access_count')
            ->limit(10)
            ->get();

        // Get most accessed forms
        $topForms = FormAccessLog::select('form_name', 'form_type', DB::raw('COUNT(*) as access_count'))
            ->whereNotNull('form_name')
            ->where('created_at', '>=', now()->subDays($days))
            ->when($formType !== 'all', function($q) use ($formType) {
                return $q->where('form_type', $formType);
            })
            ->groupBy('form_name', 'form_type')
            ->orderByDesc('access_count')
            ->limit(10)
            ->get();

        return view('analytics.index', compact(
            'stats',
            'recentActivity',
            'dailyActivity',
            'topUsers',
            'topForms',
            'formType',
            'days',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Export analytics data
     */
    public function export(Request $request)
    {
        // Check if user is Faculty/Staff or Admin
        if (!auth()->user()->canEdit()) {
            abort(403, 'Unauthorized access.');
        }

        $formType = $request->get('form_type', 'all');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $query = FormAccessLog::with('user')->orderBy('created_at', 'desc');

        if ($formType !== 'all') {
            $query->where('form_type', $formType);
        }

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $logs = $query->get();

        $filename = 'form-analytics-' . now()->format('Y-m-d-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($logs) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, ['Date/Time', 'User', 'Email', 'Form Type', 'Form Name', 'Action', 'IP Address']);

            // Add data rows
            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->created_at->format('Y-m-d H:i:s'),
                    $log->user ? $log->user->name : 'Guest',
                    $log->user ? $log->user->email : 'N/A',
                    strtoupper($log->form_type),
                    $log->form_name ?? 'N/A',
                    ucfirst($log->action),
                    $log->ip_address ?? 'N/A',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
