<?php

namespace App\Modules\SchoolManager\Models;

use App\Modules\CBT\Models\TopicModel;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClassModel extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'uuid';
    protected $table = 'classes';
    protected $guarded = ['uuid'];

    public function subjects()
    {
        return $this->belongsToMany(SubjectModel::class, 'class_subjects', 'class_id', 'subject_id');
    }

    public function assignSubjects(array $subjectIds)
    {
        $this->subjects()->detach();

        foreach ($subjectIds as $subjectId) {
            DB::table('class_subjects')->insert(['class_id' => $this->uuid, 'subject_id' => $subjectId, 'uuid' => Str::ulid() ]);
        }
    }

    public function topics()
    {
        return $this->belongsToMany(TopicModel::class, 'class_topics', 'class_id', 'topic_id')->withPivot(['subject_id']);
    }
}
