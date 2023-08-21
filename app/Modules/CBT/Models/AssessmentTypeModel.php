<?php

namespace App\Modules\CBT\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentTypeModel extends Model
{
    use HasFactory;

    protected $table = 'assessment_types';

    protected $guarded = ['id'];
}
