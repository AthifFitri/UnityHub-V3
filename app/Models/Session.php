<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $table = 'sessions';

    protected $primaryKey = 'sessionId';

    protected $fillable = [
        'sessionSemester',
        'sessionYear',
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'session', 'sessionId');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'sessionId');
    }
}
