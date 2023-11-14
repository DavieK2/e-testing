<?php

namespace App\Modules\SchoolManager\Models;

use App\Modules\CBT\Models\TopicModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectModel extends Model
{
    use HasFactory;

    protected $table = 'subjects';

    protected $guarded = ['id'];

    public function topics()
    {
        return $this->belongsToMany(TopicModel::class, 'subject_topics', 'subject_id', 'topic_id')->withPivot(['class_id']);
    }
}
