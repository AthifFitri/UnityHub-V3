<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UniversityStaff extends Authenticatable
{
    use Notifiable;

    protected $table = "staff_university";
    protected $primaryKey = 'staffId';

    protected $fillable = [
        'staffName',
        'staffEmail',
        'staffPassword',
        'staffPhone',
        'posId',
    ];

    protected $hidden = [
        'staffPassword',
    ];

    public function position()
    {
        return $this->belongsTo(StaffPosition::class, 'posId');
    }

    public function getRoleAttribute()
    {
        return $this->position->positionName;
    }

    public function getAuthIdentifierName()
    {
        return 'staffEmail';
    }

    public function getAuthPassword()
    {
        return $this->staffPassword;
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'supervisor', 'staffId');
    }
}
