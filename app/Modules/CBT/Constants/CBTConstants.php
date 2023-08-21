<?php

namespace App\Modules\CBT\Constants;

class CBTConstants {
    
    const CREATE_ASSESSMENT = 'create_assessment';
    const ADD_CLASSES = 'add_classes';
    const ADD_SUBJECTS = 'add_subjects';
    const COMPLETE_ASSESSMENT = 'complete_assessment';

    const ASSESSMENT_STEPS = [ self::CREATE_ASSESSMENT, self::ADD_CLASSES, self::ADD_SUBJECTS, self::COMPLETE_ASSESSMENT ];
}