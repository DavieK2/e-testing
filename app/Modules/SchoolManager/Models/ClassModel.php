<?php

namespace App\Modules\SchoolManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes';
    protected $guarded = ['id'];

    public function subjects()
    {
        return $this->belongsToMany(SubjectModel::class, 'class_subjects', 'class_id', 'subject_id');
    }

    public function assignSubjects(array $classIds)
    {
        return $this->subjects()->sync($classIds);
    }
}
