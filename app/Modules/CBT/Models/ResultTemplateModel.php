<?php

namespace App\Modules\CBT\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultTemplateModel extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'uuid';
    protected $guarded = ['uuid'];

    protected $table = 'result_templates';
    
}
