<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $primaryKey = 'evaId';

    protected $fillable = [
        'evaType',
        'courseId',
        'plo',
    ];

    public function criteria()
    {
        return $this->hasMany(EvaluationCriteria::class, 'evaId');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'courseId');
    }
}
