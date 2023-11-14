<?php

namespace App\Modules\CBT\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\CBT\Models\TopicModel;
use App\Modules\CBT\Requests\CreateTopicRequest;
use App\Modules\CBT\Requests\GetTopicRequest;
use App\Modules\CBT\Requests\UpdateTopicRequest;
use App\Modules\SchoolManager\Models\ClassModel;
use App\Modules\SchoolManager\Models\SubjectModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TopicController extends Controller
{
    public function create(CreateTopicRequest $request)
    {
        $data = $request->validated();

        $topic = TopicModel::create([
            'uuid'  => Str::ulid(),
            'title' => $data['title']
        ]);

        $topic->classes()->detach();

        collect($data['classes'])->each(function($class) use($topic, $data){

            $classId = ClassModel::firstWhere('class_code', $class)->id;

            DB::table('class_topics')
                ->insert(['class_id' => $classId, 'subject_id' => $data['subjectId'], 'uuid' => Str::ulid(), 'topic_id' => $topic->id ]);
           
        });

        return response()->json([
            'message' => 'Topics Successfully added'
        ]);
    }

    public function update(UpdateTopicRequest $request)
    {
        $data = $request->validated();

        $topic = TopicModel::firstWhere('uuid', $data['topicId']);

        $topic->update(['title' => $data['title'] ]);

        $topic->classes()->detach();

        collect($data['classes'])->each(function($class) use($topic, $data){

            $classId = ClassModel::firstWhere('class_code', $class['classCode'])->id;

            DB::table('class_topics')
                ->insert(['class_id' => $classId, 'subject_id' => $data['subjectId'], 'uuid' => $class['classId'] ?? Str::ulid(), 'topic_id' => $topic->id ]);
           
        });

        return response()->json([
            'message' => 'Topics Successfully Updated'
        ]);

    }

    public function getTopics(GetTopicRequest $request)
    {
        $data = $request->validated();

        $classId = ClassModel::firstWhere('class_code', $data['classId'])->id;

        $topics = DB::table('class_topics')->where( fn($query) => $query->where('class_topics.subject_id', $data['subjectId'])->where('class_topics.class_id', $classId) )
                    ->join('topics', 'class_topics.topic_id', '=', 'topics.id')
                    ->join('subjects', 'class_topics.subject_id', '=', 'subjects.id')
                    ->join('classes', 'class_topics.class_id', '=', 'classes.id')
                    ->select('subjects.subject_name as subject', 'classes.class_name as class', 'topics.title as topic', 'topics.uuid as topicId')
                    ->get();
        

        return response()->json([
            'data' => $topics
        ]);
    }

    public function getClasses(TopicModel $topic, SubjectModel $subject)
    {
        $classes = DB::table('class_topics')
                    ->where( fn($query) => $query->where('class_topics.topic_id', $topic->id)->where('class_topics.subject_id', $subject->id) )
                    ->join('classes', 'class_topics.class_id', '=', 'classes.id')
                    ->select('classes.class_name', 'classes.class_code', 'class_topics.uuid as classId')
                    ->get();

        return response()->json([
            'data' => $classes
        ]);
    }
}