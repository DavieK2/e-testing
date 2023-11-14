<?php

namespace App\Modules\CBT\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionBankModel extends Model
{
    use HasFactory;

    protected $table = 'question_banks';

    protected $guarded = [];

    public function questions()
    {
        return $this->hasMany(QuestionModel::class, 'question_bank_id');
    }
}
