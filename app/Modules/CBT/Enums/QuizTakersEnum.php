<?php

namespace App\Modules\CBT\Enums;


enum QuizTakersEnum : string 
{
    case EVERYONE = 'everyone';
    case SELECTED_CLASSES = 'selected_classes';
    case SELECTED_STUDENTS = 'selected_students';


    public static function getAllValues() : array
    {
        return collect( self::cases() )->flatMap( fn($value) => [ $value->value ] )->toArray();
    }

}
