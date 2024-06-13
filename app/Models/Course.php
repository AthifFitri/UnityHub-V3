<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $primaryKey = 'courseId';

    protected $fillable = [
        'sessionId',
        'courseCode',
        'courseName',
    ];

    public function session()
    {
        return $this->belongsTo(Session::class, 'sessionId');
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'courseId');
    }
}
