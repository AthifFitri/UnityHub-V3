<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationScore extends Model
{
    use HasFactory;

    protected $table = 'evaluation_score';

    protected $primaryKey = 'evaScoreId';

    protected $fillable = [
        'stuId',
        'plo',
        'evaCriId',
        'score',
    ];

    public function studentDetails()
    {
        return $this->belongsTo(Student::class, 'stuId');
    }

    public function criteria()
    {
        return $this->belongsTo(EvaluationCriteria::class, 'evaCriId');
    }
}
