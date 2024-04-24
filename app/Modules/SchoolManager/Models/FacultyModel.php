<?php

namespace App\Modules\SchoolManager\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacultyModel extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'uuid';
    protected $guarded = ['uuid'];
    protected $table = 'faculties';
}
