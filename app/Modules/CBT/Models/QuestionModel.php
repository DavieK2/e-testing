<?php

namespace App\Modules\CBT\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionModel extends Model
{
    use HasFactory;

    protected $table = 'questions';

    protected $guarded = ['id'];

    protected $casts = ['options' => 'array'];

    public function assessment()
    {
        return $this->belongsTo(AssessmentModel::class, 'assessment_id');
    }
}
