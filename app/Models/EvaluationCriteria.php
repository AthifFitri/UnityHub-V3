<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationCriteria extends Model
{
    use HasFactory;

    protected $table = 'evaluation_criteria';
    protected $primaryKey = 'evaCriId';

    protected $fillable = [
        'evaId',
        'criteria',
        'weight',
    ];

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class, 'evaId');
    }
}
