<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $table = 'assessments';

    protected $primaryKey = 'assessmentId';

    protected $fillable = [
        'assessmentName',
        'assessmentDescription',
    ];

    public function assessmentType()
    {
        return $this->hasMany(Evaluation::class, 'assessmentId');
    }
}
