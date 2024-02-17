<?php

namespace App\Modules\CBT\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResultsModel extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'assessment_results';

    protected $guarded = ['uuid'];
    protected $primaryKey = 'uuid';

    
}
