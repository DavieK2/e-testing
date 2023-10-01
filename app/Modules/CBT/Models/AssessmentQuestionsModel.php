<?php

namespace App\Modules\CBT\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentQuestionsModel extends Model
{
    use HasFactory;

    protected $table = 'assessment_questions';
    protected $guarded = ['id'];
}
