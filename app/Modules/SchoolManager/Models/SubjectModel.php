<?php

namespace App\Modules\SchoolManager\Models;

use App\Modules\CBT\Models\TopicModel;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectModel extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'uuid';

    protected $table = 'subjects';

    protected $guarded = ['uuid'];

    public function topics()
    {
        return $this->belongsToMany(TopicModel::class, 'subject_topics', 'subject_id', 'topic_id')->withPivot(['class_id']);
    }

    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'class_subjects', 'subject_id', 'class_id');
    }
}
