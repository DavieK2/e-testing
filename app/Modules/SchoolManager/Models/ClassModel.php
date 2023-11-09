<?php

namespace App\Modules\SchoolManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes';
    protected $guarded = ['id'];

    public function subjects()
    {
        return $this->belongsToMany(SubjectModel::class, 'class_subjects', 'class_id', 'subject_id');
    }

    public function assignSubjects(array $subjectIds)
    {
        $this->subjects()->detach();

        foreach ($subjectIds as $subjectId) {
            DB::table('class_subjects')->insert(['class_id' => $this->id, 'subject_id' => $subjectId, 'uuid' => Str::ulid() ]);
        }
    }
}
