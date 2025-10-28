<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormAccessLog extends Model
{
    use HasFactory;

    protected $table = 'resource_access_logs';

    protected $fillable = [
        'user_id',
        'form_type',
        'form_name',
        'action',
        'ip_address',
        'user_agent',
        'file_path',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who performed the action
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Log a form access
     */
    public static function logAccess($formType, $action, $formName = null, $filePath = null)
    {
        return self::create([
            'user_id' => auth()->id(),
            'form_type' => $formType,
            'form_name' => $formName,
            'action' => $action,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'file_path' => $filePath,
        ]);
    }

    /**
     * Get analytics summary
     */
    public static function getAnalytics($formType = null, $startDate = null, $endDate = null)
    {
        $query = self::with('user');

        if ($formType) {
            $query->where('form_type', $formType);
        }

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get summary statistics
     */
    public static function getSummaryStats($formType = null, $days = 30)
    {
        $query = self::query();

        if ($formType) {
            $query->where('form_type', $formType);
        }

        $query->where('created_at', '>=', now()->subDays($days));

        return [
            'total_views' => (clone $query)->where('action', 'view')->count(),
            'total_downloads' => (clone $query)->where('action', 'download')->count(),
            'total_previews' => (clone $query)->where('action', 'preview')->count(),
            'total_uploads' => (clone $query)->where('action', 'upload')->count(),
            'unique_users' => (clone $query)->distinct('user_id')->count('user_id'),
            'by_form_type' => self::where('created_at', '>=', now()->subDays($days))
                ->selectRaw('form_type, action, count(*) as count')
                ->groupBy('form_type', 'action')
                ->get()
                ->groupBy('form_type'),
        ];
    }
}
