<?php

namespace App\Modules\SchoolManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermModel extends Model
{
    use HasFactory;

    protected $table = 'school_terms';
    protected $guarded = ['id'];
}
