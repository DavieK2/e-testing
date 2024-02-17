<?php

namespace App\Modules\SchoolManager\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicSessionModel extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'academic_sessions';
    protected $guarded = ['uuid'];
    protected $primaryKey = 'uuid';
}
