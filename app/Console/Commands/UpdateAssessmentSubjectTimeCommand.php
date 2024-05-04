<?php

namespace App\Console\Commands;

use App\Modules\CBT\Models\AssessmentModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateAssessmentSubjectTimeCommand extends Command
{
    protected $signature = 'update:assessment';
    protected $description = 'Command description';

    public function handle()
    {
       $assessment = AssessmentModel::latest()->first();

       DB::table('assessment_subjects')
            ->where('assessment_id', $assessment->uuid)
            ->update([
                'start_date'   => now()->startOfDay()->toDateTimeString(),
                'end_date'     => now()->addDay()->startOfDay()->toDateTimeString(),
            ]);
    }
}
