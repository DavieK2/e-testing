<?php

namespace App\Http\Middleware;

use App\Modules\CBT\Models\ExamResultsModel;
use Closure;
use Illuminate\Http\Request;

class CBTExamSessionMiddleware
{
    
    public function handle(Request $request, Closure $next)
    {
        $student = auth()->guard('student')->user() ?? $request->user();
        $assessment = $request->route('assessment');

        // dd(request('subjectId'));

        if( $assessment->is_standalone ){

            $session = ExamResultsModel::where('student_profile_id', $student->id)->where('assessment_id', $assessment->id)->first();

            // if( $session && $session->has_submitted ) abort(403, 'You have already completed this exam');
            // if( $session && $session->time_remaining <= 0 ) abort(403, 'You have already completed this exam');
            // if( $session && $session->tries <= 0 ) abort(403, 'You exceeded your number of retries');

        }

        return $next($request);
    }
}
