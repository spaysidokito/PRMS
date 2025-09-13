<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    // Helper methods to check role
    public function isAdmin()
    {
        return $this->slug === 'admin';
    }

    public function isFacultyStaff()
    {
        return $this->slug === 'faculty-staff';
    }

    public function isStudent()
    {
        return $this->slug === 'student';
    }
}
