<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationLogbook extends Model
{
    use HasFactory;

    protected $table = 'evaluation_logbook';

    protected $primaryKey = 'evaLogId';

    protected $fillable = [
        'stuId',
        'evaCriId',
        'logScore',
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
