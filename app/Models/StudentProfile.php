<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'first_name',
        'last_name',
        'middle_name',
        'birth_date',
        'gender',
        'address',
        'contact_number',
        'email',
        'course',
        'year_level',
        'section',
        'status',
        'emergency_contact',
        'medical_information',
        'department_cluster',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
        'emergency_contact' => 'array',
        'medical_information' => 'array',
    ];

    /**
     * Get the full name of the student.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        $fullName = $this->first_name;
        if ($this->middle_name) {
            $fullName .= ' ' . substr($this->middle_name, 0, 1) . '.';
        }
        $fullName .= ' ' . $this->last_name;
        return $fullName;
    }
}
