<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationDocument extends Model
{
    use HasFactory;

    protected $table = 'evaluation_document';

    protected $primaryKey = 'evaDocId';

    protected $fillable = [
        'stuId',
        'evaCriId',
        'docScore',
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
