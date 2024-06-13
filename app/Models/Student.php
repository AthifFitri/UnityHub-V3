<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use Notifiable;

    protected $table = "student";
    protected $primaryKey = 'stuId';

    protected $fillable = [
        'stuName',
        'stuMatricNo',
        'stuEmail',
        'stuPassword',
        'stuPhone',
        'supervisor',
        'coachId',
        'session',
    ];

    protected $hidden = [
        'stuPassword',
    ];

    public function getAuthIdentifierName()
    {
        return 'stuEmail';
    }

    public function getAuthPassword()
    {
        return $this->stuPassword;
    }

    public function getRoleAttribute()
    {
        return 'student';
    }

    public function sessionDetails()
    {
        return $this->belongsTo(Session::class, 'session', 'sessionId');
    }

    public function supervisorDetails()
    {
        return $this->belongsTo(UniversityStaff::class, 'supervisor', 'staffId');
    }

    public function coachDetails()
    {
        return $this->belongsTo(Coach::class, 'coachId');
    }
}
