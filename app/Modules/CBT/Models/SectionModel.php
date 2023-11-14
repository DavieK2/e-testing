<?php

namespace App\Modules\CBT\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionModel extends Model
{
    use HasFactory;

    protected $table = 'sections';
    protected $guarded = [];
    
}
