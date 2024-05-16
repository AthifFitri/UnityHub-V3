<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Coach extends Authenticatable
{
    use Notifiable;

    protected $table = "coach";
    protected $primaryKey = 'coachId';

    protected $fillable = [
        'coachName',
        'coachPhone',
        'coachEmail',
        'coachPassword',
        'indId'
    ];

    protected $hidden = [
        'coachPassword',
    ];

    public function getAuthIdentifierName()
    {
        return 'coachEmail';
    }

    public function getAuthPassword()
    {
        return $this->coachPassword;
    }

    public function getRoleAttribute()
    {
        return 'coach';
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class, 'indId');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'coachId');
    }
}
