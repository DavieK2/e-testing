<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Most</title>
</head>
<body>
    <h1>Web server</h1>
</body>
</html>

<?php

function patternChaser($str){
    
    $i = 2 ;

    $j = round( strlen($str) / 2 );

    while ( $i <= $j ){
        findPattern($i++, $str);
    }
}

function findPattern($number, $str) {

    $patterns = [];

    for( $i = 0 ; $i < ( strlen($str) - $number ) ; $i ++){

        $pattern = substr($str, $i, $i + $number);
        
        $str_index = strpos( $pattern, $i );
        
        if( $str_index && $str_index != $i){

            $patterns[] = $pattern;

            break;
        }

    }
    dd( $patterns );
}
