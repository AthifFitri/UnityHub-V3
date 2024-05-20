<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;

    protected $primaryKey = 'logId';

    protected $fillable = [
        'stuId',
        'week',
        'start_date',
        'end_date',
        'attendance',
        'proof',
        'daily_activities',
        'knowledge_skill',
        'problem_comment',
        'status',
    ];

    public function studentDetails()
    {
        return $this->belongsTo(Student::class, 'stuId');
    }
}
