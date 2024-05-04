<?php

namespace App\Modules\CBT\Models;

use App\Modules\SchoolManager\Models\ClassModel;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionModel extends Model
{
    const QUESTION_TYPES = [ 'objectives', 'theory' ];

    use HasFactory, HasUlids, SoftDeletes;

    protected $table = 'questions';

    protected $guarded = ['uuid'];
    protected $primaryKey = 'uuid';

    protected $casts = ['options' => 'array'];

    public function assessment()
    {
        return $this->belongsTo( AssessmentModel::class, 'assessment_id' );
    }

    public function questionBank()
    {
        return $this->belongsTo( QuestionBankModel::class, 'question_bank_id');
    }

    public function classes()
    {
        return $this->belongsToMany( ClassModel::class, 'class_questions', 'question_id', 'class_id')->withPivot(['uuid'] );
    }
}
