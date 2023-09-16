<?php

namespace App\Modules\CBT\Models;

use App\Modules\SchoolManager\Models\StudentProfileModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckInModel extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'student_checkins';

    public function student()
    {
        return $this->belongsTo(StudentProfileModel::class, 'student_checkins', 'student_profile_id');
    }
}
