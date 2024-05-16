<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $primaryKey = 'matId';

    public $incrementing = false;

    protected $fillable = [
        'matType',
        'matTitle',
        'matContent'
    ];
}
