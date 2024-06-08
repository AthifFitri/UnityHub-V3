<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationFinalPresent extends Model
{
    use HasFactory;

    protected $table = 'evaluation_final_presentation';

    protected $primaryKey = 'evaFinalPresentId';

    protected $fillable = [
        'stuId',
        'plo',
        'evaCriId',
        'finalPresentScore',
    ];

    public function studentDetails()
    {
        return $this->belongsTo(Student::class);
    }

    public function criteria()
    {
        return $this->belongsTo(EvaluationCriteria::class);
    }
}
