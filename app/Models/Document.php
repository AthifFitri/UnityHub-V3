<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $primaryKey = 'docId';

    protected $fillable = [
        'stuId',
        'docType',
        'docTitle',
        'docContent',
        'deadline'
    ];

    public function studentDetails()
    {
        return $this->belongsTo(Student::class, 'stuId');
    }
}
