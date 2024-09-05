<?php

namespace App\Modules\CBT\Enums;


enum QuizContributorsEnum : string 
{
    case NONE = 'none';
    case ALL_TEACHERS = 'all_teachers';
    case SELECTED_TEACHERS = 'selected_teachers';


    public static function getAllValues() : array
    {
        return collect( self::cases() )->flatMap( fn($value) => [ $value->value ] )->toArray();
    }

}
