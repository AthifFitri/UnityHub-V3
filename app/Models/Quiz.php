<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quizes';
    protected $primaryKey = 'quizId';

    protected $fillable = [
        'course',
        'stuId',
        'score',
    ];

    public function studentInfo()
    {
        return $this->belongsTo(Student::class, 'stuId');
    }
}
