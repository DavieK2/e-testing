<?php

namespace App\Modules\CBT\Models;

use App\Modules\SchoolManager\Models\ClassModel;
use App\Modules\SchoolManager\Models\SubjectModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicModel extends Model
{
    use HasFactory;

    protected $table = 'topics';

    protected $guarded = [];

    public function subjects()
    {
        return $this->belongsToMany(SubjectModel::class, 'class_topics', 'topic_id', 'subject_id')->withPivot(['class_id']);
    }

    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'class_topics', 'topic_id', 'class_id')->withPivot(['subject_id']);
    }
}
