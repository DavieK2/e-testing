<?php

namespace App\Modules\SchoolManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicSessionModel extends Model
{
    use HasFactory;

    protected $table = 'academic_sessions';
    protected $guarded = ['id'];
}
