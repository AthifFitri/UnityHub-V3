<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffPosition extends Model
{
    use HasFactory;

    protected $table = "position";

    protected $primaryKey = 'posId';

    protected $fillable = [
        'posId',
        'posName',
    ];

    public function universityStaffs(){
        return $this->hasMany(UniversityStaff::class, 'posId');
    }
}
