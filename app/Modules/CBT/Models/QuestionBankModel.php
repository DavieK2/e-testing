<?php

namespace App\Modules\CBT\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionBankModel extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'question_banks';

    protected $guarded = ['uuid'];

    protected $primaryKey = 'uuid';

    public function questions()
    {
        return $this->hasMany(QuestionModel::class, 'question_bank_id');
    }
}
