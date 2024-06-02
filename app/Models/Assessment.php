<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $primaryKey = 'assessId';

    protected $fillable = [
        'assessName',
        'assessDescription',
    ];

    public function essessmentType()
    {
        return $this->hasMany(Evaluation::class, 'assessId');
    }
}
