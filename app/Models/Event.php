<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'venue',
        'type',
        'status',
        'max_participants',
        'budget',
        'created_by',
        'requirements',
        'attachments'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'requirements' => 'array',
        'attachments' => 'array',
        'budget' => 'decimal:2'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function participants()
    {
        return $this->belongsToMany(StudentProfile::class, 'event_participants')
            ->withTimestamps()
            ->withPivot(['status', 'attendance_status']);
    }

    public function resources()
    {
        return $this->belongsToMany(Resource::class, 'event_resources')
            ->withTimestamps()
            ->withPivot(['quantity', 'notes']);
    }
}
