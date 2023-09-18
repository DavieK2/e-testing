<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportDatabaseCommand extends Command
{
    protected $signature = 'app:import-database';
    protected $description = 'Command description';

    public function handle()
    {
        DB::unprepared(file_get_contents(base_path('student_profiles.sql')));
        // DB::unprepared(file_get_contents(base_path('student_subjects.sql')));
    }
}
